<html lang="hu">
<head>
	<?php
	include '../Resources/Scriptek/CheckForLoggedIn.php';
	include '../Resources/Scriptek/ConnectToDB.php';
	if(session_status() !== PHP_SESSION_ACTIVE) session_start();	
	echo "<script> const USER_INVENTORY=".GetInventory($conn).";</script>";
		
	
	
	?>
	<meta charset="UTF-8">
			<link rel="stylesheet" href="../Resources/CSS/betuTipusok.css">
	<link rel="stylesheet" href="../Resources/CSS/navbar.css">
	<link rel="stylesheet" href="../Resources/CSS/sajat_aukcio.css">
</head>
<body>
	<div class="menusor">
		<table class="kep inline">
			<tr>
			<td><img src="../Resources/Images/Icons/logo.gif" alt="Logo" ></td>
		</tr>
		</table>
		<table class="gombok inline">
		<tr>
			<td class ="menu-gombok-containter"><a class ="menu-gombok" href="fooldal.php">Főoldal</a></td>
			<td class ="menu-gombok-containter"><a class ="menu-gombok" href="sajat_aukcio.php" >Saját aukció</a></td>
			<td class ="menu-gombok-containter"><a class ="menu-gombok"  href="egyenleg.php" >Egyenleg feltöltés</a></td>
			<td class ="menu-gombok-containter"><a class ="menu-gombok" href="forum.php" >Fórum</a></td>
			<td class ="menu-gombok-containter"><a class ="menu-gombok" href="profil.php" >Profil</a></td>
			<td class ="menu-gombok-containter"><button class="menu-gombok" onclick="alert('Ez egy aukciós oldal ahol egy kezdő tőkéböl kiindulva kell meggazdagodnod. Különböző tételekre licitálsz és reméled, hogy nem licitálnak túl. A megszerzett tárgyakat felteheted újabb aukciókra és abból szerzed a profitot. Ha minden pénzed elfogyott ne aggódj, naponta egyszer mehetsz dolgozni. Nem minden aukcióra léphetsz be, komolyabb aukciók komolyabb tételeket rejtenek ahova jelvény kell, ezeket a profilodnál tudod megvenni.')">info</button></td>
		</tr>
		
		<div class="inline">
		
		</div>
	</table>
	</div>
	<div class="menusor-spacer">
	</div>
	<div id="aukcio-container">
		<div class="aukcio auto">
		<p id="aukcio-cim">Automata aukció</p>	
		<p id="aukcio-info">Itt kiválaszthat bármennyit a saját, már birtokolt tárgyai közül, hogy elküldje aukcióra. Ekkor a rendszer magától keres neki egy dátumot és hozzárendeli. Minden aukcióra küldés végleges!</p>		
			<button id="auto" onclick="replace(false)">Aukcióra tétel</button>
		</div>
		<div class="aukcio own">	
		<p id="aukcio-cim">Saját aukció</p>	
		<p id="aukcio-info">Ennél legalább 5 tárgyat kell kivállasztania ahhoz, hogy egy saját aukciós eseményt tudjon indítani. Itt csak az ön által kiválasztott tárgyak kerülnek elárverezésre. A rendszer dátumot az események továbbra is automatikusan választ!</p>			
			<button id="host" onclick="replace(true)">Aukcióra tétel</button>
		</div>
	</div>
	<iframe id="raktar" style="visibility:hidden"></iframe>
	
</body>
<script src="../Resources/Scriptek/sajat_aukcio_load_in_data.js"></script>
</html>