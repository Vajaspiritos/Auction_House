<?php
include '../Resources/Scriptek/CheckForLoggedIn.php';
include '../Resources/Scriptek/ConnectToDB.php';
$res =$conn->query("SELECT LastWork FROM `users` WHERE ID=".$_SESSION["UserID"])->fetch_assoc()["LastWork"];
if($res ==null){ $res = 3600;
}else $res = strtotime(date("Y-m-d H:i:s"))-strtotime($res);

if($res >= 3600){
	UpdateGeneralInfos($conn);
	$penz = $_SESSION["Money"]+10*(10**($_SESSION["Tier"]));
	$date = date("Y-m-d H:i:s");
	$conn->query("UPDATE `users` SET Money=$penz,LastWork='$date' WHERE ID=".$_SESSION["UserID"]);
	
}

 header("Location: egyenleg.php");
?>