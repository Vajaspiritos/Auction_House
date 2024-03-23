<?php
//a program váza ez alapján készült: https://medium.com/@cn007b/super-simple-php-websocket-example-ea2cd5893575
include '../Resources/Scriptek/ConnectToDB.php';
$NextAuction = null;

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
				}
				
				
			}
			if(!$found){
				
				WRITE($client,"retry");
				
			}
			
		}else{
			$user = FindUser($client);
			if($user == null) continue;
				C($user->Name().": ".$message);
				BROADCAST(FORMAT($message,$user));
		}
	}
	sleep(100);
}

function ServerAction(){
	
	CheckForAuction();
	
}
function CheckForAuction(){
	global $NextAuction,$conn;
	if($NextAuction!=null && $NextAuction < strtotime(date("Y-m-d H:i:s"))){
		//on auction
		
	}else if($NextAuction==null){
		//on startup
		$auction_list = json_decode(GetAuctions($conn),TRUE);
		if(count($auction_list) == 0) return false;
		$NextAuction = strtotime($auction_list[0]["Date"]);
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
?>