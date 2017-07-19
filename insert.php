<?php
if($_SERVER['REQUEST_METHOD']=="POST"){
	//add our db connection& & functions for the ajax'd page
	include("inc/load.inc.php");
	require_once("libs/ph_functions.php");
	if(!LoggedIn()){$_SESSION['ERROR']="You are not logged in";
	}
	else{
		//we are logged in, lets do this!
		
	include('inc/load.inc.php'); 
    $status= addslashes(mysql_real_escape_string(nl2br($_POST['status'],0,140)));
    mysql_query("INSERT INTO status (str) VALUES ('$status')");
 
    echo "<div id='myDiv' class='myDivClass'> < img src='image.jpg' float=left  id='im'/> <f>paneshouse:</f><br/><div id='g'>$status</div> </div> ";
	}
}
    echo $status;
    echo " <br/> ";
?>