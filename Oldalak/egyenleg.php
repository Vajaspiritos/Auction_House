<html>
<head>
		<?php
		include '../Resources/Scriptek/CheckForLoggedIn.php';
		include '../Resources/Scriptek/ConnectToDB.php';
		$res =$conn->query("SELECT LastWork FROM `users` WHERE ID=".$_SESSION["UserID"])->fetch_assoc()["LastWork"];
		if($res ==null){ $res = 3600;
		}else $res = strtotime(date("Y-m-d H:i:s"))-strtotime($res);
			
		echo "<script>const LAST_WORK=$res</script>";
		
		?>
	<title>Egyenleg feltöltés</title>
			<link rel="stylesheet" href="../Resources/CSS/betuTipusok.css">
	<link rel="stylesheet" href="../Resources/CSS/navbar.css">
	<link rel="stylesheet" href="../Resources/CSS/egyenleg.css">
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
	<div id="egyenleg-div">
	<span id="egyenleg">Jelenlegi egyenleged:</span><span class="penz">1000</span>
	</div>
	<div id="giga-div">
	<div id="munka-container">
		<div id="munka-rendszer" class="inline">
			<p id="magyarazo-szoveg">Ide jönne egy nagy szöveg mint például: Ez egy olyan munka ahol egy katonai hatseregnek segítesz embereket toborozni. A munka egyszerű és sok pénz nem jár érte. Várnod kell a kiszemeltre és mikor jónak látod a helyzetet elé sétálsz és megkéred hogy csatlakozzon a hadsereghez.
			Ide jönne egy nagy szöveg mint például: Ez egy olyan munka ahol egy katonai hatseregnek segítesz embereket toborozni. A munka egyszerű és sok pénz nem jár érte. Várnod kell a kiszemeltre és mikor jónak látod a helyzetet elé sétálsz és megkéred hogy csatlakozzon a hadsereghez.
		Ide jönne egy nagy szöveg mint például: Ez egy olyan munka ahol egy katonai hatseregnek segítesz embereket toborozni. A munka egyszerű és sok pénz nem jár érte. Várnod kell a kiszemeltre és mikor jónak látod a helyzetet elé sétálsz és megkéred hogy csatlakozzon a hadsereghez.</p>
		</div>

	<div id="img-timer-container" class="inline">
			<div id="img-container">
					<img src="../Resources/Images/Munka/munka.jpg"alt="kép a munkáról">
				</div>
			<div id="timer-div">
					<div id="timer-belso-div">
						<span id="timer-text">Még:<span id="timer">0</span>perc van hátra</span>
			</div>
				<button id="work" onclick="work()" disabled>Munka kezdése</button><br>
				
			</div>
		</div>
	</div>
	<div id="kulso-tier-container">
		<a id="tier-text">tier badge áruház</a>
	<div id="tier-container">
		
		<div class="tier-img-container" id="very-low-tier">
			<img src="../Resources/Images/Munka/munka.jpg" alt="tier kep">
			<div class="penz-container">
			<p class="penz" id="very-low">100</p>
			</div>
		</div>

		<div class="tier-img-container" id="low-tier">
			<img src="../Resources/Images/Munka/munka.jpg" alt="tier kep">
			<div class="penz-container">
			<p class="penz" id="low">100</p>
			</div>
		</div>
		<div class="tier-img-container" id="medium-tier">
			<img src="../Resources/Images/Munka/munka.jpg" alt="tier kep">
			<div class="penz-container">
			<p class="penz" id="medium">100</p>
			</div>
		</div>
		<div class="tier-img-container" id="high-tier">
			<img src="../Resources/Images/Munka/munka.jpg" alt="tier kep">
			<div class="penz-container">
			<p class="penz" id="high">100</p>
			</div>
		</div>
		<div class="tier-img-container" id="very-high-tier">
			<img src="../Resources/Images/Munka/munka.jpg" alt="tier kep">
			<div class="penz-container">
			<p class="penz" id="very-high">100</p>
			</div>
		</div>
		<div class="tier-img-container" id="ultra-high-tier">
			<img src="../Resources/Images/Munka/munka.jpg" alt="tier kep">
			<div class="penz-container">
			<p class="penz" id="ultra-high">100</p>
			</div>
		</div>
	</div>
</div>
</div>
</body>
<script src="../Resources/Scriptek/Egyenleg.js"></script>
</html>