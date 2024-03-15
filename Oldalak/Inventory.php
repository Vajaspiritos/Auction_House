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
	
}
</style>
</head>
<body>

	<div id="items-container">
	</div>
	<div id="info-container">
	<img id="info_image" alt="Itt lenne a kép ha lenne"></img>
	<h1 id="info-name"></h1>
	<hr>
	
	<hr>
	<div id="info-description"></div>
	</div>
	
</body>
<script src="../Resources/Scriptek/Inventory.js"></script>
</html>