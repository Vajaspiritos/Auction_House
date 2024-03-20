<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start(); 
$src = "../Resources/Images/Icons/asd.jpg";
foreach (glob("../Resources/Images/Users/".$_SESSION['UserID'].".*") as $file){ 
	
	$src = $file;
}
echo "<script>const USER_PFP_SRC = '".$src."'</script>";

?>