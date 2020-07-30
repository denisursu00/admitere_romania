<?php
	session_start();
	if(isset($_SESSION['active'])&&$_SESSION['active']==true){
		session_destroy();
		header("location: index.php");
	}
?>