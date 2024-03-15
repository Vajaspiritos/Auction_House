<DOCTYPE! html>
<html lang="hu">
<head>
	<?php
	include '../Resources/Scriptek/CheckForLoggedIn.php';
	include '../Resources/Scriptek/ConnectToDB.php';
	include '../Resources/Scriptek/LoadInProfilePicture.php';
	include '../Resources/Scriptek/ErrorHandle.php';	
	UpdateGeneralInfos($conn);
	echo "<script> const USER_MONEY=".$_SESSION["Money"].";</script>";
	echo "<script> const USER_NAME='".$_SESSION["Name"]."';</script>";
	echo "<script> const USER_EMAIL='".$_SESSION["Email"]."';</script>";
	
	
	
	?>
	<title>Profil</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../Resources/CSS/profil.css">
</head>
<body>
	<div class="navbar"></div>
	<div id="spacer"></div>
	<div class="Nagydoboz">

		<div id="Pfp" class="inline">
			<img  id="PP" alt="Profilképed :)" style="width:200px">
			<form action="UploadPfp.php" method="post" enctype="multipart/form-data">
			<input type="file" name="PFP">
			<button type="submit">Uj profilkep</button>
			
			</form>
		</div>
		<div id="adatok" class="inline">
			<p>CASH: <span id="penz">PÉZ$$$$$$$$$$</span></p>
			<p>Felhasznalo nev: <span id="fnev">A fiok neve</span></p>
			<p>Email cim: <span id="email">Aző ímél cím</span></p>
			<button>Fiok torlese</button>
			<a href="logout.php" style="color:cyan">Kijelentkezés</a>
		</div>
		<div id="History" class="inline"><span>Histroy</span></div>
		<div class="Raktar">	
		<iframe src="Inventory.php" title="Raktár" style="width:100%; height:100%;"></iframe>
		</div>
		
	</div>
</body>
<script src="../Resources/Scriptek/profil_load_in_data.js"></script>

</html>