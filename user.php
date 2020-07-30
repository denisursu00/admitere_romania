<?php
	session_start();
	include('functions.php');
	if(isAdmin()) header("location: admin.php")
?>
<!DOCTYPE html>
<html lang="ro">
<head>
	<meta charset="utf-8">
	<title>User</title>
	<link rel="icon" href="images/hat_white.png">
	<link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/desktop.css">
</head>
<body id="main">
	<header>
		<a href="#" class="responsive-nav" onclick="openNav();clickOpen()">
			<img src="images/nav-white.png" alt='Imagine' id="open-nav">
		</a>
		<a href="index.php" class="logo">
			<img src="images/stema.png" alt='Imagine'>
			<p>Admitere<br>România</p>
		</a>
		<a href="search.php" class="responsive-search">
			<img src="images/search_white.png" alt='Imagine'>
		</a>
		<nav class="navigation" id="mySidenav">
			<a href="#" class="responsive-nav" onclick="closeNav();clickClose()">
			<img src="images/close-white.png" alt='Imagine' id="close-nav">
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
						echo "<li><a href='logout.php' class='btn'>Log Out</a></li>";
					}else{
						echo "<li class='login'><a href='user.php' class='btn' id='active-nav'>Hello, ".$_SESSION['user']['prenume']."</a></li>";
						echo "<li><a href='logout.php' class='btn'>Log Out</a></li>";
					}
				}else{
					echo "<li class='login'><a href='login.php' class='btn'>Log In, stranger</a></li>";
				}
				?>
			</ul>
		</nav>
	</header>
	<section class="main" id="user">
		<section class="user-box">
			<header>
				<img src="images/hat_white.png" alt='Imagine'>
				<h1>Your Universities:</h1>
			</header>
			<?php
				if(isset($_SESSION['active'])&&($_SESSION['active']==true)){
					require("mysql.php");
					$id_user=$_SESSION['user']['id_user'];
					$query_select="SELECT denumire_universitate,photo_universitate,nr_facultati,adresa,telefon,id_facultate,id_specializare FROM users
									JOIN aplicatii on aplicatii.id_user=users.id_user
									JOIN universitati on universitati.id_universitate=aplicatii.id_universitate
									WHERE users.id_user='$id_user'";
					$result_select=mysqli_query($conexiune,$query_select);
					if(mysqli_num_rows($result_select)>0){
						while($row_select=mysqli_fetch_assoc($result_select)){
							$adresa=$row_select['adresa'];
							$adresa=explode(", ",$adresa);
							$query_fac="SELECT * FROM facultati WHERE id_facultate=".$row_select['id_facultate'];
							$result_fac=mysqli_query($conexiune,$query_fac);
							$row_fac=mysqli_fetch_assoc($result_fac);
							$query_spec="SELECT * FROM specializari WHERE id_specializare=".$row_select['id_specializare'];
							$result_spec=mysqli_query($conexiune,$query_spec);
							if(mysqli_num_rows($result_spec)==1){
								$row_spec=mysqli_fetch_assoc($result_spec);
							}else{
								$row_spec['denumire_specializare']="Nu exista";
							}
							echo "<div class='university info-univ'>";
							echo 	"<img src='data:image;base64,".$row_select['photo_universitate']."' alt='there is no image!' class='univ-img'>";
							echo 	"<article>";
							echo 		"<h3>".$row_select['denumire_universitate']."</h3>";
							echo 		"<p><strong>Localitatea:</strong> ".$adresa[0]."<br>".$adresa[1]."</p>";
							echo 		"<p><strong>Facultatea:</strong> ".$row_fac['denumire_facultate']."</p>";
							echo 		"<p><strong>Specializarea:</strong> ".$row_spec['denumire_specializare']."</p>";
							echo 		"<p><strong>Telefon:</strong> ".$row_select['telefon']."</p>";
							echo 	"</article>";
							echo "</div>"; 
						}
					}
				}
			?>
		</section>
	</section>
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
			document.getElementById("user").style.height="auto";
		}

	</script>
</body>
</html>