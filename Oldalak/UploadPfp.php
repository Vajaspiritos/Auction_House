<?php

if(session_status() !== PHP_SESSION_ACTIVE) session_start();				//session elindítása ha még nem történt meg.
if(empty($_FILES['PFP'])||isset($_POST["submit"])) returnWithError("Didn'T recive username");	//Átjöt infók ellenörzése.
$PP = $_FILES["PFP"];
unset($_FILES["PFP"]);													//$_POST kiürítése

$PP_Extension = pathinfo($PP['full_path'])['extension'];


$ACCEPTABLE_EXTENSIONS = array("jpg","png","jpeg");
$MAX_FILE_SIZE         =1024*1024*1024; //(bájtokban)


if(!in_array($PP_Extension,$ACCEPTABLE_EXTENSIONS))returnWithError("File Formátum nem megfelelő!");

if($PP['size'] > $MAX_FILE_SIZE)returnWithError("Túl nagy fájlt probál feltölteni!");

//delet previous file

foreach (glob("../Resources/Images/Users/".$_SESSION['UserID'].".*") as $file){ 
	
	unlink($file);
}



$image = "../Resources/Images/Users/".$_SESSION['UserID'].".".$PP_Extension;

if(!move_uploaded_file($PP["tmp_name"],$image)){

	returnWithError("Nem sikerült a feltöltés");
}
returnWithError("sikeres feltöltés");


function returnWithError($text){
	
	$_SESSION["Error"] = $text;
	echo "return";
	header("Location: profil.php");
	die();
	
}


?>