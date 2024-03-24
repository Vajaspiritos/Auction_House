<!DOCTYPE html>
<html lang="hu">
<head>
	<?php
	include '../Resources/Scriptek/CheckForLoggedIn.php';
	include '../Resources/Scriptek/ConnectToDB.php';
	
	echo "<script>const AUCTIONS=".GetAuctions($conn)."</script>";
	
	?>
	<title>Főoldal</title>
	<meta charset="UTF-8">
		<link rel="stylesheet" href="../Resources/CSS/betuTipusok.css">
	<link rel="stylesheet" href="../Resources/CSS/navbar.css">
	<link rel="stylesheet" href="../Resources/CSS/fooldal.css">
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
	
	<div class="aukcios-felulet">
		<div id="aukcio" class="inline">
		<iframe src="auction.php"  id="auction" style="width:100%; height:100%"></iframe>
		</div>

		<div class ="inline" id="chatBox">
			<iframe src="Chat.php" title="Chat Box" id="chat-box" class="inline"></iframe>
		</div>
	</div>
		<table>
		</table>
	<div class="naplo">
		<table id="filters" style="width: 100%">
		<tbody id="aukcio-container">
			<tr >
				<td colspan=3 id="menetred_text">
							Menetrend
				</td>
			</tr>
			<tr>
				<th>Dátum <button id="date">↑</button></th>
				<th>Tier <button id="tier">↑</button></th>
				<th>Árverés vezető <button id="manager">↑</button></th>
			</tr>
		</tbody>
		</table>
	</div>
<script src="../Resources/Scriptek/fooldal.js"></script>
<script src="../Resources/Scriptek/navbar.js"></script>
</body>

</html>