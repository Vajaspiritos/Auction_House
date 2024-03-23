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


while(true){
	ServerAction();
	
	$read=$CLIENTS;
	$write=null;
	$exception=null;
	
	$r = socket_select($read,$write,$exception,0);

	if($r<=0) continue;
	
	//ha a readben most bennevan a server socket, akkor azt azt jelenti új user a láthatáron;
	if(in_array($SERVER,$read)){
		socket_set_block($SERVER);
		C("new user trying to connet...");
		$client= socket_accept($SERVER);
		$CLIENTS[] = $client;
		$request = socket_read($client, 5000);
		
		$key =  explode("\r\n",explode("Sec-WebSocket-Key: ",$request)[1])[0];
		C("Key obtained:".$key);
		
		$magic = base64_encode(pack(
				'H*',
				sha1($key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')
			));
		
		$response = "HTTP/1.1 101 Switching Protocols\r\n".
					"Upgrade: websocket\r\n".
					"Connection: Upgrade\r\n".
			
					"Sec-WebSocket-Accept: ".$magic."\r\n\r\n";
		
		
		if(socket_write($client,$response, strlen($response))!==false){
			C("Sucessfully sent back handshake response");
			C("new user gained");
		}else C("Handshake couldn't be sent");
		
		$uniq = uniqid();
		WRITE($client,"id");
		
        unset($read[array_search($SERVER, $read)]);
		socket_set_nonblock($SERVER);
	}
	if($r<=0) continue;

	foreach($read as $client){
		
		
		$message=  READ($client);
		if($message == "error|1"|| $message == "error|2"){ 
		C("A client's message is not readable :".$message); 
		unset($CLIENTS[array_search($client, $CLIENTS)]);
		unset($INFOS[array_search(FindUser($client), $INFOS)]);
		if(FindUser($client)->Auction() != null)unset($CLIENTS[array_search(FindUser($client)->Auction(), $CLIENTS)]);
		continue;
		} 
		$parts = explode("|",$message);
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
			$found = false;
			foreach($INFOS as $C){
				
				if($C->ID() == $parts[1]){
					C($C->Name()." becsatlakozott az aukcioba");
					$C->SetAuction($client);
					$found = true;
					if(!$Auction_ongoing){ 
					C("Made user wait");
					WRITE($client,"wait");}
				}
				
				
			}
			if(!$found){
				
				WRITE($client,"retry");
				
			}
			
		}else if($parts[0]=="!get_Auction_ongoing"){
			
			if($Auction_ongoing==false)C("false");
			if($Auction_ongoing===false)C("false");
			if(!$Auction_ongoing)C("!true");
			if($Auction_ongoing==true)C("true");
			
		}else{
			$user = FindUser($client);
			if($user == null) continue;
				C($user->Name().": ".$message);
				BROADCAST(FORMAT($message,$user));
		}
	}
	
}
function ServerAction(){
	
	CheckForAuction();
	
}
function importTexts(){
	global $managerSpeak;
	$managerSpeak = json_decode(file_get_contents("./Resources/manager.json"),true);
	
}
function C($text){
	
	echo $text."\n";
	
}
function WRITE($client,$text){
	$msg = chr(129) . chr(strlen($text)) . $text;
	socket_write($client, $msg);
}
function READ($client){
	
	$byte_array = unpack('C*',socket_read($client,1024) );

	if($byte_array[1] != 129){
				if($byte_array[1]==136){
					DeleteUser($client);
				}else{
					C($byte_array[1]);return "error|1";
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
	global $NextAuction,$conn,$Auction_ongoing,$current_AUCTION_infos;
	
	
	if(!$Auction_ongoing&&$NextAuction!=null && $NextAuction < strtotime(date("Y-m-d H:i:s"))){
		//on auction
	
		$id = $current_AUCTION_infos["ID"];
		$manager = $current_AUCTION_infos["Manager"];
		$Tier = $current_AUCTION_infos["Tier"];
		$items = $conn->query("SELECT * FROM `items` WHERE Auction_ID=".$current_AUCTION_infos["ID"])->fetch_assoc();
		
		$current_AUCTION = new Auction($current_AUCTION_infos["ID"],$current_AUCTION_infos["Manager"],$current_AUCTION_infos["Tier"],GetItemsOfAuction($conn,$current_AUCTION_infos["ID"],true));
		$Auction_ongoing = true;
	}else if($NextAuction==null){
		//on startup
		$auction_list = json_decode(GetAuctions($conn,1),TRUE);
		if(count($auction_list) == 0) return false;
		$NextAuction = strtotime($auction_list[0]["Date"]);
		$current_AUCTION_infos = $auction_list[0];
		C($NextAuction);
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
function BROADCAST($text){
	global $INFOS;
	foreach($INFOS as $client){
		
		WRITE($client->Connection(),$text);
		
	}
	
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
	public $tier;
	public $items;
	public $speak = [];
	
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
			$for_items[] = [$bring,$tmp[0]."\n".$tmp[1]."\n".$tmp[2]."\n".$tmp[3],$sold];
		}
		
		$bye =$this->GetRandomLine($managerSpeak["stage"][0]["Goodbye"][0]);
		$this->speak = [$greet.$rule.$goodbye, $for_items, $bye];
		var_dump($this->speak);
	}
	
}

?>