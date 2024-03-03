<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start(); 				 // ha a session még nincs elindítva elindítja.
if(empty($_POST['username'])) returnWithError("Didn'T recive username");     //ellenőrizzük, hogy a szükséges infok biztosan megvannak e;
if(empty($_POST['password'])) returnWithError("Didn'T recive password");

$UN = $_POST["username"];													
$PS = $_POST["password"];


unset($_POST["username"]);													//miután lementetük egy lokális változoba a szükséges értékeket töröljük a postból.
unset($_POST["password"]);


include '..\Resources\Scriptek\ConnectToDB.php';							//csatlakozás az adatbázishoz.
echo "<br>Csatlakozva az adatbázishoz.<br>";

$result = $conn->query("SELECT * FROM `users` WHERE Username='".$UN."';");	//SQL-ek futtatása megkeressük a felhasználót az adott username-el és jelszóval
while($row = $result->fetch_assoc()){
	
	if(password_verify($PS.$row['Salt'],$row['Password'])){
		
		$_SESSION["UserID"] = $row['ID'];
		returnWithError("Successful login");
	}
	
	
}
returnWithError("Username or Password not correct");                         //Abban az esetben ha nem találunk felhasználót visszatérünk hibával.

function returnWithError($text){
	
	$_SESSION["Error"] = $text;				//a hibákat session-ön keresztül közöljük.
	echo "return";
	header("Location: belepes.php");
	die();
	
}

?>