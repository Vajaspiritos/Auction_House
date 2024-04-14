<!DOCTYPE html>
<html lang="hu">
<head>
	<?php
	include '../Resources/Scriptek/CheckForLoggedIn.php';
	include '../Resources/Scriptek/ErrorHandle.php';
	
	?>
	<meta charset="UTF-8">
	<title>Belépés</title>
	<link rel="stylesheet" href="../Resources/CSS/belepes.css">
		<link rel="stylesheet" href="../Resources/CSS/betuTipusok.css">
	<script src="../Resources/Scriptek/belepes.js"></script>
</head>
<body>
<div id="fejlec">
</div>
<div class="login" id="loginForm">
	<button id="reg" class="valto" onclick="regisztralok()" >Regisztrálni akarok!</button>
<form action="login.php" method="post">
	<input type="text" placeholder="Felhasznalonév" name="username">
	<input type="text" placeholder="Jelszó" name="password">
	<input type="submit" id="felejt_jelszo" value="Elfelejtettem a jelszavam">
	</br>
	<input type="submit" value="Belépés" id="loginBtn" class="formGomb">
</form>
</div>
<div id="registerId" class = "register">
<button id="log" class="valto" onclick="loginolok()" >Vigyél viszza ÁÁÁÁÁÁÁÁÁ</button>
	<p>Regisztrálni akarok</p>
<form action="register.php" method="post" onsubmit="AdatokEllenorzes()">
	<input type="text" placeholder="Email cím" name="email" id="regEmail"><br>
	<input type="text" placeholder="Felhasználónév" name="username" id="regUname"><br>
	<input type="text" placeholder="Jelszó" name="pasword" id="regPass"><br>
	<input type="text" placeholder="Jelszó újra" id="regPassA"><br>
	<input type="text" placeholder="Bankkártyaszám" id="regBank"><br>
	<input type="text" placeholder="Édesanyád leánykori neve" id="regAnya"><br>
	<input type="text" placeholder="Első háziállatod neve" id="regAllat"><br>
	<input type="text" placeholder="Születési hely" id="regSzul"><br>
	<input type="text" placeholder="Gyerekkori becenév" id="regBec"><br>
	<input type="submit" value="Regisztrálás" id="regBtn" class="formGomb">
</form>
</div>
</body>
</html>