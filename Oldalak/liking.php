<?php

include '../Resources/Scriptek/CheckForLoggedIn.php';
include '../Resources/Scriptek/ConnectToDB.php';

$query = parse_url($_SERVER['REQUEST_URI'],PHP_URL_QUERY);
	if($query&&str_contains($query,"for=")){
		
			$id =explode("for=",$query)[1];
			
			if(IsLikedAlready($conn,$id,$_SESSION['UserID'])){
				
				$conn->query("DELETE FROM `likes` WHERE Post_ID=".$id." AND User_ID=".$_SESSION['UserID'].";");
				
				
				
			}else $conn->query("INSERT INTO `likes` (`Post_ID`, `User_ID`) VALUES (".$id.",".$_SESSION['UserID']." );");

			$res = ($conn->query("SELECT ID FROM `likes` WHERE Post_ID = ".$id));
			echo mysqli_num_rows($res);



			//header('Location: ' . $_SERVER['HTTP_REFERER']);
			
	}else header("Location: forum.php");
		
	



?>