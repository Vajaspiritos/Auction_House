<!DOCTYPE html>
<html lang="hu">
<head>
	<?php
	include '../Resources/Scriptek/CheckForLoggedIn.php';
	if(!$Test_mode){
	include '../Resources/Scriptek/ConnectToDB.php';
	include '../Resources/Scriptek/LoadInProfilePicture.php';
	include '../Resources/Scriptek/ErrorHandle.php';	
	UpdateGeneralInfos($conn);
	echo "<script> const USER_MONEY=".$_SESSION["Money"].";</script>";
	echo "<script> const USER_NAME='".$_SESSION["Name"]."';</script>";
	echo "<script> const USER_EMAIL='".$_SESSION["Email"]."';</script>";
	}else{
		echo "<script> const USER_MONEY=120000;</script>";
	echo "<script> const USER_NAME='Anonymus';</script>";
	echo "<script> const USER_EMAIL='30perc@ahatáridőig.jaj';</script>";
	echo "<script> const USER_PFP_SRC='../Resources/Images/icons/Default_User.png';</script>";
	
		
	}
	
	
	?>
	<title>Profil</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../Resources/CSS/betuTipusok.css">
	<link rel="stylesheet" href="../Resources/CSS/navbar.css">
	<link rel="stylesheet" href="../Resources/CSS/profil.css">
</head>
<body>
<button id="drop-btn" onclick="lenyit()">↓</button>
	<div class="menusor inactive" id="drop-menusor">
		<div class="kep inline">
			<img src="../Resources/Images/Icons/logo.png" alt="Logo" >
		</div>
		<div class="gombok inline">
		<a class ="menu-gombok" href="fooldal.php">Főoldal</a>
		<a class ="menu-gombok" href="sajat_aukcio.php" >Saját aukció</a>
		<a class ="menu-gombok" href="egyenleg.php" >Egyenleg feltöltés</a>
		<a class ="menu-gombok" href="forum.php" >Fórum</a>
		<a class ="menu-gombok" href="profil.php" >Profil</a>
		<button onclick="alert('Ez egy aukciós oldal ahol egy kezdő tőkéböl kiindulva kell meggazdagodnod. Különböző tételekre licitálsz és reméled, hogy nem licitálnak túl. A megszerzett tárgyakat felteheted újabb aukciókra és abból szerzed a profitot. Ha minden pénzed elfogyott ne aggódj, naponta egyszer mehetsz dolgozni. Nem minden aukcióra léphetsz be, komolyabb aukciók komolyabb tételeket rejtenek ahova jelvény kell, ezeket a profilodnál tudod megvenni.')">info</button>

		
		</div>
	</div>

	<div class="menusor-spacer">
	</div>
	<div class="Nagydoboz">
		<div id="Pfp" class="inline">
			<img id="PP" src="../Resources/Images/icons/Default_User.png" alt="Profilképed :)">
			<form action="UploadPfp.php" method="post" enctype="multipart/form-data">
			<input id="browse" type="file" name="PFP">
			<input id="upload" type="submit" value="Kép feltöltése">
			</form>
		</div>
		<div id="adatok" class="inline">
			<p><span  class="feliratok label">CASH:</span>
			<span id="penz" class="feliratok">PÉZ$$$$$$$$$$</span></p>

			<p><span class="feliratok label">Felhasznalo nev:</span>
			<span id="fnev" class="feliratok">A fiok neve</span></p>

			<p><span  class="feliratok label">Email cim:</span>
			<span id="email" class="feliratok">Aző ímél cím</span></p>

			<button>Fiok torlese</button>
			<a href="logout.php" style="color:cyan" id="logout">Kijelentkezés</a>
		</div>
		<div id="History" class="inline"><span>Histroy</span></div>
		<div class="Raktar">	
		<iframe src="Inventory.php" title="Raktár"></iframe>
		</div>
		
	</div>
	<script src="../Resources/Scriptek/profil_load_in_data.js"></script>
<script src="../Resources/Scriptek/navbar.js"></script>
</body>
</html>