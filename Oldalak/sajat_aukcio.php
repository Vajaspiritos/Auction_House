<!DOCTYPE html>
<html lang="hu">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
	include '../Resources/Scriptek/CheckForLoggedIn.php';
	if(!$Test_mode){
	include '../Resources/Scriptek/ConnectToDB.php';
	include '../Resources/Scriptek/ErrorHandle.php';
	if(session_status() !== PHP_SESSION_ACTIVE) session_start();	
	echo "<script> const USER_INVENTORY=".GetInventory($conn).";</script>";
	}else echo "<script> const USER_INVENTORY='test';</script>";
	?>
	<title>Saját aukció</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../Resources/CSS/betuTipusok.css">
	<link rel="stylesheet" href="../Resources/CSS/navbar.css">
	<link rel="stylesheet" href="../Resources/CSS/sajat_aukcio.css">

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


	<div id="aukcio-container">
		<div class="aukcio auto">
		<p class="aukcio-cim">Automata aukció</p>	
		<p class="aukcio-info">Itt kiválaszthat bármennyit a saját, már birtokolt tárgyai közül, hogy elküldje aukcióra. Ekkor a rendszer magától keres neki egy dátumot és hozzárendeli. Minden aukcióra küldés végleges!</p>		
			<button id="auto" onclick="replace(false)" >Aukcióra tétel</button>
		</div>
		<div class="aukcio own">	
		<p class="aukcio-cim">Saját aukció</p>	
		<p class="aukcio-info">Ennél legalább 5 tárgyat kell kivállasztania ahhoz, hogy egy saját aukciós eseményt tudjon indítani. Itt csak az ön által kiválasztott tárgyak kerülnek elárverezésre. A rendszer dátumot az események továbbra is automatikusan választ!</p>			
			<button id="host" onclick="replace(true)" >Aukcióra tétel</button>
		</div>
	</div>
	<div id="raktar-div">
	<iframe id="raktar" style="visibility:hidden"></iframe>
</div>
<script src="../Resources/Scriptek/sajat_aukcio_load_in_data.js"></script>
	<script src="../Resources/Scriptek/navbar.js"></script>	
</body>

</html>