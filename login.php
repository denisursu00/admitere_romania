<?php
	session_start();
	$_SESSION['active']=false;
?>
<!DOCTYPE html>
<html lang="ro">
<head>
	<meta charset="utf-8">
	<title>Log In</title>
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
			<p class="sign-title">Sign in</p>
			<?php
				require("mysql.php");
				include('functions.php');
				if(isset($_POST['submit'])){
					$email=$_POST['email'];
					$password=$_POST['password'];
					$query_verify_user="SELECT * FROM users WHERE email='$email'";
					$rezultat=mysqli_query($conexiune, $query_verify_user);
					$row=mysqli_fetch_assoc($rezultat);
					if((mysqli_num_rows($rezultat)==1)&&(password_verify($password, $row["password"]))){
						if($row["activat"]==1){
							$_SESSION['active']=true;
							$_SESSION['user']=$row;
							if(isAdmin()){
								header("location: admin.php");
							}else{
								header("location: user.php");
							}
						}else{
							echo "<p class='error-text'>Userul nu este activat!</p>";
						}
					}else{
						echo "<p class='error-text'>Parola sau email-ul nu sunt valide!</p>";
					}
				}
			?>
			<form autocomplete="off" method="post">
				<label>Email address:</label><br>
				<input type="text" name="email" placeholder="example@mail.com"><br>
				<label>Password:</label><br>
				<input type="password" name="password" placeholder="Must be at least 6 characters"><br>
				<input type="submit" name="submit" value="Sign In">
			</form>
			<p>Don't have an account? <a href="signup.php">Sign Up</a></p>
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