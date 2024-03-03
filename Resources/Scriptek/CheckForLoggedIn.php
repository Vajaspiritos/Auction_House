<?php


//Ennek célja hogy le ellenörízze hogy be vagyunk e lépve. ha igen, nem csinál semmit. kivéve ha a belépés oldalon vagyunk, mert akkor egyből átirányít a főoldalra.
// Ellenkező esetben átirányít a belépésre, a hibaüzenettel, hogy be kell lépni.
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(strcmp(basename($_SERVER['REQUEST_URI']),"belepes.php")!=0&&empty($_SESSION['UserID'])){ 
$_SESSION['Error'] ="Be kell jelentkeznie!";
header("Location: belepes.php");
die();

}else if(strcmp(basename($_SERVER['REQUEST_URI']),"belepes.php")==0&&!empty($_SESSION['UserID'])){
	header("Location: fooldal.php");
	
}






?>