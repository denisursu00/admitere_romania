<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="ro">
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
			<p class="sign-title">Add Specialisation</p>
			<?php
				include('functions.php');
					if(isset($_SESSION['active'])&&($_SESSION['active']==true)&&isAdmin()){
						require("mysql.php");
						if (isset($_POST['submit_spec'])){
								$denumire=$_POST['denumire'];
								$descriere=$_POST['descriere'];
								$id_fac=(int)$_POST['selectSpecializare'];
                                $query_insert_spec="INSERT INTO specializari(denumire_specializare,descriere,id_facultate)
												VALUES(?,?,?);";
                                $stmt = $conexiune->prepare($query_insert_spec);
                                $stmt->bind_param("ssi",$denumire,$descriere,$id_fac);
                                if(!$stmt->execute()) {
                                    echo mysqli_error($conexiune);
                                } else {
                                    echo "<p>Datele inserate cu succes!</p>";
                                    echo "<p>Please proceed to :<a href='admin.php'>Admin</a></p>";
                                }
						}else{
							?>
							<form autocomplete='off' method='post' action='addspec.php'>
								<label>Denumire:</label><br>
								<input type='text' name='denumire' placeholder='Specializarea...' required><br>
								<label>Descriere:</label><br>
								<input type='text' name='descriere' placeholder='Descrierea specializarii'><br>
								<label>Facultatea:</label><br>
								<select name="selectSpecializare">
									<option>Select Faculty...</option>
									<?php
										$query_select_faculties="SELECT id_facultate, denumire_facultate, denumire_universitate FROM facultati
																		JOIN universitati on universitati.id_universitate=facultati.id_universitate
																		ORDER BY denumire_universitate;";
										$result_select_faculties=mysqli_query($conexiune,$query_select_faculties);
										if(mysqli_num_rows($result_select_faculties)>0){
											while($row_select_fac=mysqli_fetch_assoc($result_select_faculties)){
												echo "<option value='".$row_select_fac['id_facultate']."'>".$row_select_fac['denumire_universitate'].": ".$row_select_fac['denumire_facultate']."</option>";
											}
										}else{
											echo "<option>Nu aveti facultati</option>";
										}
									?>
								</select>
								<input type='submit' name='submit_spec' value='Submit'>
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