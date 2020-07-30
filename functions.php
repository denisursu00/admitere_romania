<?php
	require("mysql.php");
	function isAdmin(){
		if(isset($_POST['email'])&&($_POST['email']=="admin@mail.com")){
			return true;
		}elseif (isset($_SESSION['user'])&&($_SESSION['user']['email']=='admin@mail.com' )) {
			return true;
		}else{
			return false;
		}
	}
	function getUserByEmail($email){
		$query="SELECT * from users WHERE email='$email'";
		$result=mysqli_query($conexiune,$query);
		$user=mysqli_fetch_assoc($result);
		return $user;
	}
	function encodeFile($file){
		$tmp=addslashes($file);
		$tmp=file_get_contents($tmp);
		$tmp=base64_encode($tmp);
		return $tmp;
	}
?>