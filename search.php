<?php
	session_start();
	include('functions.php');
?>
<!DOCTYPE html>
<html lang="ro">
<head>
	<meta charset="utf-8">
	<title>Search</title>
	<link rel="icon" href="images/hat_white.png">
	<link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/desktop.css">
</head>
<body id="main">
	<header>
		<a href="#" class="responsive-nav" onclick="openNav();clickOpen()">
			<img src="images/nav-white.png" alt='Image' id="open-nav">
		</a>
		<a href="index.php" class="logo">
			<img src="images/stema.png" alt='Image'>
			<p>Admitere<br>România</p>
		</a>
		<a href="search.php" class="responsive-search">
			<img src="images/search_white.png" alt='Image'>
		</a>
		<nav class="navigation" id="mySidenav">
			<a href="#" class="responsive-nav" onclick="closeNav();clickClose()">
			<img src="images/close-white.png" alt='Image' id="close-nav">
			</a>
			<ul>
				<li><a href="index.php" class="btn">Home</a></li>
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
					echo "<li class='login'><a href='login.php' class='btn'>Log In, stranger</a></li>";
				}
				?>
			</ul>
		</nav>
	</header>
	<div class="main" id="main-search">
		<section class="search-box">
			<header class="search-head">
				<h1>Cautare:</h1>
			</header>
			<div class="search-field" id="page-search-field">
				<form method="post" action="search.php">
					<input type="text" name="search" placeholder="Search...">
					<input type="submit" name="submit" value="">
				</form>
			</div>
			<header class="search-head">
				<h1>Rezultatele cautarii:</h1>
			</header>
			<?php
				require("mysql.php");
				if(isset($_POST['submit'])){
					$denumire=$_POST['search'];
					$query_search = "SELECT * FROM universitati WHERE LOWER(denumire_universitate) LIKE '%".$denumire."%' 
																OR denumire_universitate LIKE '%".$denumire."%'";
					$result_search=mysqli_query($conexiune,$query_search);
					if(mysqli_num_rows($result_search)>0){
						while($row_search=mysqli_fetch_assoc($result_search)){
							$adresa=$row_search['adresa'];
							$adresa=explode(", ",$adresa);
							echo "<div class='university info-univ'>";
							echo 	"<img src='data:image;base64,".$row_search['photo_universitate']."' alt='there is no image!' class='univ-img'>";
							echo 	"<article>";
							echo 		"<h3>".$row_search['denumire_universitate']."</h3>";
							echo 		"<p><strong>Localitatea:</strong> ".$adresa[0]."<br>".$adresa[1]."</p>";
							echo 		"<p><strong>Numarul de facultati:</strong> ".$row_search['nr_facultati']."</p>";
							echo 		"<p><strong>Telefon:</strong> ".$row_search['telefon']."</p>";
							echo 		"<a href='university.php?id=".$row_search['id_universitate']."'>Afiseaza<br>mai multe</a>";
							echo 	"</article>";
							echo "</div>"; 
						}
					}else{
						echo "<p class='search-result'>Nu am gasit rezultate!</p>";
					}
				}
			?>
		</section>
	</div>
	<footer>
		<p class="copyright">©Copyright 2020|<a href="http://www.uab.ro/">UAB</a></p>
		<div class="social-media">
			<p>Follow Us:</p>
			<a href="https://www.facebook.com/profile.php?id=100015421026036&ref=bookmarks"><img src="images/facebook.png" alt='Image' id="facebook"></a>
			<a href="https://www.instagram.com/medvedev.de/"><img src="images/insta.png" alt='Image' id="instagram"></a>
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
		if(nodesSameClass.length>2){
			document.getElementById("main-search").style.height="auto";
		}
	</script>
</body>
</html>