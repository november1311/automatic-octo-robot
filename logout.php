<?php
	if(!isset($_SESSION)) 
		session_start();
		
	unset($_SESSION['UID']);
	setcookie('myPaneshouse_UID', '', time()-3600);
	setcookie('myPanehouse__', '', time()-3600);
	session_destroy();
	header("Location: index.php");
	exit();
?>