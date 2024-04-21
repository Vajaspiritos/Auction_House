<?php

if(session_status() !== PHP_SESSION_ACTIVE) session_start();				

if(empty($_POST['forgotEmail'])) returnWithError("Didn'T recive email");
$EM = $_POST["forgotEmail"];
unset($_POST["forgotEmail"]);

include '../Resources/Scriptek/ConnectToDB.php';

$res = $conn->query("SELECT Email FROM `users` WHERE Email='$EM'");

if(mysqli_num_rows($res) == 0) returnWithError("There is no such email address");

 $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
 $chars2 = '!@#';
 $password = '';
 $charsLength = strlen($chars);
    for ($i = 0; $i < 8; $i++) {
        $password .= $chars[rand(0, $charsLength - 1)];
    }
		$password .= $chars2[rand(0, 2)];

$salt = bin2hex(random_bytes(32));
$Hash = password_hash($password.$salt,PASSWORD_DEFAULT);			//Hashing és sózás.

//User tényleges létrehozása az adatbázisban.
$conn->query("UPDATE `users` SET `Password` = '$Hash', `Salt` = '$salt' WHERE `Email` = '$EM';") or die("oh oh!");
if(mail($EM,"Értesítő fiokjának jelszavának megváltoztatásáról","Az aukciós ház weboldalán, erre az email címre, egy új jelszót kértek: $password","From: The Auction house")){
returnWithError("Jelszó lecserélve!");   //Visszatérünk a siker üzenettel. ez nem igazi hiba. csak újrafelhasználása a már létrehozott kódnak.
}else{ 
returnWithError("Nem sikerült Email-t küldeni");
}

function returnWithError($text){
	
	$_SESSION["Error"] = $text;
	echo "return";
	header("Location: belepes.php");
	die();
	
}

?>