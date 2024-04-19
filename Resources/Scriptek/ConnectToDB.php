<?php

//Szimpla belépés Az adatbázisba, miután ezt minden oldalnak meg kell tennie amúgy is.

$servername = "localhost";		
$username = "root";				//A DB-ben lére van hozva egy user, Szelektált jogokkal.
$password = "";
$db="auction_house";
$conn;
try{
$conn = mysqli_connect($servername, $username, $password,$db);
}catch(Exception $err){
	unset($_SESSION['UserID']);
	echo "<script>window.top.location='belepes.php'</script>";
}
if ($conn->connect_error) {
  die("Csatlakozás az adatbázishoz sikertelen" . $conn->connect_error);
}

	
	
$rarities = ["Újrahasznosított","Nem mindennapi", "Limitált", "Ritka", "Exotikus", "Legendás", "God-Like"];


function UpdateGeneralInfos($conn){
	
	$result = $conn->query("SELECT Username,Tier,Money,Email FROM `users` WHERE ID='".$_SESSION["UserID"]."';");
	$row = $result->fetch_assoc();
	
	if(session_status() !== PHP_SESSION_ACTIVE) session_start();
	$_SESSION["Name"]=$row["Username"];
	$_SESSION["Tier"]=$row["Tier"];
	$_SESSION["Money"]=$row["Money"];
	$_SESSION["Email"]=$row["Email"];
	
	
	
}

//return a JSon encoded array, filled with assoc arrays about the user's currently owned items (that are not on auction);
function GetInventory($conn){
	global $rarities;
	$result = $conn->query("SELECT * FROM `items` WHERE Current_owner='".$_SESSION["UserID"]."' AND Auction_ID=0;");
	$items = [];
	
	while($row = $result->fetch_assoc()){
		
		$newassoc = [];
		$newassoc['ID'] = $row['ID'];
		$newassoc['Name'] = $row['Name'];
		$newassoc['Description'] = $row['Description'];
		$newassoc['Original_owner'] = $row['Original_owner'];
		$newassoc['Rarity'] = $row['Rarity'];
		$newassoc['Rarity_name'] = $rarities[intval($row['Rarity'])];
		$imgID = $row['Image_ID'];
		
		$src = "../Resources/Images/Icons/Default_Item.png";
		foreach (glob("../Resources/Images/Items/".$imgID.".*") as $file){ 
	
			$src = $file;
			}
		
		
		
		$newassoc['Image_src'] = $src;
		array_push($items,$newassoc);
		
		
		
	}
	//var_dump($items);
	return json_encode($items);
	
	
}

function GetNumOfItems($conn,$user){
	
	return mysqli_num_rows($conn->query("SELECT ID FROM `items` WHERE Current_owner=".$user));
}

function ForumReceivePosts($conn,$from,$to,$user){ //from és to: számban hogy hány postot akarunk betölteni a log-ból.0-tól indexelve
	
	$result = $conn->query("SELECT * FROM `forum` WHERE Comment_to=0 ORDER BY Date DESC LIMIT ".($to-$from)." OFFSET ".$from);
	$posts = [];
	while($row = $result->fetch_assoc()){
		
		$newassoc = [];
		$newassoc['ID'] = $row['ID'];
		$res=$conn->query("SELECT ID FROM `likes` WHERE Post_ID=".$row['ID']);
		$newassoc['Likes'] = mysqli_num_rows($res);
		$newassoc['Text'] = $row['Text'];
		$newassoc['Date'] = $row['Date'];
		$res=$conn->query("SELECT Username FROM `users` WHERE ID=".$row['Owner_ID']);
		$newassoc['OP'] = $res->fetch_assoc()['Username'];
		$res=$conn->query("SELECT ID FROM `forum` WHERE Comment_to=".$row['ID']);
		$newassoc['Comments'] = mysqli_num_rows($res);
		$newassoc['IsLiked'] =mysqli_num_rows($conn->query("SELECT ID FROM `likes` WHERE Post_ID=".$row['ID']." AND User_ID =".$user))>0;
		
		if($row['Image_IDs'] != "0"){
		$imgID = $row['Image_IDs'];
		
		$src = "../Resources/Images/Icons/Default_Item.png";
		foreach (glob("../Resources/Images/Forum/".$imgID.".*") as $file){ 
	
			$src = $file;
			}
		
		
		
		$newassoc['Image_src'] = $src;
		
		}else $newassoc['Image_src'] = null;
		
		
		array_push($posts,$newassoc);
		
		
		
	}

	return json_encode($posts);
	
	
	
}

