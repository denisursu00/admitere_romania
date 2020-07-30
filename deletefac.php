<?php
	session_start();
	include ("functions.php");
	if(isset($_SESSION['active'])&&($_SESSION['active']==true)&&isAdmin()){
		if(isset($_GET['id'])){
			$id=$_GET['id'];
			require("mysql.php");
			$delete_fac_query="DELETE FROM facultati WHERE id_facultate='$id'";
			mysqli_query($conexiune,$delete_fac_query);
			mysqli_close($conexiune);
			header("location: admin.php");
		}else{
			header("location: admin.php");
		}
	}else{
		header("location: login.php");
	}
?>