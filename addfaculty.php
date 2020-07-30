<?php
	session_start();
?>
<!DOCTYPE html>
<html lang='ro'>
<head>
	<title>Add Faculty</title>
	<link rel="icon" href="images/hat_white.png">
	<link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/desktop.css">
</head>
<body id="main">
	<div class="main" id="login">
		<div class="login-box" id="fac-data">
			<a href="index.php" class="sign-logo">
				<img src="images/stema.png" alt="there is no image!">
				<h1>Admitere<br>România</h1>
			</a>
			<p class="sign-title">Add Faculty</p>
			<?php
				include('functions.php');
					if(isset($_SESSION['active'])&&($_SESSION['active']==true)&&isAdmin()){
						require("mysql.php");
						if (isset($_POST['submit_fac'])){
								$denumire=$_POST['denumire'];
								$nr_loc_bur=$_POST['nr_loc_bur'];
								$nr_loc_f_bur=$_POST['nr_loc_f_bur'];
								$descriere=$_POST['descriere'];
								$photo_fac=addslashes($_FILES['photo_facultate']['tmp_name']);
								$photo_fac=file_get_contents($photo_fac);
								$photo_fac=base64_encode($photo_fac);
								$id_univ=(int)$_POST['selectUniversitate'];
                                $query_insert_faculty="INSERT INTO facultati(denumire_facultate,nr_locuri_bursa,nr_locuri_fara_bursa,descriere,photo_facultate,id_universitate)
												VALUES(?,?,?,?,?,?);";
                                $stmt = $conexiune->prepare($query_insert_faculty);
                                $stmt->bind_param("siisbi",$denumire,$nr_loc_bur,$nr_loc_f_bur,$descriere,$photo_fac,$id_univ);
                                if(!$stmt->execute()) {
                                    echo mysqli_error($conexiune);
                                } else {
                                    echo "<p>Datele inserate cu succes!</p>";
                                    echo "<p>Please proceed to :<a href='admin.php'>Admin</a></p>";
                                }
						}else{
							?>
							<form autocomplete='off' method='post' action='addfaculty.php' enctype="multipart/form-data">
								<label>Denumire:</label><br>
								<input type='text' name='denumire' placeholder='Facultatea...' required><br>
								<label>Numar de locuri cu bursa:</label><br>
								<input type='text' name='nr_loc_bur' placeholder='5' required><br>
								<label>Numar de locuri fara bursa:</label><br>
								<input type='text' name='nr_loc_f_bur' placeholder='5'><br>
								<label>Descriere:</label><br>
								<input type='text' name='descriere' placeholder='Descrierea facultatii'><br>
								<label>Photo facultate:</label>
								<input type="file" accept="image/*" name="photo_facultate" required>
								<label>Universitatea:</label><br>
								<select name="selectUniversitate">
									<option>Select University...</option>
									<?php
										$query_select_universities="SELECT * FROM universitati";
										$result_select_universities=mysqli_query($conexiune,$query_select_universities);
										if(mysqli_num_rows($result_select_universities)>0){
											while($row_select_univ=mysqli_fetch_assoc($result_select_universities)){
												echo "<option value='".$row_select_univ['id_universitate']."'>".$row_select_univ['denumire_universitate']."</option>";
											}
										}else{
											echo "<option>Nu aveti unversitati</option>";
										}
									?>
								</select>
								<input type='submit' name='submit_fac' value='Submit'>
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