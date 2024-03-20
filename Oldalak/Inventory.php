<html>
<head>
<?php

include '../Resources/Scriptek/CheckForLoggedIn.php';
	include '../Resources/Scriptek/ConnectToDB.php';
echo "<script> const USER_INVENTORY=".GetInventory($conn).";</script>";

?>
<link rel="stylesheet" href="../Resources/CSS/betuTipusok.css">
<link rel="stylesheet" href="../Resources/CSS/inventory.css">
</head>
<body>
	<div id="items-container">
		<span id="text"></spac>
	</div>
	<div id="info-container">
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
		<span id="leiras_title">Leírás:</span><br>
		<div id="info-sorkizart">
		<a id="info-description"></a>
	</div>
	</div>
	</div>
	
</body>
<script src="../Resources/Scriptek/Inventory.js"></script>
</html>