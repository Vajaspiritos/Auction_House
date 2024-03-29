<?php
//a program váza ez alapján készült: https://medium.com/@cn007b/super-simple-php-websocket-example-ea2cd5893575
include '../Resources/Scriptek/ConnectToDB.php';


$NextAuction = null;
$current_AUCTION = null;
$current_AUCTION_infos = null;
$Auction_ongoing = false;
$managerSpeak;



importTexts();

echo "Prepearing for server start...\n";
$address = 'localhost';
$port = 443;

echo "Done...\n";
echo "Starting server...\n";

$SERVER = socket_create(AF_INET,SOCK_STREAM,SOL_TCP) or die("Server couldn't be created\n");

socket_set_option($SERVER, SOL_SOCKET, SO_REUSEADDR, 1) or die("Server couldn't set option\n"); //Ez arra kell, hogy ha cask úgy bezáom pl a szervert, akkor a rendszer hajlandó legyen újra használni a porott, úgy is hogy már használva van. (azért hiszi hogy még használva van mert nem volt rendesen lezárva)
socket_bind($SERVER, $address, $port) or die("Server couldn't bind to address or port\n"); 
socket_listen($SERVER) or die("Server is deaf\n"); //mert hogy can'T listen
socket_set_nonblock($SERVER);
echo "Server started and is listening for users...\n";

$CLIENTS = [$SERVER];
$INFOS = [];
$Server_user = new Client("0","gray","SZERVER",null);

