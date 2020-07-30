<?php
	session_start();
	include("functions.php");
?>
<!DOCTYPE html>
<html lang="ro">
<head>
	<meta charset="utf-8">
	<title>Universitate</title>
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
	<div class="main" id="univ-page">
		<?php
			require("mysql.php");
			if(isset($_GET['id'])){
				$id=$_GET['id'];
				$select_univ="SELECT * FROM universitati WHERE id_universitate='$id'";
				$query_locuri="SELECT SUM(nr_locuri_bursa+nr_locuri_fara_bursa) as total_locuri,
											SUM(nr_locuri_bursa) as locuri_bursa,
											SUM(nr_locuri_fara_bursa) as locuri_f_bursa from facultati where id_universitate='$id'";
				$query_data="SELECT DAY(inceput_admitere) AS zi_inceput, MONTH(inceput_admitere) AS luna_inceput,
									DAY(sfarsit_admitere) AS zi_sfarsit, MONTH(sfarsit_admitere) AS luna_sfarsit 
									FROM universitati WHERE id_universitate='$id'";
				$result_data=mysqli_query($conexiune,$query_data);
				$result_locuri=mysqli_query($conexiune,$query_locuri);
				$result_select=mysqli_query($conexiune,$select_univ);
				$luni=array("Ianuarie","Februarie","Martie","Aprilie","Mai","Iunie","Iulie","August","Septembrie","Octombrie","Noiembrie","Decembrie");
				if(mysqli_num_rows($result_select)>0){
					$row_locuri=mysqli_fetch_assoc($result_locuri);
					$row_data=mysqli_fetch_assoc($result_data);
					while($row_select=mysqli_fetch_assoc($result_select)){
						$adresa=$row_select['adresa'];
						$adresa=explode(", ",$adresa);
						echo "<section class='university-header'>";
						echo 	"<img src='data:image;base64,".$row_select['photo_universitate']."' alt='Imagine'>";
						echo 	"<article class='university-info'>";
						echo 		"<h1>".$row_select['denumire_universitate']."<br>din ".$adresa[0]."</h1>";
						echo 		"<p><strong>Localitatea:</strong> ".$adresa[0]."<br>".$adresa[1]."</p>";
						echo 		"<p><strong>Numarul de facultati:</strong> ".$row_select['nr_facultati']."</p>";
						echo 		"<p><strong>Telefon:</strong> ".$row_select['telefon']."</p>";
						echo 		"<p><strong>Numarl total de locuri:</strong> ".$row_locuri['total_locuri']."</p>";
						echo 		"<p><strong>Numarl de locuri cu bursa:</strong> ".$row_locuri['locuri_bursa']."</p>";
						echo 		"<p><strong>Numarl de locuri fara bursa:</strong> ".$row_locuri['locuri_f_bursa']."</p>";
						echo 		"<p><strong>Perioada de admitere:</strong> ".$row_data['zi_inceput']." ".$luni[(int)$row_data['luna_inceput']-1]."-".$row_data['zi_sfarsit']." ".$luni[(int)$row_data['luna_sfarsit']-1]."</p>";
						echo 	"</article>";
						echo "</section>";
					}
				}
				$select_facult="SELECT * FROM facultati WHERE id_universitate='$id'";
				$result_facult=mysqli_query($conexiune,$select_facult);
				$nr_fac=1;
				if(mysqli_num_rows($result_facult)>0){
					while($row_facult=mysqli_fetch_assoc($result_facult)){
						$faculty=$row_facult['id_facultate'];
						$select_spec="SELECT denumire_specializare FROM specializari WHERE id_facultate='$faculty'";
						$result_spec=mysqli_query($conexiune,$select_spec);
						$string_spec="";
						if(mysqli_num_rows($result_spec)>0){
							while($row_spec=mysqli_fetch_assoc($result_spec)){
								$string_spec=$string_spec.$row_spec['denumire_specializare'].", ";
							}
							$string_spec=rtrim($string_spec,", ");
						}else {$string_spec="Nu exista specializari.";}
						echo "<section class='faculty'>";
						echo 	"<div class='faculty-header'>";
						echo 		"<button class='plus-btn' id='plus".$nr_fac."' onclick='openFacultate(this.id)'></button>";
						echo 		"<button id='minus".$nr_fac."' onclick='closeFacultate(this.id)'></button>";
						echo 		"<h2>".$row_facult['denumire_facultate']."</h2>";
						echo 	"</div>";
						echo 	"<div class='faculty-info' id='facultate".$nr_fac."'>";
						echo 		"<img src='data:image;base64,".$row_facult['photo_facultate']."' alt='Imagine'>";
						echo 		"<article class='box'>";
						echo 			"<p class='paragraf'>".$row_facult['descriere']."</p>";
						echo 			"<p><strong>Specializari: </strong>".$string_spec."</p>";
						echo 			"<p><strong>Numarl de locuri cu bursa:</strong> ".$row_facult['nr_locuri_bursa']."</p>";
						echo 			"<p><strong>Numarl de locuri fara bursa:</strong> ".$row_facult['nr_locuri_fara_bursa']."</p>";
						echo 		"</article>";
						echo 	"</div>";
						echo "</section>";
						$nr_fac++;
					}
				}
			}
			if(isset($_SESSION['active'])&&($_SESSION['active']==true)){
				echo "<a href='aplicare.php?id_univ=".$id."' class='apply-btn'>Aplica</a>";
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
		function openFacultate(elem_id){
			var lung=elem_id.length;
			var nr=elem_id[lung-1];
			document.getElementById("facultate"+nr).style.height = "auto";
			document.getElementById("plus"+nr).style.display="none";
			document.getElementById("minus"+nr).style.display="flex";
		}
		function closeFacultate(elem_id){
			var lung=elem_id.length;
			var nr=elem_id[lung-1];
			document.getElementById("facultate"+nr).style.height = "0";
			document.getElementById("plus"+nr).style.display="flex";
			document.getElementById("minus"+nr).style.display="none";
		}
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