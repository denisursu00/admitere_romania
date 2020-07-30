<?php
$hostname = "127.0.0.1:3306";
$username = "root";
$password = "";
$bd = "admitere_romania";
$conexiune = mysqli_connect($hostname,$username,$password) or die
	("Eroare! Unul din 3 parametri nu este corect.");
$baza = mysqli_select_db($conexiune,$bd) or die
	("Eroare! Baza de date nu exista.");
?>