<html>
<head>
<?php
include '../Resources/Scriptek/CheckForLoggedIn.php';
include '../Resources/Scriptek/ConnectToDB.php';
UpdateGeneralInfos($conn);
echo "<script> 
const USERID = ".$_SESSION["UserID"].";
const Name ='".$_SESSION["Name"]."';
const Tier =".$_SESSION["Tier"].";
</script>";
echo "<script>const AUCTIONS=".GetAuctions($conn)."</script>";

?>
<meta charset="UTF-8">
<link rel="stylesheet" href="../Resources/CSS/betuTipusok.css">
<link rel="stylesheet" href="../Resources/CSS/auction.css">
</head>
<body>

</body>
<script src="../Resources/Scriptek/auction.js"></script>
</html>