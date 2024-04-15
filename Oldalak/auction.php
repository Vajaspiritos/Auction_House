<!DOCTYPE html>
<html lang = "hu">
<head>
<?php
include '../Resources/Scriptek/CheckForLoggedIn.php';
if(!$Test_mode){
include '../Resources/Scriptek/ConnectToDB.php';
UpdateGeneralInfos($conn);
echo "<script> 
const USERID = ".$_SESSION["UserID"].";
const Name ='".$_SESSION["Name"]."';
const Tier =".$_SESSION["Tier"].";
</script>";
echo "<script>const AUCTIONS=".GetAuctions($conn)."</script>";
}else echo "<script>const AUCTIONS='test'</script>"; 
?>
<title>Auction</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="../Resources/CSS/betuTipusok.css">
<link rel="stylesheet" href="../Resources/CSS/auction.css">

</head>
<body>
	<div id="bg" class="curtain_closed">
		<div id="box" >
		<img id="manager" class="manager">
		<div id="pedestal" >
		<img id="item" ></div>
		<div id="infos" >
		<table>
			<tr>
				<td id="info_name"></td>
			</tr>
			<tr>
				<td id="info_og"></td>
			</tr>
			<tr>
				<td id="info_rarity"></td>
			</tr>
			<tr>
				<td id="info_desc"></td>
			</tr>
		</table>
		</div>
		</div>
	<img id="curtain" class="curtain_closed">
	</div>
	
	<div id="screen" class="screen">
		<p id="screen_text" class="clock">
		</p>
	</div>
<script src="../Resources/Scriptek/auction.js"></script>
</body>
</html>