<?php
include '../Resources/Scriptek/CheckForLoggedIn.php';
include '../Resources/Scriptek/ConnectToDB.php';


$conn->query("DELETE FROM users WHERE `users`.`ID` = ".$_SESSION["UserID"]);
unset($_SESSION["UserID"]);
header("Location: belepes.php");



?>