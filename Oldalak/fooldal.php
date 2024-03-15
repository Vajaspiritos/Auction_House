<html lang="hu">
<head>
	<?php
	include '../Resources/Scriptek/CheckForLoggedIn.php';
	?>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../Resources/CSS/fooldal.css">
</head>
<body>

	<div class="menusor">
		<table>
			<tr>
				<td id="kep"><img src="..\Resources\Images\Icons\logo.gif" alt="Logo"></td>
				<td class="menu-gombok"> <a href="fooldal.php">Főoldal</a></td>
				<td class="menu-gombok"> <a href="sajat_aukcio.php" >Saját aukció</a></td>
				<td class="menu-gombok"> <a href="egyenleg.php" >Egyenleg feltöltés</a></td>
				<td class="menu-gombok"> <a href="forum.php" >Fórum</a></td>
				<td class="menu-gombok"> <a href="profil.php" >Profil</a></td>
				<td class="menu-gombok"> <button class="menu-gombok" onclick="alert('Ez egy aukciós oldal ahol egy kezdő tőkéböl kiindulva kell meggazdagodnod. Különböző tételekre licitálsz és reméled, hogy nem licitálnak túl. A megszerzett tárgyakat felteheted újabb aukciókra és abból szerzed a profitot. Ha minden pénzed elfogyott ne aggódj, naponta egyszer mehetsz dolgozni. Nem minden aukcióra léphetsz be, komolyabb aukciók komolyabb tételeket rejtenek ahova jelvény kell, ezeket a profilodnál tudod megvenni.')">info</button></td>
			</tr>
		</table>
	</div>
	<div class="menusor-spacer">
	</div>
	<div class="aukcios-felulet">
		<div id="aukcio" class="inline">
		
		</div>

		<div class ="inline" id="chat-box">
			<iframe src="Chat.php" title="Chat Box" id="chat-box" class="inline"></iframe>
		</div>
	</div>
		<table>
		</table>
	<div class="naplo">
		<table id="filters" style="width: 100%">
			<tr>
				<td>
				<button>Filter1</button>
				<button>Filter2</button>
				<button>Filter3</button>	
				</td>
			</tr>
		</table>
	</div>
</body>
</html>