<?php
	session_start();
	include("functions.php");
?>
<!DOCTYPE html>
<html lang="ro">
<head>
	<meta charset="utf-8">
	<title>About Us</title>
	<link rel="icon" href="images/hat_white.png">
	<link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/desktop.css">
</head>
<body id="main">
	<header>
		<a href="#" class="responsive-nav" onclick="openNav();clickOpen()">
			<img src="images/nav-white.png" alt='image' id="open-nav">
		</a>
		<a href="index.php" class="logo">
			<img src="images/stema.png" alt='image'>
			<p>Admitere<br>România</p>
		</a>
		<a href="search.html" class="responsive-search">
			<img src="images/search_white.png" alt='image'>
		</a>
		<nav class="navigation" id="mySidenav">
			<a href="#" class="responsive-nav" onclick="closeNav();clickClose()">
			<img src="images/close-white.png" alt='image' id="close-nav">
			</a>
			<ul>
				<li><a href="index.php" class="btn">Home</a></li>
				<li><a href="universities.php" class="btn">Universities</a></li>
				<li><a href="about.php" class="btn" id="active-nav">About Us</a></li>
				<li class="search-field">
					<form method="post" action="search.php">
						<input type="text" name="search" placeholder="Search...">
						<input type="submit" name="submit" value="">
					</form>
				</li>
				<?php
				if(isset($_SESSION['active'])&&($_SESSION['active']==true)){
					if(isAdmin()){
						echo "<li class='login'><a href='admin.php' class='btn'>Hello, ".$_SESSION['user']['prenume']."</a></li>";
					}else{
						echo "<li class='login'><a href='user.php' class='btn'>Hello, ".$_SESSION['user']['prenume']."</a></li>";
					}
				}else{
					echo "<li class='login'><a href='login.php' class='btn'>Log In</a></li>";
				}
				?>
			</ul>
		</nav>
	</header>
	<div class="main" id="about-page">
		<section class="about">
			<header><h1>ABOUT US</h1></header>
			<div class="about-container">
				<img src="images/compsci.jpg" alt='image'>
				<article class="about-box" id="about-1">
					<h2>
						CINE SUNTEM
					</h2>
					<p>
						Suntem o organizație din Republica Moldova care și-a pus scopul să ajute elevii cu admiterea la universitățile din România.
					</p>
				</article>
				<img src="images/univ-bg.jpg" alt='image'>
				<article class="about-box" id="about-2">
					<h2>
						CUM TE PUTEM AJUTA
					</h2>
					<p>
						Noi vrem să îți simplificăm procesul de admitere, oferindu-ți un serviciu centralizat, care conține toată informația necesară și unde poți încărca documentele online, după care noi le trimitem la universitățile alese de tine.
					</p>
				</article>
				<img src="images/question.jpg" alt='image'>
				<article class="about-box" id="about-3">
					<h2>
						CE TREBUIE SĂ FACI
					</h2>
					<p>
						Îți dăm la dispoziție lista cu universitățile din România și toate detaliile ce țin de admitere, tot ce trebuie să faci e să decizi la care universități vrei să aplici și să încarci documentele în format pdf.
					</p>
				</article>
			</div>
		</section>
		<section class="our-team">
			<header><h1>OUR TEAM</h1></header>
			<div class="team-members">
				<img src="images/Denis1.jpg" alt='image' class="member-img">
				<div class="team-member">
				<h2>
					Ursu Denis
				</h2>
				<p>
					Inițiatorul serviciului. Mostly back end. Principalul consumator de cafea din oficiu.
				</p>
				</div>
				<img src="images/Nicoleta1.jpg" alt='image' class="member-img">
				<div class="team-member">
					<h2>
						Botnaru Nicoleta
					</h2>
					<p>
						Ministrul de afaceri externe a site-ului. Omul care se înțelege cu universitățile.
					</p>
				</div>
				<img src="images/Nicu.jpg" alt='image' class="member-img">
				<div class="team-member">
					<h2>
						Gaiduc Nicolae
					</h2>
					<p>
						Design and front end. Talent special în a cauza probleme consumatorului de cafea.
					</p>
				</div>
			</div>
		</section>
	</div>
	<footer>
		<p class="copyright">©Copyright 2020|<a href="http://www.uab.ro/">UAB</a></p>
		<div class="social-media">
			<p>Follow Us:</p>
			<a href="https://www.facebook.com/profile.php?id=100015421026036&ref=bookmarks"><img src="images/facebook.png" alt='image' id="facebook"></a>
			<a href="https://www.instagram.com/medvedev.de/"><img alt='image' src="images/insta.png" id="instagram"></a>
		</div>
	</footer>



	<script>
		function openNav() {
		  	document.getElementById("mySidenav").style.width = "50%";
		}

		function closeNav() {
		  	document.getElementById("mySidenav").style.width = "0";
		}
		function clickOpen(){
			document.getElementById("close-nav").style.transform = "rotate(0deg)";
			document.getElementById("open-nav").style.transform = "rotate(360deg)";
		}
		function clickClose(){
			document.getElementById("open-nav").style.transform = "rotate(0deg)";
			document.getElementById("close-nav").style.transform = "rotate(360deg)";
		}
	</script>
</body>
</html>