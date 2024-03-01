<DOCTYPE! html>
<html lang="hu">
<head>
	<?php
	include '..\Resources\Scriptek\CheckForLoggedIn.php';
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
			<img src="pfp.png" alt="Profilképed :)">
			<button>Uj profilkep</button>
		</div>
		<div id="adatok" class="inline">
			<p>CASH: <span id="penz">PÉZ$$$$$$$$$$</span></p>
			<p>Felhasznalo nev: <span id="fnev">A fiok neve</span></p>
			<p>Email cim: <span id="email">Aző ímél cím</span></p>
			<button>Fiok torlese</button>
		</div>
		<div id="History" class="inline"><span>Histroy</span></div>
		<div class="Raktar">	
		<table>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
		</div>
		
	</div>
</body>
</html>