<?Php
if($_SERVER['REQUEST_METHOD']=="POST"){
	//add our db connection& & functions for the ajax'd page
	require_once("inc/load.inc.php");
	require_once("libs/ph_functions.php");
	if(!LoggedIn()){$_SESSION['ERROR']="You are not logged in";
	}
	else{
		//we are logged in, lets do this!
		$MyID = cleanMySQL($_SESSION['UID']);
		$write = addslashes(mysql_real_escape_string(nl2br($_POST['body'],0,140)));
		// the same as cleanMySQL(); the long way
		$time = time();
		$insert = mysql_query("INSERT INTO Writes(UID, Body, Date) VALUES('$MyID','$write','$time')");
		if(!$insert)
		add_write($UID,$body);
		{$_SESSION['write'] = "Your Write has been sent|";}
		{$_SESSION["ERROR"]="There was a problem posting that.";}
	}
}
		// outside the $_SERVER['REQUEST_METHOD']if statement, because anyone who visits this page will be redirected 
		$ref = (isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"home.php");
		header("Location:".$_SERVER['HTTP_REFERER']); 

?>