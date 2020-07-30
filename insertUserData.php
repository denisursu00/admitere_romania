<!DOCTYPE html>
<html lang="ro">
<head>
	<meta charset="utf-8">
	<title>Sign Up</title>
	<link rel="icon" href="images/hat_white.png">
	<link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/desktop.css">
</head>
<body id="main">
	<div class="main" id="login">
		<div class="login-box" id="user-data">
			<a href="index.php" class="sign-logo">
				<img src="images/stema.png" alt="there is no image!">
				<h1>Admitere<br>România</h1>
			</a>
			<p class="sign-title">Sign Up</p>
			<?php
					if(isset($_GET['email'])){
						$email=$_GET['email'];
						require("mysql.php");
						if (isset($_POST['submit_data'])){
								$nume=$_POST['nume'];
								$prenume=$_POST['prenume'];
								$cnp=$_POST['cnp'];
								$bac=(float)$_POST['bac'];
								$liceu=(float)$_POST['liceu'];
								$query_insert_data="UPDATE users SET 
														nume='$nume',
														prenume='$prenume',
														cnp='$cnp',
														media_bac='$bac',
														media_liceu='$liceu'
														WHERE email='$email'";
								$result_insert=mysqli_query($conexiune,$query_insert_data);
								if(!$result_insert){
									echo mysqli_error($conexiune);
								}else{
									echo "<p>Datele inserate cu succes!</p>";
									echo "<p>Please proceed to :<a href='login.php'>Log In</a></p>";
								}
						}else{
							?>
							<form autocomplete='off' method='post' action='insertUserData.php?email=<?=$email?>'>
								<label>Nume:</label><br>
								<input type='text' name='nume' placeholder='Nume de familie' required><br>
								<label>Prenume:</label><br>
								<input type='text' name='prenume' placeholder='Prenume' required><br>
								<label>CNP:</label><br>
								<input type='text' name='cnp' placeholder='Cod Numeric Personal' required><br>
								<label>Media BAC:</label><br>
								<input type='text' name='bac' placeholder='8.75' required><br>
								<label>Media liceu:</label><br>
								<input type='text' name='liceu' placeholder='8.85' required><br>
								<input type='submit' name='submit_data' value='Submit'>
							</form>
							<p>Back to Sign Up form:<a href='signup.php'>Sign Up</a></p>
							<?php
						}
						mysqli_close($conexiune);
					}else {
                        echo "<p>Lipsă paramentru (nu știu ce user să modific)</p>";
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