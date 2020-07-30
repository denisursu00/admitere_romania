<?php
	session_start();
	include("functions.php");
?>
<!DOCTYPE html>
<html lang="ro">
<head>
	<meta charset="utf-8">
	<title>Admin</title>
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
				if(isset($_SESSION['active'])&&($_SESSION['active']==true)&&isAdmin()){
					echo "<li class='login'><a href='admin.php' class='btn' id='active-nav'>Hello, ".$_SESSION['user']['prenume']."</a></li>";
					echo "<li><a href='logout.php' class='btn'>Log Out</a></li>";
				}else{
					echo "<li class='login'><a href='login.php' class='btn'>Log In, stranger</a></li>";
				}
				?>
			</ul>
		</nav>
	</header>
	<div class="main" id="admin">
		<section class="admin-box">
			<?php
				if(isset($_SESSION['active'])&&($_SESSION['active']==true)&&isAdmin()){
			?>
			<table id="univ">
				<tr>
					<th>ID</th>
					<th>Denumire</th>
					<th>Nr.facultati</th>
					<th>Perioada admitere</th>
					<th>Telefon</th>
					<th>Adresa</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
				<?php
					require("mysql.php");
					$query_univ="SELECT 
									id_universitate,denumire_universitate,nr_facultati,
									DAY(inceput_admitere) AS zi_inceput, MONTH(inceput_admitere) AS luna_inceput,
									DAY(sfarsit_admitere) AS zi_sfarsit, MONTH(sfarsit_admitere) AS luna_sfarsit,
									telefon, adresa
								FROM universitati;";
					$result_univ=mysqli_query($conexiune,$query_univ);
					if(mysqli_num_rows($result_univ)>0){
						$luni=array("Ianuarie","Februarie","Martie","Aprilie","Mai","Iunie","Iulie","August","Septembrie","Octombrie","Noiembrie","Decembrie");
						while($row_univ=mysqli_fetch_assoc($result_univ)){
							echo "<tr>";
								echo "<td>".$row_univ['id_universitate']."</td>";
								echo "<td>".$row_univ['denumire_universitate']."</td>";
								echo "<td>".$row_univ['nr_facultati']."</td>";
								echo "<td>".$row_univ['zi_inceput']." ".$luni[(int)$row_univ['luna_inceput']-1]."-".$row_univ['zi_sfarsit']." ".$luni[(int)$row_univ['luna_sfarsit']-1]."</td>";
								echo "<td>".$row_univ['telefon']."</td>";
								echo "<td>".$row_univ['adresa']."</td>";
								echo "<td><a href='edituniv.php?id=".$row_univ['id_universitate']."'><img src='images/edit.png' alt='Imagine'></a></td>";
								echo "<td><a href='deleteuniv.php?id=".$row_univ['id_universitate']."'><img src='images/delete.png' alt='Imagine'></a></td>";
							echo "</tr>";
						}
					}else{
						echo "<p>Nu aveti universitati!</p>";
					}
				?>
			</table>
			<a href="adduniversity.php" class="add-univ-fac">Adauga Universitarte</a>
			<table id="facult">
				<tr>
					<th>Universitatea</th>
					<th>ID</th>
					<th>Facultate</th>
					<th>Nr.locuri cu bursa</th>
					<th>Nr.locuri fara bursa</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
				<?php
					$query_fac="SELECT id_facultate,denumire_facultate,nr_locuri_bursa,nr_locuri_fara_bursa,denumire_universitate
								FROM facultati
								JOIN universitati on universitati.id_universitate=facultati.id_universitate";
					$result_fac=mysqli_query($conexiune,$query_fac);
					if(mysqli_num_rows($result_fac)>0){
						while($row_fac=mysqli_fetch_assoc($result_fac)){
							echo "<tr>";
							echo "<td>".$row_fac['denumire_universitate']."</td>";
							echo "<td>".$row_fac['id_facultate']."</td>";
							echo "<td>".$row_fac['denumire_facultate']."</td>";
							echo "<td>".$row_fac['nr_locuri_bursa']."</td>";
							echo "<td>".$row_fac['nr_locuri_fara_bursa']."</td>";
							echo "<td><a href='editfac.php?id=".$row_fac['id_facultate']."'><img src='images/edit.png' alt='Imagine'></a></td>";
							echo "<td><a href='deletefac.php?id=".$row_fac['id_facultate']."'><img src='images/delete.png' alt='Imagine'></a></td>";
							echo "</tr>";
						}
					}
				?>
			</table>
			<a class="add-univ-fac" href="addfaculty.php">Adauga Facultate</a>
			<table id="specializari">
				<tr>
					<th>Universitatea</th>
					<th>Facultate</th>
					<th>ID</th>
					<th>Specializarea</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
				<?php
					$query_spec="SELECT id_specializare,denumire_specializare,denumire_universitate,denumire_facultate
								FROM specializari
								JOIN facultati on facultati.id_facultate=specializari.id_facultate
								JOIN universitati on universitati.id_universitate=facultati.id_universitate";
					$result_spec=mysqli_query($conexiune,$query_spec);
					if(mysqli_num_rows($result_spec)>0){
						while($row_spec=mysqli_fetch_assoc($result_spec)){
							echo "<tr>";
							echo "<td>".$row_spec['denumire_universitate']."</td>";
							echo "<td>".$row_spec['denumire_facultate']."</td>";
							echo "<td>".$row_spec['id_specializare']."</td>";
							echo "<td>".$row_spec['denumire_specializare']."</td>";
							echo "<td><a href='editspec.php?id=".$row_spec['id_specializare']."'><img src='images/edit.png' alt='Imagine'></a></td>";
							echo "<td><a href='deletespec.php?id=".$row_spec['id_specializare']."'><img src='images/delete.png' alt='Imagine'></a></td>";
							echo "</tr>";
						}
					}
				?>
			</table>
			<a class="add-univ-fac" href="addspec.php">Adauga Specializare</a>
			<table id="aplicatii">
				<tr>
					<th>User</th>
					<th>Universitate</th>
					<th>Facultate</th>
					<th>Specializare</th>
					<th>C.Inscriere</th>
					<th>C.Nastere</th>
					<th>Pasaport</th>
					<th>C.Casatorie</th>
					<th>Diploma BAC</th>
					<th>Foaia Matricola</th>
					<th>Declaratie</th>
				</tr>
				<?php
					$query_apply="SELECT aplicatii.id_user,email,denumire_universitate,cerere_inscriere,certificat_nastere,pasaport,
										certificat_casatorie,diploma_bac,foaia_matricola,declaratie,id_facultate,id_specializare
									FROM aplicatii
									JOIN universitati ON aplicatii.id_universitate=universitati.id_universitate
									JOIN users ON aplicatii.id_user=users.id_user
									ORDER BY denumire_universitate;";
					$result_apply=mysqli_query($conexiune,$query_apply);
					if(mysqli_num_rows($result_apply)>0){
						while($row_apply=mysqli_fetch_assoc($result_apply)){
							$query_apply_fac="SELECT * FROM facultati WHERE id_facultate=".$row_apply['id_facultate'];
							$result_apply_fac=mysqli_query($conexiune,$query_apply_fac);
							$row_apply_fac=mysqli_fetch_assoc($result_apply_fac);
							$query_apply_spec="SELECT * FROM specializari WHERE id_specializare=".$row_apply['id_specializare'];
							$result_apply_spec=mysqli_query($conexiune,$query_apply_spec);
							if(mysqli_num_rows($result_apply_spec)==1){
								$row_apply_spec=mysqli_fetch_assoc($result_apply_spec);
							}else{
								$row_apply_spec['denumire_specializare']="Nu exista";
							}
							echo "<tr>";
							echo "<td>".$row_apply['email']."</td>";
							echo "<td>".$row_apply['denumire_universitate']."</td>";
							echo "<td>".$row_apply_fac['denumire_facultate']."</td>";
							echo "<td>".$row_apply_spec['denumire_specializare']."</td>";
							echo "<td><a href='data:application/pdf;base64,".$row_apply['cerere_inscriere']."' download='".$row_apply['id_user']."-".$row_apply['id_facultate']."-".$row_apply['id_specializare']."cerere_inscriere'>download</a></td>";
							echo "<td><a href='data:application/pdf;base64,".$row_apply['certificat_nastere']."' download='".$row_apply['id_user']."-".$row_apply['id_facultate']."-".$row_apply['id_specializare']."certificat_nastere'>download</a></td>";
							echo "<td><a href='data:application/pdf;base64,".$row_apply['pasaport']."' download='".$row_apply['id_user']."-".$row_apply['id_facultate']."-".$row_apply['id_specializare']."pasaport'>download</a></td>";
							echo "<td><a href='data:application/pdf;base64,".$row_apply['certificat_casatorie']."' download='".$row_apply['id_user']."-".$row_apply['id_facultate']."-".$row_apply['id_specializare']."certificat_casatorie'>download</a></td>";
							echo "<td><a href='data:application/pdf;base64,".$row_apply['diploma_bac']."' download='".$row_apply['id_user']."-".$row_apply['id_facultate']."-".$row_apply['id_specializare']."diploma_bac'>download</a></td>";
							echo "<td><a href='data:application/pdf;base64,".$row_apply['foaia_matricola']."' download='".$row_apply['id_user']."-".$row_apply['id_facultate']."-".$row_apply['id_specializare']."foaia_matricola'>download</a></td>";
							echo "<td><a href='data:application/pdf;base64,".$row_apply['declaratie']."' download='".$row_apply['id_user']."-".$row_apply['id_facultate']."-".$row_apply['id_specializare']."declaratie'>download</a></td>";
							echo "</tr>";
						}
					}
				?>
			</table>
			<?php
				}
			?>
		</section>
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
	</script>
</body>
</html>