<?php
//odjava korisnika brisanjem sjednice
	session_start();
	if($_SESSION["ime"]!=null){
		session_unset(); 
		header("Location:index.php");
	}
	else header("Location:index.php");
?>