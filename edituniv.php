<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
	<title>Edit University</title>
	<link rel="icon" href="images/hat_white.png">
	<link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/desktop.css">
</head>
<body id="main">
	<div class="main" id="edit">
		<div class="login-box" id="univ-data">
			<a href="index.php" class="sign-logo">
				<img src="images/stema.png" alt="there is no image!">
				<h1>Admitere<br>România</h1>
			</a>
			<p class="sign-title">Edit University</p>
			<?php
				include('functions.php');
					if(isset($_SESSION['active'])&&($_SESSION['active']==true)&&isAdmin()){
						if(isset($_GET['id'])){
							$id=$_GET['id'];
							require("mysql.php");
							if (isset($_POST['submit_univ'])){
								$denumire=$_POST['denumire'];
								$nr_facult=$_POST['nr_facult'];
								$inceput_admitere=$_POST['inceput_admitere'];
								$sfarsit_admitere=$_POST['sfarsit_admitere'];
								$telefon=$_POST['telefon'];
								$adresa=$_POST['adresa'];
								$photo_univ=addslashes($_FILES['photo_universitate']['tmp_name']);
								$photo_univ=file_get_contents($photo_univ);
								$photo_univ=base64_encode($photo_univ);
								$query_update_university="UPDATE universitati SET
															denumire_universitate='$denumire',
															nr_facultati='$nr_facult',
															inceput_admitere='$inceput_admitere',
															sfarsit_admitere='$sfarsit_admitere',
															telefon='$telefon',
															adresa='$adresa',
															photo_universitate='$photo_univ'
															WHERE id_universitate='$id';";
								$result_update=mysqli_query($conexiune,$query_update_university);
								if(!$result_update){
									echo mysqli_error($conexiune);
								}else{
									echo "<p>Datele actualizate cu succes!</p>";
									echo "<p>Please proceed to :<a href='admin.php'>Admin</a></p>";
								}
							}else{
									$query_select_univ="SELECT * FROM universitati WHERE id_universitate='$id'";
									$result_select=mysqli_query($conexiune,$query_select_univ);
									$row_select=mysqli_fetch_assoc($result_select);
								?>
								<form autocomplete='off' method='post' action='edituniv.php?id=<?=$id?>' enctype="multipart/form-data">
									<label>Denumire:</label><br>
									<input type='text' name='denumire' value='<?=$row_select["denumire_universitate"]?>' required><br>
									<label>Numar de facultati:</label><br>
									<input type='text' name='nr_facult' value="<?=$row_select['nr_facultati']?>" required><br>
									<label>Inceput admitere:</label><br>
									<input type='date' name='inceput_admitere' value="<?=$row_select['inceput_admitere']?>"><br>
									<label>Sfarsit admitere:</label><br>
									<input type='date' name='sfarsit_admitere' value="<?=$row_select['sfarsit_admitere']?>"><br>
									<label>Telefon:</label><br>
									<input type='text' name='telefon' value="<?=$row_select['telefon']?>" required><br>
									<label>Adresa:</label><br>
									<input type='text' name='adresa' value="<?=$row_select['adresa']?>" required><br>
									<label>Photo universitate:</label>
									<input type="file" accept="image/*" name="photo_universitate" required>
									<input type='submit' name='submit_univ' value='Submit'>
								</form>
								<p>Back Admin page:<a href='admin.php'>Admin</a></p>
								<?php
							}
							mysqli_close($conexiune);
						}else{
							echo "<p class='error-text'>University id not set!</p>";
						}
					}else {
                        echo "<p class='error-text'>INTRUDER ALERT</p>";
                    }
			?>
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