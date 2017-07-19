<?php 	require_once("/inc/load.inc.php");
		require_once("/libs/ph_functions.php"); // might end up getting loaded twice, that's fine
		
		if(!LoggedIn()) {
			header("location: login.php");
		} else {
			$MyID = cleanMySQL($_SESSION['UID']);
		}
		
		$My = mysql_query("SELECT Firstname, Lastname, Pic FROM Profiles WHERE UID='$MyID'", $con) or die(mysql_error($con));
		$My = mysql_fetch_array($My);
	
	
	$id = $_GET['id'];
	$do = $_GET['do'];
	
	switch ($do){
		case "livewith":
					follow_user($_SESSION['UID'], $id);
					$msg = "You Livingwith";
			break;
			
			case "unlivewith":
					unlivewith_user($_SESSION['UID'],$id);
					$msg = "You have unLivedwith";
			break;
	}
	$_SESSION['message'] = $msg;
	header("Location:".$_SERVER['HTTP_REFERER']);	
	header("Location:home.php");
?>