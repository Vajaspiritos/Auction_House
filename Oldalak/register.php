<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();				//session elindítása ha még nem történt meg.
if(empty($_POST['username'])) returnWithError("Didn'T recive username");	//Átjöt infók ellenörzése.
if(empty($_POST['password'])) returnWithError("Didn'T recive password");
if(empty($_POST['email'])) returnWithError("Didn'T recive email");

$UN = $_POST["username"];
$PS = $_POST["password"];
$EM = $_POST["email"];

unset($_POST["username"]);													//$_POST kiürítése
unset($_POST["password"]);
unset($_POST["email"]);


echo "Adatok elfogadva.";

include '..\Resources\Scriptek\ConnectToDB.php';								//csatlakozás az adatbázishoz.
echo "<br>Csatlakozva az adatbázishoz.<br>";

$result=$conn -> query("SELECT users.Email FROM `users` WHERE users.Email='".$EM."'");
if(mysqli_num_rows($result)){ returnWithError("Email already registered!"); die();}		//ellenörízzük, hogy létezik e már felhasználó ezzel az emailel.
echo "Email looks fine.<br>";

$salt = bin2hex(random_bytes(32));
$Hash = password_hash($PS.$salt,PASSWORD_DEFAULT);			//Hashing és sózás.

//User tényleges létrehozása az adatbázisban.
$conn->query("INSERT INTO `users` (`Username`, `Email`, `Password`, `Salt`, `Tier`, `Money`, `Confirmed`, `Date`) VALUES ('".$UN."', '".$EM."', '".$Hash."', '".$salt."', '0', '0', '0', '".date("Y/m/d")."');") or die("oh oh!");
echo "új felhasználó feljegyezve.<br>";


/*             valóságban ez küóldené el az emailt, de mivel nem egy valódi webszerveren lesz futattva így nem lesz használva.
$link = "";
$text="Köszönjük a regisztrációt!\nA fiokja aktiválásához kattintson az alábbi linkre:\n".$link;
$text = wordwrap($text,70);
$headers = "From: AuctionHouse@Creativewebsitename.com" . "\r\n" ."CC: ".$EM;
mail($EM,"Fiok Aktiválás",$text,$headers)or die("email not sent");
*/
returnWithError("Fiok létrehozva!");   //Visszatérünk a siker üzenettel. ez nem igazi hiba. csak újrafelhasználása a már létrehozott kódnak.

function returnWithError($text){
	
	$_SESSION["Error"] = $text;
	echo "return";
	header("Location: belepes.php");
	die();
	
}

?>