<html>
<head>
<?php

include '../Resources/Scriptek/CheckForLoggedIn.php';
if(session_status() !== PHP_SESSION_ACTIVE) session_start(); 				 // ha a session még nincs elindítva elindítja.
include '../Resources/Scriptek/ConnectToDB.php';	
UpdateGeneralInfos($conn);
echo "<script> 
const USERID = ".$_SESSION["UserID"].";
const Name ='".$_SESSION["Name"]."';
const Tier =".$_SESSION["Tier"].";
</script>";
?>
<title>
Chat
</title>
</head>
<body>
<div id="Chatbox">
</div><br>
<input id="Messenger" type="text" placeholder="Ide írhatod az üzeneted">
</body>
<script src="../Resources/Scriptek/Chat.js"></script>
</html>