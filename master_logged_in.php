<?php 	require_once("inc/load.inc.php");
		require_once("libs/ph_functions.php"); // might end up getting loaded twice, that's fine
		
		if(!LoggedIn()) {
			header("location: login.php");
		} else {
			$MyID = cleanMySQL($_SESSION['UID']);
		} 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Paneshouse</title>
	<?php require_once("inc/head.inc.php"); ?>
</head>

<body>
 <?php  require_once("inc/header.inc.php"); ?>
    
    <!-- This is where the body will go -->
</body>
 </html>