<?php
//a program váza ez alapján készült: https://medium.com/@cn007b/super-simple-php-websocket-example-ea2cd5893575
include '../Resources/Scriptek/ConnectToDB.php';


$NextAuction = null;
$current_AUCTION = null;
$current_AUCTION_infos = null;
$Auction_ongoing = false;
$managerSpeak;
$itemcollection;
$chat;


importTexts();

echo "Prepearing for server start...\n";
$address = 'localhost';
$port = 443;

echo "Done...\n";
echo "Starting server...\n";

$SERVER = socket_create(AF_INET,SOCK_STREAM,SOL_TCP) or die("Server couldn't be created\n");

socket_set_option($SERVER, SOL_SOCKET, SO_REUSEADDR, 1) or die("Server couldn't set option\n"); //Ez arra kell, hogy ha cask úgy bezárom pl a szervert, akkor a rendszer hajlandó legyen újra használni a portot, úgy is hogy már használva van. (azért hiszi hogy még használva van mert nem volt rendesen lezárva)
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

$bids_allowed = false;
$bye_tmp = "";

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
	global $Auction_ongoing,$conn;
	if(!$Auction_ongoing){
		
		if(!mysqli_num_rows($conn->query("SELECT * FROM `auction`"))){
			GenerateAuctions();
		}else CheckForAuction();
		
		}else{		
		
		progressAuction();	
		SimulateChat();		
	}
	
	
	
}
function SimulateChat(){
	global $bids_allowed,$current_AUCTION,$Server_user,$chat;
	
	
	if($current_AUCTION->stage >= 0 && $current_AUCTION->stage <=3){
		if(rand(1,7)==5){
			
			$phase = $chat[$current_AUCTION->stage-1];
			$msg = $phase[rand(0,count($phase)-1)];
			
			BROADCAST(FORMAT($msg,randomUser()));
			
		}
	}
	$overlicit = [1.1,1.2,1.25,1.5,1.75,1.33,1.99,2];
	
	if($bids_allowed&& rand(0,15)==1){
		$index = 0;
		while(rand(0,1)==0){
			$index++;
			if($index+1 == count($overlicit)) break;
		}
		
		
		
		$new = floor($current_AUCTION->bestprice+1 * $overlicit[$index]);
		$user = randomUser();
		
		BROADCAST(FORMAT("!bid ".$new,$user));
		$current_AUCTION->bestprice = $new;
		$current_AUCTION->bidder = $user;
		UpdateAuctions("ChangedPrice|".$new."|".$name);
	}
}
function randomUser(){
	$red = mt_rand(120, 255);
	$green = mt_rand(120, 255);
	$blue = mt_rand(120, 255);
	$rgbColor = "rgb($red, $green, $blue)";
	$names = ["DarkSouls","Kőgazdag", "Auction", "Jhon", "Sajtos Tucc", "oh the Furtive Pygmy is so easily forgotten", "Balázs", "ferenc", "kingdom come", "kenyérpirító", "Béla) DROP TABLE banlist","skyrim"];
	
	$name ="John ". $names[rand(0,count($names)-1)];
	
	$user = new Client("0",$rgbColor,$name,null);
	
	
	return $user;
}
function GenerateAuctions(){
	global $itemcollection,$conn;
	
	for($auction = 0; $auction < rand(3,9);$auction++){
		
		$target_rarity = rand(1,100);
		if($target_rarity <= 40){ $target_rarity = 0;}else
		if($target_rarity <= 70){ $target_rarity = 1;}else
		if($target_rarity <= 85){ $target_rarity = 2;}else
		if($target_rarity <= 93){ $target_rarity = 3;}else
		if($target_rarity <= 98){ $target_rarity = 4;}else
		if($target_rarity <= 101){ $target_rarity = 5;}
		
		$id = CreateAuction($target_rarity);
		
		for($item = 0; $item < rand(4,8);$item++){
			
			do{
			$choosen =$itemcollection[rand(0,count($itemcollection)-1)];
			}while(abs($choosen[3]-$target_rarity) > 1);
			
			if($choosen[1] == "nincs") $choosen[1] = "Nincs róla semmi infórmáció.";
			if($choosen[2] == "nincs") $choosen[2] = "ismeretlen.";
			$conn->query("INSERT INTO `items` (`ID`, `Name`, `Description`, `Original_owner`, `Rarity`, `Current_owner`, `Auction_ID`, `Image_ID`, `BoughtFor`) VALUES (NULL, '".$choosen[0]."', '".$choosen[1]."', '".$choosen[2]."', '".$choosen[3]."', '0', '$id', '0', '0');");
			
			
			}
		
		
		
		
		
		
		
		
	}
	CheckForAuction();
	
}
function CreateAuction($tier){
	global $conn;
$time_window = 10; //10 perc
$break_time = 5;
$time_per_item = 1;
$result = $conn -> query("SELECT Date,ID FROM `auction`");

$date = strtotime(date("Y-m-d H:i:s", (time() + $time_window*60)));
$tmp_time = $time_window;
while(true){
	
foreach($result as $row){
	$counter = mysqli_num_rows($conn->query("SELECT ID FROM `items` WHERE Auction_ID=".$row["ID"]));
	if( ($date-strtotime($row["Date"])) < ($time_window+$break_time+($time_per_item*$counter))*60 ){
			
			
		
		$date += rand(1,6) *10*60;
		continue;
	}
	
}

break;
}
$date= date("Y-m-d H:i:s",$date);
$managers=["Raigen","Dougdoug","Gavlan","John Manager"];
$manager = $managers[rand(0,count($managers)-1)];

$conn->query("INSERT INTO `auction` (Date,Tier,Manager) VALUES ('$date',$tier,'$manager')");
$id = $conn->query("SELECT ID FROM `auction` WHERE Date='$date'")->fetch_assoc()["ID"];

return $id;
}
function progressAuction(){
	global $current_AUCTION,$stage_counter,$bids_allowed,$Auction_ongoing,$bye_tmp;
	$wait_times  = [0,40,60,30]; //[0]= Aukció elkezdése [1]=köszönés, szabályok, stb [2]= idő / item [3] elköszönés
	$base_prices = [0,20,500,3000,40000,700000,9999999,888888888]; //árak az aukció ritkaságszintjétől függnek. ez alapján kaphatjuk meg a kezdőárát egy tételnek.
	
	sentenceprogression();
	if(!$bids_allowed&&$current_AUCTION->stage==2&&$stage_counter > $wait_times[2]/3)$bids_allowed = true;
	if($wait_times[$current_AUCTION->Stage()] <= $stage_counter ){
		$stage_counter = 0;
		//Licitálás vége
		if($current_AUCTION->stage == 2){
			$bids_allowed = false;
			$buyer = ($current_AUCTION->bidder==null)?0:($current_AUCTION->bidder)->ID;
			
			Pay($current_AUCTION->bestprice,$buyer,$current_AUCTION->items[$current_AUCTION->item_cusor ]["ID"],$current_AUCTION->items[$current_AUCTION->item_cusor]["CO"]);
			$current_AUCTION->bidder = null;
			$current_AUCTION->bestprice = 0;
			
			@$current_AUCTION->data ="4|".($current_AUCTION->pitch)."|".($current_AUCTION->speed)."|".($bye_tmp); //stage| speaker pitch | speaker speed | text			
			UpdateAuctions($current_AUCTION->data);
			$current_AUCTION->item_cusor++;
			if(count($current_AUCTION->speak[1])==0) ++$current_AUCTION->stage;
		}
		$STAGE = ($current_AUCTION->stage != 2 )?++$current_AUCTION->stage:2;
		C("Advancing to next stage :".$STAGE);
		
		if($STAGE==1){
			$current_AUCTION->data ="1|".($current_AUCTION->pitch)."|".($current_AUCTION->speed)."|".($current_AUCTION->speak[0]); //stage| speaker pitch | speaker speed | text
			
			UpdateAuctions($current_AUCTION->data);
		}else if($STAGE==2){
			
			
			$item = $current_AUCTION->items[$current_AUCTION->item_cusor];
				$current_AUCTION->bestprice = $base_prices[intval($item["Rarity"])];
			@$current_AUCTION->data = 
						"2|".($current_AUCTION->pitch)."|".
						($current_AUCTION->speed)."|".
						$current_AUCTION->speak[1][0][0]."|".
						$item["Rarity"]."|".
						$item["Name"]."|".
						$item["Original_owner"]."|".
						$item["Description"]."|".
						$item["Image_src"]."|".
						$base_prices[intval($item["Rarity"])]."|".
						$item["Rarity_name"];
				
			$bye_tmp = $current_AUCTION->speak[1][0][1];
			UpdateAuctions($current_AUCTION->data);
			array_shift($current_AUCTION->speak[1]);
			
			
			//C("Bids: ".$bids_allowed);
		}else if($STAGE==4){
			
			$current_AUCTION->data ="3|".($current_AUCTION->pitch)."|".($current_AUCTION->speed)."|".($current_AUCTION->speak[2]); //stage| speaker pitch | speaker speed | text
			
			UpdateAuctions($current_AUCTION->data);
			$Auction_ongoing = false;
		}
		
		
		
	}else $stage_counter++;
	C("time: ".$stage_counter);
}
function sentenceprogression(){
	global $current_AUCTION;
	if($current_AUCTION->data == "") return;
	
	$pieces = explode("|",$current_AUCTION->data);	
	$pieces[3] = substr($pieces[3],3);
	$current_AUCTION->data = implode("|",$pieces);
	
}
function bid($user,$amount){
	global $Server_user,$current_AUCTION,$bids_allowed;
	if(!$bids_allowed){ Write($user->Conn,FORMAT("Jellenleg nem lehet licitálni",$Server_user)); return -1;}
	if(!is_numeric($amount)){ Write($user->Conn,FORMAT("Nem megfelelő szám lett megadva",$Server_user)); return -1;}
	if($current_AUCTION->bestprice >= $amount){ Write($user->Conn,FORMAT("A kivánt összeg kisebb mint a legnagyobb",$Server_user)); return -1;}
	$user_wealth = GetMoneyOf($user->ID);
	if($user_wealth < $amount){ Write($user->Conn,FORMAT("Sajnos nincs elegendő összeg az egyenlegén",$Server_user)); return -1;}
	C(intval($user->ID));
	C(intval($current_AUCTION->items[$current_AUCTION->item_cusor]["CO"]));
	var_dump((intval($user->ID) === intval($current_AUCTION->items[$current_AUCTION->item_cusor]["CO"])));
	if(intval($user->ID) === intval($current_AUCTION->items[$current_AUCTION->item_cusor]["CO"])){ Write($user->Conn,FORMAT("A saját tételére nem tehet licitet",$Server_user)); return -1;}
	$user_tier = GetTierOf($user->ID);
	if($user_tier < $current_AUCTION->tier){ Write($user->Conn,FORMAT("Sajnos túl alacsony a rangja, hogy résztvehessen ezen az aukción.",$Server_user)); return -1;}
	
	overlicit($user,$amount);
	BROADCAST(FORMAT("!bid ".$amount,$user));
}
function overlicit($user,$amount){
	global $Server_user,$current_AUCTION,$bids_allowed;
	
	$current_AUCTION->bestprice = $amount;
	$current_AUCTION->bidder = $user;
	UpdateAuctions("ChangedPrice|".$amount."|".$user->Name);
	
}
function importTexts(){
	global $managerSpeak,$itemcollection,$chat;
	$managerSpeak = json_decode(file_get_contents("./Resources/manager.json"),true);
	$itemcollection = json_decode(file_get_contents("./Resources/Items.json"),true);
	$chat = json_decode(file_get_contents("./Resources/chat.json"),true);

	
}
function Client_handle(){
	global $CLIENTS, $SERVER, $INFOS, $Server_user,$Auction_ongoing,$current_AUCTION,$NextAuction;
		
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
						if($NextAuction- strtotime(date("Y-m-d H:i:s"))> 1) WRITE($client,"wait");
					}else{	
				
						ProcessManagerSpeech($current_AUCTION->data);
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
			
		}else if(explode(" ",$message)[0]=="!bid"){
			
			bid(FindUser($client),explode(" ",$message)[1]);
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
		
		if($client->Auction()!= null)WRITE($client->Auction(),$data);
		
	}
	
}
function ProcessManagerSpeech(&$data){
	global $current_AUCTION;
	
	@$data = str_replace("@manager",$current_AUCTION->manager,$data);
	@$data = str_replace("@i",($current_AUCTION->item_cusor)+1,$data);
	@$data = str_replace("@name",$current_AUCTION->items[$current_AUCTION->item_cusor]["Name"],$data);
	@$data = str_replace("@description",$current_AUCTION->items[$current_AUCTION->item_cusor]["Description"],$data);
	@$data = str_replace("@tier",$current_AUCTION->items[$current_AUCTION->item_cusor]["Rarity_name"],$data);
	@$data = str_replace("@OG",$current_AUCTION->items[$current_AUCTION->item_cusor]["Original_owner"],$data);
	@$data = str_replace("@price",$current_AUCTION->bestprice,$data);
	@$data = str_replace("@buyer_ID",$current_AUCTION->bidder->ID,$data);
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
	
	public $bidder=null;
	public $bestprice = 0;
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