function FocusOnPost($conn,$postID){
	$posts = [];
	
	//A poszt maga
	$row = $conn->query("SELECT * FROM `forum` WHERE ID=".$postID)->fetch_assoc();
		$newassoc = [];
		$newassoc['ID'] = $row['ID'];
		$res=$conn->query("SELECT ID FROM `likes` WHERE Post_ID=".$row['ID']);
		$newassoc['Likes'] = mysqli_num_rows($res);
		$newassoc['Text'] = $row['Text'];
		$newassoc['Date'] = $row['Date'];
		$res=$conn->query("SELECT Username FROM `users` WHERE ID=".$row['Owner_ID']);
		$newassoc['OP'] = $res->fetch_assoc()['Username'];
		$res=$conn->query("SELECT ID FROM `forum` WHERE Comment_to=".$row['ID']);
		$newassoc['Comments'] = mysqli_num_rows($res);
		if($row['Image_IDs'] != "0"){
		$imgID = $row['Image_IDs'];
		$src = "../Resources/Images/Icons/Default_Item.png";
		foreach (glob("../Resources/Images/Forum/".$imgID.".*") as $file){ 
			$src = $file;
			}
		$newassoc['Image_src'] = $src;		
		}else $newassoc['Image_src'] = null;		
		array_push($posts,$newassoc);
		
	
	
	//kommentek
	$result = $conn->query("SELECT * FROM `forum` WHERE Comment_to=".$postID." ORDER BY Date DESC");
	
	while($row = $result->fetch_assoc()){
		
		$newassoc = [];
		$newassoc['IsComment'] = "true";
		$newassoc['ID'] = $row['ID'];
		$res=$conn->query("SELECT ID FROM `likes` WHERE Post_ID=".$row['ID']);
		$newassoc['Likes'] = mysqli_num_rows($res);
		$newassoc['Text'] = $row['Text'];
		$newassoc['Date'] = $row['Date'];
		$res=$conn->query("SELECT Username FROM `users` WHERE ID=".$row['Owner_ID']);
		$newassoc['OP'] = $res->fetch_assoc()['Username'];
		$res=$conn->query("SELECT ID FROM `forum` WHERE Comment_to=".$row['ID']);
		$newassoc['Comments'] = mysqli_num_rows($res);
		
		if($row['Image_IDs'] != "0"){
		$imgID = $row['Image_IDs'];
		
		$src = "../Resources/Images/Icons/Default_Item.png";
		foreach (glob("../Resources/Images/Forum/".$imgID.".*") as $file){ 
	
			$src = $file;
			}
		
		
		
		$newassoc['Image_src'] = $src;
		
		}else $newassoc['Image_src'] = null;
		
		
		array_push($posts,$newassoc);
		
		
		
	}
	

	return json_encode($posts);
	
	
}

function IsLikedAlready($conn,$postID,$user){
	
	return (mysqli_num_rows($conn->query("SELECT ID FROM `likes` WHERE Post_ID=".$postID." AND User_ID=".$user))>0?true:false);
	
	
}

function GetAuctions($conn,$Limit=null){
	$result = $conn->query("SELECT * FROM `auction` WHERE Date > '".date("Y-m-d H:i:s")."' ORDER BY Date ".($Limit?"Limit ".$Limit:"").";");
	$items = [];
	
	while($row = $result->fetch_assoc()){
		
		$newassoc = [];
		$newassoc['ID'] = $row['ID'];
		$newassoc['Tier'] = $row['Tier'];
		$newassoc['Manager'] = $row['Manager'];
		$newassoc['Date'] = $row['Date'];
		
		array_push($items,$newassoc);
		
		
		
	}
	
	return json_encode($items);
	
	
}

function GetMoneyOf($user){        //$user = user id;
	global $conn;
	return $conn->query("SELECT Money FROM `users` WHERE ID=".$user)->fetch_assoc()['Money'];
};


function GetTierOf($user){        //$user = user id;
	global $conn;
	return $conn->query("SELECT Tier FROM `users` WHERE ID=".$user)->fetch_assoc()['Tier'];
};

function Pay($amount,$user,$item,$current){
	
	global $conn;
	$conn->query("UPDATE `users` SET `Money` = (Money - $amount) WHERE `users`.`ID` = $user;");
	$conn->query("UPDATE `users` SET `Money` = (Money + $amount) WHERE `users`.`ID` = $current;");
	$conn->query("UPDATE `items` SET `Current_owner` = $user, `Auction_ID` = '0' WHERE `items`.`ID` = $item;");
}
function GetItemsOfAuction($conn,$AuctionID,$pure=false){
	global $rarities;
	
	$result = $conn->query("SELECT * FROM `items` WHERE Auction_ID=".$AuctionID.";");
	$items = [];
	
	while($row = $result->fetch_assoc()){
		
		$newassoc = [];
		$newassoc['ID'] = $row['ID'];
		$newassoc['Name'] = $row['Name'];
		$newassoc['Description'] = $row['Description'];
		$newassoc['Original_owner'] = $row['Original_owner'];
		$newassoc['Rarity'] = $row['Rarity'];
		$newassoc['Rarity_name'] = $rarities[intval($row['Rarity'])];
		$newassoc['CO'] = $row['Current_owner'];
		
		$imgID = $row['Image_ID'];
		
		$src = "../Resources/Images/Icons/Default_Item.png";
		foreach (glob("../Resources/Images/Items/".$imgID.".*") as $file){ 
	
			$src = $file;
			}
		
		
		
		$newassoc['Image_src'] = $src;
		array_push($items,$newassoc);
		
		
		
	}
	//var_dump($items);
	return $pure? $items:json_encode($items);
	
}
?>