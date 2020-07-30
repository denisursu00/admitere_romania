<?php
	session_start();
	include("functions.php");
?>
<!DOCTYPE html>
<html lang="ro">
<head>
	<meta charset="utf-8">
	<title>Home</title>
	<link rel="icon" href="images/hat_white.png">
	<link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/desktop.css">
</head>
<body id="main">
	<header>
		<a href="#" class="responsive-nav" onclick="openNav();clickOpen()">
			<img src="images/nav-white.png" alt="Imagine" id="open-nav">
		</a>
		<a href="index.php" class="logo">
			<img src="images/stema.png" alt="Imagine">
			<p>Admitere<br>România</p>
		</a>
		<a href="search.php" class="responsive-search">
			<img src="images/search_white.png" alt="Imagine">
		</a>
		<nav class="navigation" id="mySidenav">
			<a href="#" class="responsive-nav" onclick="closeNav();clickClose()">
			<img src="images/close-white.png" alt="Imagine" id="close-nav">
			</a>
			<ul>
				<li><a href="index.php" class="btn" id="active-nav">Home</a></li>
				<li><a href="universities.php" class="btn">Universities</a></li>
				<li><a href="about.php" class="btn">About Us</a></li>
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
	<div class="main" id="home-page">
		<section class="info-box">
			<div>
				<article id="text">
				<h1>Oportunitatea vietii tale</h1>
				<p>
					De peste 10 ani statul Roman ofera locuri de studii pentru romanii
					de pretutindeni, in fiecare an crescand numarul de oameni care ar dori sa primeasca studii de nivel european.
					<br>
					Noi ne-am pus scopul de a ajuta tinerii sa-si gaseasca universitatea potrivita si de a le oferi toata informatia necesara pentru admitere.
				</p>
				</article>
			</div>
			<img src="images/benches.jpg" alt="Imagine">
		</section>
		<section class="round-images">
			<div class="hat">
				<img src="images/hat_white.png" alt="Imagine">
				<p>Colaborare cu<br>universitatile</p>
			</div>
			<div class="docs">
				<img src="images/documents_white.png" alt="Imagine">
				<p>Incarcarea<br>documentelor</p>
			</div>
			<div class="info">
				<img src="images/info_white.png" alt="Imagine">
				<p>Informatii<br>actualizate</p>
			</div>
			<div class="consult">
				<img src="images/consult_white.png" alt="Imagine">
				<p>Consultatii<br>gratuite</p>
			</div>
		</section>
	</div>
	<footer>
		<p class="copyright">©Copyright 2020|<a href="http://www.uab.ro/">UAB</a></p>
		<div class="social-media">
			<p>Follow Us:</p>
			<a href="https://www.facebook.com/profile.php?id=100015421026036&ref=bookmarks"><img src="images/facebook.png" alt="Imagine" id="facebook"></a>
			<a href="https://www.instagram.com/medvedev.de/"><img src="images/insta.png" alt="Imagine" id="instagram"></a>
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
			document.getElementById("open-nav").style.transform = "rotate(180deg)";
		}
		function clickClose(){
			document.getElementById("open-nav").style.transform = "rotate(0deg)";
			document.getElementById("close-nav").style.transform = "rotate(360deg)";
		}
	</script>
</body>
</html>