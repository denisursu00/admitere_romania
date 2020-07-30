<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
	<title>Add University</title>
	<link rel="icon" href="images/hat_white.png">
	<link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/desktop.css">
</head>
<body id="main">
	<div class="main" id="add">
		<div class="login-box" id="univ-data">
			<a href="index.php" class="sign-logo">
				<img src="images/stema.png" alt="there is no image!">
				<h1>Admitere<br>România</h1>
			</a>
			<p class="sign-title">Add University</p>
			<?php
				include('functions.php');
					if(isset($_SESSION['active'])&&($_SESSION['active']==true)&&isAdmin()){
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
                                $query_insert_university="INSERT INTO universitati(denumire_universitate,nr_facultati,inceput_admitere,sfarsit_admitere,telefon,adresa,photo_universitate)
												VALUES(?,?,?,?,?,?,?);";
                                $stmt = $conexiune->prepare($query_insert_university);
                                $stmt->bind_param("sissssb",$denumire,$nr_facult,$inceput_admitere,$sfarsit_admitere,$telefon,$adresa,$photo_univ);
                                if(!$stmt->execute()) {
                                    echo mysqli_error($conexiune);
                                } else {
                                    echo "<p>Datele inserate cu succes!</p>";
                                    echo "<p>Please proceed to :<a href='admin.php'>Admin</a></p>";
                                }

								/*$query_insert_university="INSERT INTO universitati
												VALUES('','$denumire','$nr_facult','$inceput_admitere','$sfarsit_admitere','$telefon','$adresa','$photo_univ');";
								$result_insert=mysqli_query($conexiune,$query_insert_university);
								if(!$result_insert){
									echo mysqli_error($conexiune);
								}else{
									echo "<p>Datele inserate cu succes!</p>";
									echo "<p>Please proceed to :<a href='admin.php'>Admin</a></p>";
								}*/
						}else{
							?>
							<form autocomplete='off' method='post' action='adduniversity.php' enctype="multipart/form-data">
								<label>Denumire:</label><br>
								<input type='text' name='denumire' placeholder='Universitatea...' required><br>
								<label>Numar de facultati:</label><br>
								<input type='text' name='nr_facult' placeholder='5' required><br>
								<label>Inceput admitere:</label><br>
								<input type='date' name='inceput_admitere' placeholder=''><br>
								<label>Sfarsit admitere:</label><br>
								<input type='date' name='sfarsit_admitere' placeholder=''><br>
								<label>Telefon:</label><br>
								<input type='text' name='telefon' placeholder='0795898745' required><br>
								<label>Adresa:</label><br>
								<input type='text' name='adresa' placeholder='Oras, strada, nr' required><br>
								<label>Photo universitate:</label>
								<input type="file" accept="image/*" name="photo_universitate" required>
								<input type='submit' name='submit_univ' value='Submit'>
							</form>
							<p>Back Admin page:<a href='admin.php'>Admin</a></p>
							<?php
						}
						mysqli_close($conexiune);
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