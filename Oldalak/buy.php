<?php



include '../Resources/Scriptek/CheckForLoggedIn.php';
include '../Resources/Scriptek/ConnectToDB.php';
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
$prices = [99,2499,59999,749999,3420000,49999999];
$query = parse_url($_SERVER['REQUEST_URI'],PHP_URL_QUERY);
	if($query&&str_contains($query,"tier=")){
		
			$tier = explode("tier=",$query)[1];
			$tier_price =$prices[intval($tier)];
			$user_wealth = GetMoneyOf($_SESSION["UserID"]);
			if($tier_price > $user_wealth){
				
				echo "-1";
				
			}else{
				
				$conn->query("UPDATE `users` SET `Tier` = $tier+1, `Money` = (Money - $tier_price) WHERE `users`.`ID` = ".$_SESSION["UserID"]);
				echo "1";
				
			}
		
			



			
			
	}else header("Location: forum.php");
		
	





?>