$timer_start_clients = round(microtime(true));
$timer_start_auction = round(microtime(true));
//$client_limit = 0;
$auction_limit = 1; //millisec különbség 1 = minden 1. másodpercben meghívja
$sleep_time = 100;
$stage_counter = 0;
while(true){
	//$timer_end_clients = (microtime(true));
	$timer_end_auction = round(microtime(true));
	
	//if($timer_end_clients-$timer_start_clients>= $client_limit){Client_handle(); $timer_start_clients = $timer_end_clients;}
	if($timer_end_auction-$timer_start_auction>= $auction_limit){ServerAction(); $timer_start_auction = $timer_end_auction; }
	
	try{
	Client_handle();
	}catch(Exception $err){
		
		C("Hiba történt a Clientek kezelésekor: ".$err);
	}
	
	
	usleep($sleep_time*1000);
}
function ServerAction(){
	global $Auction_ongoing;
	if(!$Auction_ongoing){CheckForAuction();}else{		
		
		progressAuction();			
	}
	
}
function progressAuction(){
	global $current_AUCTION,$stage_counter;
	$wait_times = [0,40,40,30]; //[0]= Aukció elkezdése [1]=köszönés, szabályok, stb [2]= idő / item [3] elköszönés
	
	if($wait_times[$current_AUCTION->stage()] <= $stage_counter ){
		$stage_counter = 0;
		$STAGE = ($current_AUCTION->stage != 2)?++$current_AUCTION->stage:2;
		C("Advancing to next stage :".$STAGE);
		
		if($STAGE==1){
			$current_AUCTION->data ="1|".($current_AUCTION->pitch)."|".($current_AUCTION->speed)."|".($current_AUCTION->speak[0]); //stage| speaker pitch | speaker speed | text
			
			UpdateAuctions($current_AUCTION->data);
		}else if($STAGE==2){
		
			$current_AUCTION->data = "2|".($current_AUCTION->pitch)."|".($current_AUCTION->speed)."|".$current_AUCTION->speak[1][0][0];
			UpdateAuctions($current_AUCTION->data);
			array_shift($current_AUCTION->speak[1]);
			$current_AUCTION->item_cusor++;
			if(count($current_AUCTION->speak[1])==0) ++$current_AUCTION->stage;
			
		}
		
		
		
	}else $stage_counter++;
	C("time: ".$stage_counter);
}
function importTexts(){
	global $managerSpeak;
	$managerSpeak = json_decode(file_get_contents("./Resources/manager.json"),true);
	
}
function Client_handle(){
	global $CLIENTS, $SERVER, $INFOS, $Server_user,$Auction_ongoing,$current_AUCTION;
		
	$read=$CLIENTS;
	$write=null;
	$exception=null;
	
	$r = socket_select($read,$write,$exception,0);

	if($r<=0) return;
	
	//ha a readben most bennevan a server socket, akkor azt azt jelenti új user a láthatáron;
	if(in_array($SERVER,$read)){
		socket_set_block($SERVER);
		C("new user trying to connet...");
		$client= socket_accept($SERVER);
		$CLIENTS[] = $client;
		$request = socket_read($client, 5000);
		
		$key =  explode("\r\n",explode("Sec-WebSocket-Key: ",$request)[1])[0];
		//C("Key obtained:".$key);
		
		$magic = base64_encode(pack(
				'H*',
				sha1($key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')
			));
		
		$response = "HTTP/1.1 101 Switching Protocols\r\n".
					"Upgrade: websocket\r\n".
					"Connection: Upgrade\r\n".
			
					"Sec-WebSocket-Accept: ".$magic."\r\n\r\n";
		
		
		if(socket_write($client,$response, strlen($response))!==false){
			//C("Sucessfully sent back handshake response");
			C("new user gained");
		}else C("Handshake couldn't be sent");
		
		$uniq = uniqid();
		WRITE($client,"id");
		
        unset($read[array_search($SERVER, $read)]);
		socket_set_nonblock($SERVER);
	}
	if($r<=0) return;

	foreach($read as $client){
		
		
		$message=  READ($client);
		$parts = explode("|",$message);
		if($parts[0] == "error"){
			
			C("A client's message is not readable :".$message); 
			/*
			unset($CLIENTS[array_search($client, $CLIENTS)]);
			unset($INFOS[array_search(FindUser($client), $INFOS)]);
			if(FindUser($client)->Auction() != null) unset($CLIENTS[array_search(FindUser($client)->Auction(), $CLIENTS)]);
			*/
			DeleteUser($client);
			return;
		} 
		
		if($parts[0]=="ID"){
			C($message);
				$red = mt_rand(120, 255);
				$green = mt_rand(120, 255);
				$blue = mt_rand(120, 255);
				$rgbColor = "rgb($red, $green, $blue)";
			$newUser = new Client($parts[1],$rgbColor,$parts[2],$client);
			$INFOS[] = $newUser;
			BROADCAST(FORMAT("Új felhasználó csatlakozott: ".$parts[2],$Server_user));
			
		}else if($parts[0]=="AuctionClientID"){
			C("Auction client trying to find profile");
			$found = false;
			foreach($INFOS as $C){
				
				if($C->ID() == $parts[1]){
					C($C->Name()." becsatlakozott az aukcioba");
					$C->SetAuction($client);
					$found = true;
					if(!$Auction_ongoing){ 
						C("Made user wait");
						WRITE($client,"wait");
					}else{						
						WRITE($client,$current_AUCTION->data);
					}
				}else{
					C($C->ID()."!=".$parts[1]);
					
				}
				
				
			}
			if(!$found){
				C("but failed");
				WRITE($client,"retry");
				
			}
			
		}else if($parts[0]=="!get_Auction_ongoing"){
			
			if($Auction_ongoing==false)C("false");
			if($Auction_ongoing===false)C("false");
			if(!$Auction_ongoing)C("!true");
			if($Auction_ongoing==true)C("true");
			
		}else{
			$user = FindUser($client);
			if($user == null) return;
				C($user->Name().": ".$message);
				BROADCAST(FORMAT($message,$user));
		}
	}
	
}
function C($text){
	
	echo $text."\n";
	
}
function WRITE($client, $text){
    $length = strlen($text);
    $header = chr(129); // 0x1 for text frame
    if ($length <= 125) {
        $header .= chr($length);
    } elseif ($length <= 65535) {
        $header .= chr(126) . pack('n', $length); // 16-bit length
    } else {
        $header .= chr(127) . pack('NN', 0, $length); // 64-bit length (ignoring the most significant 32 bits)
    }
    $msg = $header . $text;
    socket_write($client, $msg);
	
}
function READ($client){
	
	$byte_array = unpack('C*',socket_read($client,1024) );
	if(count($byte_array)<1) return "error|weird message";
	if($byte_array[1] != 129){
				if($byte_array[1]==136){
					if(IsAuction($client)){
						FindUser($client)->Auction = null;
					}else{
					DeleteUser($client);
					}
				}else{
					C($byte_array[1]);return "error|wrong opcode|".$byte_array[1];
				}
		}
	
	$length = $byte_array[2] -128;
	if($length>125) return "error|2";
	$keys =[];
	for($i=0;$i<4;$i++){
		
		$keys[] = $byte_array[3+$i];
	}
	
	$decoded = [];
	for($i=0;$i<$length;$i++){
		
		$decoded[] = $byte_array[7+$i] ^ $keys[$i&0x3];
		
	}
		$decodedString = '';
		foreach ($decoded as $byte) {
			$decodedString .= chr($byte);
		}
			

	return $decodedString;
	}
function CheckForAuction(){
	global $NextAuction,$conn,$Auction_ongoing,$current_AUCTION_infos,$current_AUCTION;
	
	
	if(!$Auction_ongoing&&$NextAuction!=null && $NextAuction < strtotime(date("Y-m-d H:i:s"))){
		//on auction
	
		$id = $current_AUCTION_infos["ID"];
		$manager = $current_AUCTION_infos["Manager"];
		$Tier = $current_AUCTION_infos["Tier"];
		$items = $conn->query("SELECT * FROM `items` WHERE Auction_ID=".$current_AUCTION_infos["ID"])->fetch_assoc();
		
		$current_AUCTION = new Auction($current_AUCTION_infos["ID"],$current_AUCTION_infos["Manager"],$current_AUCTION_infos["Tier"],GetItemsOfAuction($conn,$current_AUCTION_infos["ID"],true));
	//	C("AUCTION:");
		//var_dump($current_AUCTION);
		$Auction_ongoing = true;
		$NextAuction = null;
		C("Starting auction");
	}else if($NextAuction==null){
		//on startup
		$auction_list = json_decode(GetAuctions($conn,1),TRUE);
		if(count($auction_list) == 0) return false;
		$NextAuction = strtotime($auction_list[0]["Date"]);
		$current_AUCTION_infos = $auction_list[0];
		C("Next auction detected: ".$NextAuction);
		return true;
	}
	
}
function Format($text,$client){
	
	return $client->Color()."|".$client->Name()."|".$client->ID()."|".$text;
	
}
function FindUser($conn){
	global $INFOS;
	foreach($INFOS as $client){
		
		if($conn == $client->Connection()||$conn == $client->Auction()){
			
			return $client;
		}
	}
}
function DeleteUser($client){
	global $CLIENTS,$INFOS;
	
	unset($CLIENTS[array_search($client, $CLIENTS)]);
	
	$user = FindUser($client);
	
	if($user != null){unset($INFOS[array_search(FindUser($client), $INFOS)]);
	C("User disconnected");}
}
function IsAuction($conn){
	global $INFOS;
	
	foreach($INFOS as $client){
		
		if($conn == $client->Auction()){
			
			return true;
		}
	}
	return false;
}
function BROADCAST($text){
	global $INFOS;
	foreach($INFOS as $client){
		
		WRITE($client->Connection(),$text);
		
	}
	
}
function UpdateAuctions($data){
	global $INFOS;
	ProcessManagerSpeech($data);
	foreach($INFOS as $client){
		
		WRITE($client->Auction(),$data);
		
	}
	
}
function ProcessManagerSpeech(&$data){
	global $current_AUCTION;
	
	$data = str_replace("@manager",$current_AUCTION->manager,$data);
	$data = str_replace("@i",($current_AUCTION->item_cusor)+1,$data);
	$data = str_replace("@name",$current_AUCTION->items[$current_AUCTION->item_cusor]["Name"],$data);
	$data = str_replace("@description",$current_AUCTION->items[$current_AUCTION->item_cusor]["Description"],$data);
	$data = str_replace("@tier",$current_AUCTION->items[$current_AUCTION->item_cusor]["Rarity"],$data);
	$data = str_replace("@OG",$current_AUCTION->items[$current_AUCTION->item_cusor]["Original_owner"],$data);
	//$data = str_replace("@price",,$data);
	//$data = str_replace("@buyer_ID",,$data);
	//$data = str_replace("@best_buyer_ID",,$data);
	//$data = str_replace("@best_price",,$data);
	
	
}
class Client{
	
	public $ID;
	public $Color;
	public $Name;
	public $Conn;
	public $Auction=null;
	
	function __construct($ID,$Color,$Name,$conn){
		$this->ID = $ID;
		$this->Color = $Color;
		$this->Name = $Name;
		$this->Conn = $conn;
	}
	
	function ID()				{ return $this->ID;}
	function Color()			{ return $this->Color;}
	function Name()				{ return $this->Name;}
	function Connection()		{ return $this->Conn;}
	function Auction()			{ return $this->Auction;}
	function SetAuction($conn)	{ $this->Auction =$conn;}
}
class Auction{
	
	
	public $ID;
	public $stage;
	public $manager;
	public $pitch = 1;
	public $speed = 1;
	public $tier;
	public $items;
	public $speak = [];
	public $data="";
	public $item_cusor = 0;
	
	function GetRandomLine($array){
	
	return $array[rand(0,count($array)-1)];
		}
	
	function __construct($ID,$manager,$tier,$items){
		global $managerSpeak;
		
		$this->ID = $ID;
		$this->manager = $manager;
		$this->tier = $tier;
		$this->stage = 0;
		$this->items = $items;
		
		$greet = $this->GetRandomLine($managerSpeak["stage"][0]["welcome"][0]["greet"][0]);
		$rule = $this->GetRandomLine($managerSpeak["stage"][0]["welcome"][0]["Rules"][0]);
		$goodbye = $this->GetRandomLine($managerSpeak["stage"][0]["welcome"][0]["Goodbye"][0]);
		
		
		$for_items = [];
		
		//var_dump($items);
		for($i = 0;$i<count($items);$i++){
			$bring=null;
			$name=null;
			$desc=null;
			$OG=null;
			$Rarity=null;
			$sold=null;
			
			
			if($i==0){
				  $bring = $this->GetRandomLine($managerSpeak["stage"][0]["auction"][0]["first"][0]["bring"][0]);
			}else if($i==count($items)-1 && rand(0,1)==0){
				$bring =  $this->GetRandomLine($managerSpeak["stage"][0]["auction"][0]["last"][0]["bring"][0]);
				
			}else $bring = $this->GetRandomLine($managerSpeak["stage"][0]["auction"][0]["n"][0]["bring"][0]);
			if(rand(0,4)!=0)$name = $this->GetRandomLine($managerSpeak["stage"][0]["auction"][0]["n"][0]["name"][0]);
			if(rand(0,4)!=0)$desc = $this->GetRandomLine($managerSpeak["stage"][0]["auction"][0]["n"][0]["description"][0]);			
			if(rand(0,4)!=0)$OG = $this->GetRandomLine($managerSpeak["stage"][0]["auction"][0]["n"][0]["Original_owner"][0][$items[$i]["Original_owner"]==null?"no_OG":"yes_OG"][0]);
			if(rand(0,4)!=0)$Rarity = $this->GetRandomLine($managerSpeak["stage"][0]["auction"][0]["n"][0]["Rarity"][0]["n"][0]);
			if($i==0&& rand(0,1)==0){
				 $sold = $this->GetRandomLine($managerSpeak["stage"][0]["auction"][0]["first"][0]["sold"][0]);
			}else if($i==count($items)-1){
				$sold = $this->GetRandomLine($managerSpeak["stage"][0]["auction"][0]["last"][0]["sold"][0]);			
			}else $sold = $this->GetRandomLine($managerSpeak["stage"][0]["auction"][0]["n"][0]["sold"][0]);
			$tmp = [$name,$desc,$OG,$Rarity];
			shuffle($tmp);
			$for_items[] = [$bring."\n".$tmp[0]."\n".$tmp[1]."\n".$tmp[2]."\n".$tmp[3],$sold];
		}
		
		$bye =$this->GetRandomLine($managerSpeak["stage"][0]["Goodbye"][0]);
		$this->speak = [$greet." ".$rule." ".$goodbye, $for_items, $bye];
		//var_dump($this->speak);
	}
	
	function Stage(){return $this->stage;}
}

?>