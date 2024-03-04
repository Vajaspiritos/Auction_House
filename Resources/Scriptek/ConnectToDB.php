<?php

//Szimpla belépés Az adatbázisba, miután ezt minden oldalnak meg kell tennie amúgy is.

$servername = "localhost";		
$username = "AuctionHouseUser";				//A DB-ben lére van hozva egy user, Szelektált jogokkal.
$password = "1234";
$db="auction_house";

$conn = new mysqli($servername, $username, $password,$db);

if ($conn->connect_error) {
  die("Csatlakozás az adatbázishoz sikertelen" . $conn->connect_error);
}

function UpdateGeneralInfos($conn){
	
	$result = $conn->query("SELECT Username,Tier,Money FROM `users` WHERE ID='".$_SESSION["UserID"]."';");
	$row = $result->fetch_assoc();
	
	if(session_status() !== PHP_SESSION_ACTIVE) session_start();
	$_SESSION["Name"]=$row["Username"];
	$_SESSION["Tier"]=$row["Tier"];
	$_SESSION["Money"]=$row["Money"];
	
	
	
}





?>