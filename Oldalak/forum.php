<DOCTYPE! html>
<html lang="hu">
<head>
	<?php
	include '../Resources/Scriptek/CheckForLoggedIn.php';
	include '../Resources/Scriptek/ErrorHandle.php';
	include '../Resources/Scriptek/ConnectToDB.php';
	$query = parse_url($_SERVER['REQUEST_URI'],PHP_URL_QUERY);
	$Focused = "false";
	if($query){
		
		if(str_contains($query,"Focus=")){
			$Focused = explode("Focus=",$query)[1];
			echo "<script> const POSTS=".FocusOnPost($conn,$Focused).";</script>";
			echo "<script> const CurrentPage=-1;</script>";
			
		}else if(str_contains($query,"Page=")) {
			$url_scraps = explode("-",explode("Page=",$query)[1]);
			echo "<script> const POSTS=".ForumReceivePosts($conn, $url_scraps[0],$url_scraps[1]).";</script>";
			echo "<script> const CurrentPage=".$url_scraps[1].";</script>";
		}else header("Location: forum.php");
		
	}else{
		echo "<script> const CurrentPage=10;</script>";
		echo "<script> const POSTS=".ForumReceivePosts($conn, 0,10).";</script>";
	}
	echo "<script> const FocusOn=".$Focused.";</script>";
	?>
	<title>Fórum</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../Resources/CSS/betuTipusok.css">
	<link rel="stylesheet" href="../Resources/CSS/navbar.css">
	<link rel="stylesheet" href="../Resources/CSS/forum.css">
	<script src="../Resources/Scriptek/forum.js"></script>
		<script src="../Resources/Scriptek/navbar.js"></script>
</head>
<body>
<button id="drop-btn" onclick="lenyit()">↓</button>
	<div class="menusor" id="drop-menusor">
		<div class="kep inline">
			<img src="../Resources/Images/Icons/logo.gif" alt="Logo" >
		</div>
		<div class="gombok inline">
		<a class ="menu-gombok" href="fooldal.php">Főoldal</a>
		<a class ="menu-gombok" href="sajat_aukcio.php" >Saját aukció</a>
		<a class ="menu-gombok" href="egyenleg.php" >Egyenleg feltöltés</a>
		<a class ="menu-gombok" href="forum.php" >Fórum</a>
		<a class ="menu-gombok" href="profil.php" >Profil</a>
		<button onclick="alert('Ez egy aukciós oldal ahol egy kezdő tőkéböl kiindulva kell meggazdagodnod. Különböző tételekre licitálsz és reméled, hogy nem licitálnak túl. A megszerzett tárgyakat felteheted újabb aukciókra és abból szerzed a profitot. Ha minden pénzed elfogyott ne aggódj, naponta egyszer mehetsz dolgozni. Nem minden aukcióra léphetsz be, komolyabb aukciók komolyabb tételeket rejtenek ahova jelvény kell, ezeket a profilodnál tudod megvenni.')">info</button>

		
		</div>
	</div>

	<div class="menusor-spacer">
	</div>
	<div class="chatbox inline" id="post_container">
	</div>
	<div class="publish inline" id="publish">
	
		<button id="publish_button" onclick="legordul()">Posztolok</button>
		<form action="Forum_post.php" id="Message" method="post" enctype="multipart/form-data">
		<div id="pTartalom">
		<textarea type="text" name="MSG" placeholder="ÚRISTEN MEGSZEREZTEM A PIZZAGÖMBÖT!!!" maxlength="1000"></textarea><br>
		<input type="file" name="kep" id="browse"><br>
		<button type="submit">Küldés</button>	
		</div>
	</form>
	</div>
</dic>
</body>
<script src="../Resources/Scriptek/forum_load_in_data.js"></script>
</html>
