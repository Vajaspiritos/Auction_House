<?php

//Szimpla belépés Az adatbázisba, miután ezt minden oldalnak meg kell tennie amúgy is.

$servername = "localhost";		
$username = "root";				//A DB-ben lére van hozva egy user, Szelektált jogokkal.
$password = "";
$db="auction_house";

$conn = mysqli_connect($servername, $username, $password,$db);
if ($conn->connect_error) {
  die("Csatlakozás az adatbázishoz sikertelen" . $conn->connect_error);
}

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
	
	$result = $conn->query("SELECT * FROM `items` WHERE Current_owner='".$_SESSION["UserID"]."' AND Auction_ID=0;");
	$items = [];
	
	while($row = $result->fetch_assoc()){
		
		$newassoc = [];
		$newassoc['ID'] = $row['ID'];
		$newassoc['Name'] = $row['Name'];
		$newassoc['Description'] = $row['Description'];
		$newassoc['Original_owner'] = $row['Original_owner'];
		$newassoc['Rarity'] = $row['Rarity'];
		
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





?>