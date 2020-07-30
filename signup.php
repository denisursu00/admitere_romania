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
	<div class='main' id='login'>
		<div class='login-box'>
			<a href='index.php' class='sign-logo'>
				<img src='images/stema.png' alt='there is no image!'>
				<h1>Admitere<br>România</h1>
			</a>
			<p class='sign-title'>Sign up</p>
			<?php
				use PHPMailer\PHPMailer\PHPMailer;
				use PHPMailer\PHPMailer\Exception;
				require 'PHPMailer-master/src/Exception.php';
				require 'PHPMailer-master/src/PHPMailer.php';
				require 'PHPMailer-master/src/SMTP.php';
				require("mysql.php");
				$glob_email="";
				$glob_code="";
				if(isset($_POST['submit'])){
					$email=$_POST['email'];
					$glob_email=$email;
					$password=$_POST['password'];
					$re_password=$_POST['re-password'];
					if ((strlen($password)>=6)&&(strcmp($password,$re_password)==0)){
    					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      						echo "<p>Invalid email format</p>";
      						echo "<p>Back to <a href='signup.php'>Sign Up</a></p>";
						}else{
							$hash_password=password_hash($password, PASSWORD_DEFAULT);
							$query_insert_user="INSERT INTO users
												VALUES('','$email','$hash_password',CURDATE(),0,'','','',0,0);";
							$result=mysqli_query($conexiune, $query_insert_user);
							if(!$result){
								echo mysqli_error($conexiune);
							}else{
								$code=strval(rand(0,1000));
								$hash_code=password_hash($code, PASSWORD_DEFAULT);
								$mail = new PHPMailer();
								$mail->IsSMTP();
								$mail->Mailer = "smtp";
								$mail->SMTPDebug  = 0;  
								$mail->SMTPAuth   = TRUE;
								$mail->SMTPSecure = "tls";
								$mail->Port       = 587;
								$mail->Host       = "smtp.gmail.com";
								$mail->Username   = "admitere.romania@gmail.com";
								$mail->Password   = "Admitere*Romania*153";
								$mail->SetFrom("admitere.romania@gmail.com", "Admitere Romania");
								$mail->AddAddress($email, "user");
								$mail->Subject = "Activation";
								$mail->Body = '
								 
								Thanks for signing up!
								Your account has been created, you can login after you have activated your account.
								 
								------------------------
								
								------------------------
								 
								Please insert this code to activate your account:
								'.$code.'

								';
								if(!$mail->Send()){
									echo "<p>Error while sending mail</p><br>";
									echo "<p>Mailer error: </p>".$mail->ErrorInfo;
								}else{
									echo "<p>Mail sent succsessfully</p>";
									echo "<p>Verify your account: <a href='verify.php?email=".$email."&hashcode=".$hash_code."'>Verification</a></p>";
								}
							}
						}
					}elseif(strlen($password)<6){
						echo "<p>Introduceti parola mai lunga!</p>";
						echo "<p>Back to <a href='signup1.php'>Sign Up</a></p>";
					}elseif(strcmp($password,$re_password)!=0) {
						echo "<p>Parolele nu coincid!</p>";
						echo "<p>Back to <a href='signup1.php'>Sign Up</a></p>";
					}
				}else{
					?>
					<form autocomplete='off' method='post' action='signup.php'>
						<label>Email address:</label><br>
						<input type='text' name='email' placeholder='example@mail.com' required><br>
						<label>Password:</label><br>
						<input type='password' name='password' placeholder='Must be at least 6 characters' required><br>
						<label>Repeat Password:</label><br>
						<input type='password' name='re-password' placeholder='Repeat your password' required><br>
						<input type='submit' name='submit' value='Sign Up'>
					</form>
					<?php
				}
				mysqli_close($conexiune);
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