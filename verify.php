<!DOCTYPE html>
<html lang="ro">
<head>
	<title>Sign Up</title>
	<link rel="icon" href="images/hat_white.png">
	<link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/desktop.css">
</head>
<body id="main">
	<div class="main" id="login">
		<div class="login-box">
			<a href="index.php" class="sign-logo">
				<img src="images/stema.png" alt="there is no image!">
				<h1>Admitere<br>România</h1>
			</a>
			<p class="sign-title">Sign Up</p>
			<?php
					if(isset($_GET['email'])&&isset($_GET['hashcode'])){
						$email=$_GET['email'];
						$hash_code=$_GET['hashcode'];
						require("mysql.php");
						if (isset($_POST['submit_code'])){
							$submitted_code=$_POST['code'];
							if(password_verify($submitted_code,$hash_code)){
								$query_activate_user="UPDATE users SET activat=1 WHERE email='$email'";
								$result_activate=mysqli_query($conexiune,$query_activate_user);
								if(!$result_activate){
									echo mysqli_error($conexiune);
								}else{
									echo "<p>Activare cu succes</p>";
									echo "<p>Please insert your personal data:<a href='insertUserData.php?email=".$email."'>Data Form</a></p>";
								}
							}else{
								echo "<p>Codul nu coincide!</p>";
							}
						}else{
							?>
							<form autocomplete='off' method='post' action='verify.php?email=<?=$email?>&hashcode=<?=$hash_code?>'>
								<label>Code:</label><br>
								<input type='text' name='code' placeholder='Code from email' required><br>
								<input type='submit' name='submit_code' value='Verify'>
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