<DOCTYPE! html>
<html lang="hu">
<head>
	<?php
	include '..\Resources\Scriptek\CheckForLoggedIn.php';
	include '..\Resources\Scriptek\ErrorHandle.php';
	
	?>
	<meta charset="UTF-8">
	<title>Belépés</title>
	<link rel="stylesheet" href="../Resources/CSS/belepes.css">
	<script src="../Resources/Scriptek/belepes.js"></script>
</head>
<body>
<div id="fejlec">
</div>
<div class="login" id="loginForm">
	<button id="reg" onclick="regisztralok()" >Regisztrálni akarok!</button>
<form action="login.php" method="post">
	<input type="text" placeholder="Felhasznalonév" name="username">
	<input type="text" placeholder="Jelszó" name="password">
	<input type="submit" id="felejt_jelszo" value="Elfelejtettem a jelszavam">
	</br>
	<input type="submit" value="Belépés" id="loginBtn">
</form>
</div>
<div id="registerId" class = "register">
<form action="register.php" method="post">
	<input type="text" placeholder="Email cím" name="email"><br>
	<input type="text" placeholder="Felhasznalonév" name="username"><br>
	<input type="text" placeholder="Jelszó" name="password"><br>
	<input type="text" placeholder="Jelszó ujra"><br>
	<input type="text" placeholder="Bankkártya adatok"><br>
	<input type="text" placeholder="Anyád leánykori neve"><br>
	<input type="text" placeholder="Első háziállatod neve"><br>
	<input type="text" placeholder="Születési hely"><br>
	<input type="text" placeholder="Gyerekkori becenév"><br>
	<input type="submit" value="Regisztrálás" id="loginBtn">
</form>
</div>
</body>
</html>