<?php


if(session_status() !== PHP_SESSION_ACTIVE) session_start();				//session elindítása ha még nem történt meg.
include '../Resources/Scriptek/ConnectToDB.php';

if(empty($_POST['MSG'])||isset($_POST["submit"])) returnWithError("Didn'T recive TEXT");	//Átjöt infók ellenörzése.
$text = $_POST["MSG"];
unset($_POST["MSG"]);													//$_POST kiürítése
$Image = null;
$IMG_ID="0";

if(!empty($_FILES['kep'])){
$Image = $_FILES["kep"];
unset($_FILES["kep"]);	
	
$Image_Extension = pathinfo($Image['full_path'])['extension'];


$ACCEPTABLE_EXTENSIONS = array("jpg","png");
$MAX_FILE_SIZE         =1000*1000; //(bájtokban)


if(!in_array($Image_Extension,$ACCEPTABLE_EXTENSIONS))returnWithError("File Formátum nem megfelelő!");

if($Image['size'] > $MAX_FILE_SIZE)returnWithError("Túl nagy fájlt probál feltölteni!");


while(true){ //generáljunk egy még nem létező ID-t
			$IMG_ID = random_bytes(32);
		$result = $conn -> query("SELECT ID FROM `forum` WHERE Image_IDs='".$IMG_ID."'");
			if(mysqli_num_rows($result)==0)break;											
}	
	
	

}											






$conn->query("INSERT INTO `forum` (`Likes`, `Text`, `Image_IDs`, `Comment_to`, `Date`) VALUES (0, '".$text."', '".$IMG_ID."', 0, '0', '0', '0', '".date("Y/m/d")."');") or die("oh oh!");

$image = "../Resources/Images/Forum/".$_SESSION['UserID'].".".$Image_Extension;

if(!move_uploaded_file($Image["tmp_name"],$image)){

	returnWithError("Nem sikerült a feltöltés");
}
returnWithError("sikeres feltöltés");


function returnWithError($text){
	
	$_SESSION["Error"] = $text;
	echo "return";
	header("Location: forum.php");
	die();
	
}


?>

