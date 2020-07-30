<?php
	session_start();
	include ("functions.php");
	if(isset($_SESSION['active'])&&($_SESSION['active']==true)&&isAdmin()){
		if(isset($_GET['id'])){
			$id=$_GET['id'];
			require("mysql.php");
			$delete_univ_query="DELETE FROM universitati WHERE id_universitate='$id'";
			mysqli_query($conexiune,$delete_univ_query);
			mysqli_close($conexiune);
			header("location: admin.php");
		}else{
			header("location: admin.php");
		}
	}else{
		header("location: login.php");
	}
?>