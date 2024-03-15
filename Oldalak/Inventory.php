<html>
<head>
<?php

include '../Resources/Scriptek/CheckForLoggedIn.php';
	include '../Resources/Scriptek/ConnectToDB.php';
echo "<script> const USER_INVENTORY=".GetInventory($conn).";</script>";

?>
<style>
#items-container{
	
	width:70%;
	height:95%;
	border: 4px solid black;
	display: inline-block;
	float:left;
	overflow:auto;
}

#info-container{
	float:right;
	width:25%;
	height:95%;
	border: 4px solid black;
	display: inline-block;
}

.Item{
	display: inline-block;
	
}

.Item_IMG{
	width:150px;
}
#info_image{
	
	margin-left: auto;
    margin-right: auto;
    display: block;
	height:30%;
}
#info-name{
	text-align:center;
}
#info-description{
	overflow:auto;
	height:40%;
}
table,td{
	width:100%;
	height:10%;
	border:2px solid black;
	text-align:center;
	border-collapse: collapse;
	font-size:20px;
	
}


</style>
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