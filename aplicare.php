<?php
	session_start();
	include("functions.php");
?>
<!DOCTYPE html>
<html lang="ro">
<head>
	<title>Apply</title>
	<meta charset="utf-8">
	<link rel="icon" href="images/hat_white.png">
	<link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/desktop.css">
</head>
<body id="main-apply">
	<div class="main" id="apply">
		<div class="apply-box">
			<a href="index.php" class="sign-logo">
				<img src="images/stema.png" alt="there is no image!">
				<h1>Admitere<br>România</h1>
			</a>
			<?php
				require("mysql.php");
				if(isset($_GET['id_univ'])&&isset($_SESSION['active'])&&($_SESSION['active']==true)){
					$id_universitate=(int)$_GET['id_univ'];
					$id_user=(int)$_SESSION['user']['id_user'];
					$query_select_univ="SELECT denumire_universitate FROM universitati WHERE id_universitate='$id_universitate'";
					$result_select_univ=mysqli_query($conexiune,$query_select_univ);
					$row_select_univ=mysqli_fetch_assoc($result_select_univ);
					$denumire=$row_select_univ['denumire_universitate'];
					$denumire=substr($denumire,14);
					echo "<p class='apply-title'>Apply to Universitatea<br>".$denumire."</p>";
					if(isset($_POST['submit'])){
							$id_facultate=$_POST['selectFacultate'];
							$id_specializare=$_POST['selectSpecializare'];
							$cerere_inscriere=encodeFile($_FILES['cerere_inscriere']['tmp_name']);
							$certificat_nastere=encodeFile($_FILES['certificat_nastere']['tmp_name']);
							$pasaport=encodeFile($_FILES['pasaport']['tmp_name']);
							$diploma_bac=encodeFile($_FILES['diploma_bac']['tmp_name']);
							$foaia_matricola=encodeFile($_FILES['foaia_matricola']['tmp_name']);
							$declaratia=encodeFile($_FILES['declaratia']['tmp_name']);
							if($_FILES['certificat_casatorie']['size']!=0){
								$certificat_casatorie=encodeFile($_FILES['certificat_casatorie']['tmp_name']);
							}else{$certificat_casatorie=null;}
							$query_insert_apply="INSERT INTO aplicatii
												VALUES('','$id_facultate','$id_specializare','$cerere_inscriere','$certificat_nastere',
												'$pasaport','$certificat_casatorie','$diploma_bac','$foaia_matricola','$declaratia',
												'$id_universitate','$id_user');";
							$result_insert=mysqli_query($conexiune,$query_insert_apply);
						if(!$result_insert){
							echo "<p class='error-text'>S-a produs o eroare!</p>";
							echo mysqli_error($conexiune);
						}else{
							echo "<p class='success-text'>Succes!</p>";
							echo "<meta http-equiv=\"refresh\" content=\"1; URL='universities.php'\" >";
						}
					}
				}else{
					echo "<p class='apply-title'>Go away, intruder!</p>";
				}
			?>
			<form autocomplete="off" method="post" enctype="multipart/form-data">
				<label>Facultatea:</label><br>
				<select name="selectFacultate">
					<option>Select Faculty...</option>
						<?php
							$query_select_faculties="SELECT id_facultate, denumire_facultate FROM facultati
													JOIN universitati on universitati.id_universitate=facultati.id_universitate
													WHERE universitati.id_universitate='$id_universitate'";
							$result_select_faculties=mysqli_query($conexiune,$query_select_faculties);
							if(mysqli_num_rows($result_select_faculties)>0){
								while($row_select_fac=mysqli_fetch_assoc($result_select_faculties)){
									echo "<option value='".$row_select_fac['id_facultate']."'>".$row_select_fac['denumire_facultate']."</option>";
								}
							}else{
								echo "<option>Nu aveti facultati</option>";
							}
						?>
				</select><br>
				<label>Specializarea:</label><br>
				<select name="selectSpecializare">
					<option>Select Specialisation...</option>
						<?php
							$query_select_spec="SELECT id_specializare, denumire_specializare, denumire_facultate FROM specializari
													JOIN facultati on facultati.id_facultate=specializari.id_facultate
													JOIN universitati on universitati.id_universitate=facultati.id_universitate
													WHERE universitati.id_universitate='$id_universitate'";
							$result_select_spec=mysqli_query($conexiune,$query_select_spec);
							if(mysqli_num_rows($result_select_spec)>0){
								while($row_select_spec=mysqli_fetch_assoc($result_select_spec)){
									echo "<option value='".$row_select_spec['id_specializare']."'>".$row_select_spec['denumire_facultate'].": ".$row_select_spec['denumire_specializare']."</option>";
								}
							}else{
								echo "<option>Nu exista specializari</option>";
							}
						?>
				</select><br>
				<label>Cerere Inscriere(pdf):</label><br>
				<input type="file" name="cerere_inscriere" accept="application/pdf" required>
				<label>Certificat de nastere(pdf):</label><br>
				<input type="file" name="certificat_nastere" accept="application/pdf" required>
				<label>Pasaport(pdf):</label><br>
				<input type="file" name="pasaport" accept="application/pdf" required>
				<label>Certificat casatorie(daca este cazul)(pdf):</label><br>
				<input type="file" name="certificat_casatorie" accept="application/pdf">
				<label>Diploma Bac(pdf):</label><br>
				<input type="file" name="diploma_bac" accept="application/pdf" required>
				<label>Foaia Matricola(pdf):</label><br>
				<input type="file" name="foaia_matricola" accept="application/pdf" required>
				<label>Declaratia(pdf):</label><br>
				<input type="file" name="declaratia" accept="application/pdf" required>
				<input type="submit" name="submit" value="Submit">
			</form>
		</div>
	</div>
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