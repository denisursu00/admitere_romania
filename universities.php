<?php
	session_start();
	include("functions.php");
?>
<!DOCTYPE html>
<html lang="ro">
<head>
	<meta charset="utf-8">
	<title>Universities</title>
	<link rel="icon" href="images/hat_white.png">
	<link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/desktop.css">
</head>
<body id="main-universities">
	<header>
		<a href="#" class="responsive-nav" onclick="openNav();clickOpen()">
			<img src="images/nav-white.png" alt='Imagine' id="open-nav">
		</a>
		<a href="index.php" class="logo">
			<img src="images/stema.png" alt='Imagine'>
			<p>Admitere<br>România</p>
		</a>
		<a href="search.html" class="responsive-search">
			<img src="images/search_white.png" alt='Imagine'>
		</a>
		<nav class="navigation" id="mySidenav">
			<a href="#" class="responsive-nav" onclick="closeNav();clickClose()">
			<img src="images/close-white.png" alt='Imagine' id="close-nav">
			</a>
			<ul>
				<li><a href="index.php" class="btn">Home</a></li>
				<li><a href="universities.php" class="btn" id="active-nav">Universities</a></li>
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
	<div class="main" id="universities">
		<div class="info-univ" id="hat">
			<img src="images/hat_white.png" alt='Imagine'>
			<article>
				<h1>Universitatile partenere:</h1>
				<p>Aici iti oferim toata informatia necesara<br>pentru admiterea la universitatile partenere</p>
			</article>
		</div>
		<?php
			require("mysql.php");
			$query_universitati="SELECT * FROM universitati";
			$result_universitati = mysqli_query($conexiune,$query_universitati);
			if(mysqli_num_rows($result_universitati)>0){
				while ($row_univ=mysqli_fetch_assoc($result_universitati)){
					$adresa=$row_univ['adresa'];
					$adresa=explode(", ",$adresa);
					echo "<div class='university info-univ'>";
					echo 	"<img src='data:image;base64,".$row_univ['photo_universitate']."' alt='there is no image!' class='univ-img'>";
					echo 	"<article>";
					echo 		"<h3>".$row_univ['denumire_universitate']."</h3>";
					echo 		"<p><strong>Localitatea:</strong> ".$adresa[0]."<br>".$adresa[1]."</p>";
					echo 		"<p><strong>Numarul de facultati:</strong> ".$row_univ['nr_facultati']."</p>";
					echo 		"<p><strong>Telefon:</strong> ".$row_univ['telefon']."</p>";
					echo 		"<a href='university.php?id=".$row_univ['id_universitate']."'>Afiseaza<br>mai multe</a>";
					echo 	"</article>";
					echo "</div>"; 
				}
			}else{
				echo "<h1 class='error-text'>Nu aveti universitati!</h1>";
			}
		?>
	</div>
	<footer>
		<p class="copyright">©Copyright 2020|<a href="http://www.uab.ro/">UAB</a></p>
		<div class="social-media">
			<p>Follow Us:</p>
			<a href="https://www.facebook.com/profile.php?id=100015421026036&ref=bookmarks"><img src="images/facebook.png" alt='Imagine' id="facebook"></a>
			<a href="https://www.instagram.com/medvedev.de/"><img src="images/insta.png" alt='Imagine' id="instagram"></a>
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
		var nodesSameClass = document.getElementsByClassName("university");
		if(nodesSameClass.length>3){
			document.getElementById("universities").style.height="auto";
		}
	</script>
</body>
</html>