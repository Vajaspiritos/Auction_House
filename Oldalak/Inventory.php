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
	</div>
	<div id="info-container">
	<img id="info_image" alt="Itt lenne a kép ha lenne"></img>
	<h1 id="info-name"></h1>
	
		<table>
			<tr>
				<td>
					<a id="info-OG_owner"></a>
				</td>
				<td >
					<a id="info-rarity"></a>
				</td>
			</tr>
		</table>
	<a> Leírás:</a>
	<div id="info-description"></div>
	</div>
	
</body>
<script src="../Resources/Scriptek/Inventory.js"></script>
</html>