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
	
</head>
<body>
<div id="fejlec">
</div>
<div id="login-doboz">
<div class="login" id="loginForm">
	<button id="reg" class="valto" onclick="regisztralok()" >Regisztrálni akarok!</button>
<form action="login.php" method="post" onsubmit="BelepesEllenorzes()">
	<input type="text" placeholder="Felhasznalonév" name="username"><br>
	<input type="password" placeholder="Jelszó" name="password"><br>
	<div id="felejt_jelszo_doboz">
	<a id="felejt_jelszo" onclick="megjelenit()"> Elfelejtettem a jelszavam</a>
	</div>
	<input type="submit" value="Belépés" id="loginBtn" class="formGomb">
</div>
<div id="hiba_doboz">
	<p id="hiba"></p>
</div>
</form>
</div>
<div id="check_list">
<p class="listaElem"><span>Email cím</span><span>(pelda@nomail.hu)</span></p>
<p class="listaElem"><span>Jelszó</span><span>(Legalább 5 karakter és 1 speciális karakter(..felsoorlni..) )</span></p>
<p class="listaElem"><span>Két jelszó egyezik</span></p>
<p class="listaElem"><span>Bankkártyaszám</span><span>(1234-1234-1234-1234)</span></p>
<p class="listaElem"><span>Nincs üresen hagyott mező</span></p>
</div>
<div id="registerId" class = "register">
<button id="log" class="valto" onclick="loginolok()" >Vigyél viszza ÁÁÁÁÁÁÁÁÁ</button>
	<p>Regisztrálni akarok</p>
<form action="register.php" method="post" onsubmit="AdatokEllenorzes()">
	<input type="text" class="regElem" placeholder="Email cím" name="email" id="regEmail" oninput="AdatokEllenorzes('email')"><br>
	<input type="text" class="regElem" placeholder="Felhasználónév" name="username" id="regUname" oninput="AdatokEllenorzes(this)"><br>
	<input type="password" class="regElem" placeholder="Jelszó" name="password" id="regPass" oninput="AdatokEllenorzes('jelszo')"><br>
	<input type="password" class="regElem" placeholder="Jelszó újra" id="regPassA" oninput="AdatokEllenorzes('jelszoA')"><br>
	<input type="text" class="regElem" placeholder="Bankkártyaszám" id="regBank" oninput="AdatokEllenorzes('bank')"><br>
	<input type="text" class="regElem" placeholder="Édesanyád leánykori neve" id="regAnya" oninput="AdatokEllenorzes(this)"><br>
	<input type="text" class="regElem" placeholder="Első háziállatod neve" id="regAllat" oninput="AdatokEllenorzes(this)"><br>
	<input type="text" class="regElem" placeholder="Születési hely" id="regSzul" oninput="AdatokEllenorzes(this)"><br>
	<input type="text" class="regElem" placeholder="Gyerekkori becenév" id="regBec" oninput="AdatokEllenorzes(this)"><br>
	<input type="submit" value="Regisztrálás" id="regBtn" class="formGomb">
</form>
</div>
<div id="ForgotContainer">
	<form action="ForgotPass.php"method="POST" id="ForgotForm">
		<a onclick="bezar()">X</a>
		<p>Adja megy fiókjának emailcímét.</p>
		<input type="text" placeholder="ezzel@regisztraltam.hu" name="forgotEmail"><br>
		<input type="submit">
	</form>
</div>
<div id="blur"></div>
<script src="../Resources/Scriptek/belepes.js"></script>
</body>
</html>