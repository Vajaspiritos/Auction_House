<html>
<head>
<?php

include '../Resources/Scriptek/CheckForLoggedIn.php';
if(!$Test_mode){
	include '../Resources/Scriptek/ConnectToDB.php';
echo "<script> const USER_INVENTORY=".GetInventory($conn).";</script>";
}else echo "<script> const USER_INVENTORY='test';</script>";
?>
<link rel="stylesheet" href="../Resources/CSS/betuTipusok.css">
<link rel="stylesheet" href="../Resources/CSS/inventory.css">
</head>
<body>
	<div id="veglegesit-div">
<form id="veglegesit" style="visibility:hidden" method="post" action="post_auction.php">
		<input type="text" id="SELECTED" name="selected_items_container" style="display:none" >
		<label id="text" for="valami" ></label>
		<button name="valami" type="submit" id="sendit">Küldés</button>
	</form>
</div>
	<div id="items-container">
		<span id="text"></span>
	</div>
	<div id="info-container" class="inline">
	<img id="info_image" alt="Itt lenne a kép ha lenne"></img><br>
	<a id="info-name"></a><br>
		<table>
			<tr>
				<td id="owner-div">
					<span>Eredeti tulajdonos:</span><br><a id="info-OG_owner"></a>
				</td>
				<td id="rarity-div">
					<span>Ritkaság:</span><br><a id="info-rarity"></a>
				</td>
			</tr>
		</table>
	
	<div id="info-description-containter">
		<span id="leiras_title">Leírás</span><br>
		<div id="info-sorkizart">
		<a id="info-description"></a>
	</div>
	</div>
	</div>
	
</body>
<script src="../Resources/Scriptek/Inventory.js"></script>
</html>