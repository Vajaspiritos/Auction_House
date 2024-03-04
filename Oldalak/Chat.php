<html>
<head>
<?php
include '..\Resources\Scriptek\CheckForLoggedIn.php';
if(session_status() !== PHP_SESSION_ACTIVE) session_start(); 				 // ha a session még nincs elindítva elindítja.
include '..\Resources\Scriptek\ConnectToDB.php';	
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
<style>
body{
	overflow:hidden;
	
}
div#Chatbox{
	width:100%;
	height:80%;
	overflow-y:auto;
	
	flex-direction: column-reverse;
	
	
}
div#Chatbox::-webkit-scrollbar{
	display: none;
	-ms-overflow-style: none;  
	scrollbar-width: none;  
	
}
div#Message{
	width:100%;
	height:10%;
}
a#Name{
	font-size:200%;
	font-weight:bold;
}
a#textMessage{
	font-size:200%;
	color:white;
}
input{
	width:100%;
	height:17%;
	font-size:200%;
	padding-left: 3%;
}
</style>
</head>
<body>
<div id="Chatbox">
</div><br>
<input id="Messenger" type="text" placeholder="Ide írhatod az üzeneted">
</body>
<script src="..\Resources\Scriptek\Chat.js"></script>
</html>