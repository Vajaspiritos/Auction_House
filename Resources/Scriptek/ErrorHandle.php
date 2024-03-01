<?php



if(session_status() !== PHP_SESSION_ACTIVE) session_start(); //Sessiont indít ha még nincs.

if(!empty($_SESSION['Error'])){ 				//amennyiben az Error tartalmaz valamit, létrehoz egy javascript változót neki. és törli a session-ből.

echo '<script>var ERROR="'.$_SESSION['Error'].'"</script>';
unset($_SESSION['Error']);

//echo "Error found.";




	
}
?>