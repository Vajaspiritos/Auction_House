<!DOCTYPE html>
<html lang="hu">
<head>
		<?php
		include '../Resources/Scriptek/CheckForLoggedIn.php';
		if(!$Test_mode){
		include '../Resources/Scriptek/ConnectToDB.php';
		UpdateGeneralInfos($conn);
		$res =$conn->query("SELECT LastWork FROM `users` WHERE ID=".$_SESSION["UserID"])->fetch_assoc()["LastWork"];
		if($res ==null){ $res = 3600;
		}else $res = strtotime(date("Y-m-d H:i:s"))-strtotime($res);
			
		echo "<script>const LAST_WORK=$res</script>";
		echo "<script>const MONEY=".$_SESSION["Money"]."</script>";
		echo "<script>const TIER=".$_SESSION["Tier"]."</script>";
		}else{
			echo "<script>const LAST_WORK='0'</script>";
			echo "<script>const MONEY=120000</script>";
			
		}
		?>
	<title>Egyenleg feltöltés</title>
			<link rel="stylesheet" href="../Resources/CSS/betuTipusok.css">
	<link rel="stylesheet" href="../Resources/CSS/navbar.css">
	<link rel="stylesheet" href="../Resources/CSS/egyenleg.css">
</head>
<body>
	<button id="drop-btn" onclick="lenyit()">↓</button>
	<div class="menusor inactive" id="drop-menusor">
		<div class="kep inline">
			<img src="../Resources/Images/Icons/logo.png" alt="Logo" >
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
	<div id="egyenleg-div">
	<span id="egyenleg">Jelenlegi egyenleged:</span><span class="penz">1000</span>
	</div>
<div id="giga-div">
	<div id="munka-container">
		<div id="munka-rendszer" class="inline">
			<p id="magyarazo-szoveg">Az aukciósház naponta több ezer portékát kezel. Az épületben mindenki mindig siet dolgára és sose vagyunk időben kész a pakolással. Jelenleg rengeteg doboz van amibe a tárgyakat tartjuk és ezeket mind a helyére kéne pakolni. Örömmel várjuk jelentkezését!</div>

	<div id="img-timer-container" class="inline">
			<div id="img-container">
					<img src="../Resources/Images/Munka/work_0.gif" alt="kép a munkáról">
				</div>
			<div id="timer-div">
					<div id="timer-belso-div">
						<span id="timer-text">Még:<span id="timer">0</span>perc van hátra</span>
			</div>
				<button id="work" onclick="work()" disabled>Munka kezdése</button><br>
				
			</div>
		</div>
	</div>

	<div id="tier-container">
		<div id="kulso-tier-container">
		<a id="tier-text">tier badge áruház</a>
		</div>
		<div id="timig-container">

		<div class="tier-img-container" id="very-low-tier" onclick="buy(0)">
			<img src="../Resources/Images/Icons/Tier_1.png" alt="tier kep">
			<div class="penz-container">
			<p class="penz" id="very-low">99</p>
			</div>
		</div>

		<div class="tier-img-container" id="low-tier" onclick="buy(1)">
			<img src="../Resources/Images/Icons/Tier_2.png" alt="tier kep">
			<div class="penz-container">
			<p class="penz" id="low">2,499</p>
			</div>
		</div>
		<div class="tier-img-container" id="medium-tier" onclick="buy(2)">
			<img src="../Resources/Images/Icons/Tier_3.png" alt="tier kep">
			<div class="penz-container">
			<p class="penz" id="medium">59,999</p>
			</div>
		</div>
		<div class="tier-img-container" id="high-tier" onclick="buy(3)">
			<img src="../Resources/Images/Icons/Tier_4.png" alt="tier kep">
			<div class="penz-container">
			<p class="penz" id="high">749,999</p>
			</div>
		</div>
		<div class="tier-img-container" id="very-high-tier" onclick="buy(4)">
			<img src="../Resources/Images/Icons/Tier_5.png" alt="tier kep">
			<div class="penz-container">
			<p class="penz" id="very-high">3,420,000</p>
			</div>
		</div>
		<div class="tier-img-container" id="ultra-high-tier" onclick="buy(5)">
			<img src="../Resources/Images/Icons/Tier_6.png" alt="tier kep">
			<div class="penz-container">
			<p class="penz" id="ultra-high">49,999,999</p>
			</div>
		</div>
	</div>
</div>

</div>
<script src="../Resources/Scriptek/Egyenleg.js"></script>
<script src="../Resources/Scriptek/navbar.js"></script>
</body>
</html>