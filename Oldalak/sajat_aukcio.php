<html lang="hu">
<head>
	<?php
	include '../Resources/Scriptek/CheckForLoggedIn.php';
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
	<div class="aukcio">
			<iframe></iframe><br>
		<button>Aukcióra tétel</button>
	</div>
	<div class="aukcio">
		<iframe></iframe><br>
		<button>Aukcióra tétel</button>
	</div>
	</div>
</body>
</html>