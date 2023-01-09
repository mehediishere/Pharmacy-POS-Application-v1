<?php
	session_start();

	if(isset($_GET['logout'])){
		unset($_SESSION['store_id']);
		header("location:../login.php");
		exit();
	}
	else{
		echo "<script>window.history.back();</script>";
	exit();
	}
?>