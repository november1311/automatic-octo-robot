<?php 	require_once("inc/load.inc.php");
		require_once("libs/ph_functions.php"); // might end up getting loaded twice, that's fine
		
		if(!LoggedIn()) {
			header("location: login.php");
		} else {
			$MyID = cleanMySQL($_SESSION['UID']);
		}
		
		$My = mysql_query("SELECT Firstname, Lastname, Pic FROM Profiles WHERE UID='$MyID'", $con) or die(mysql_error($con));
		$My = mysql_fetch_array($My);
		
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Paneshouse - Users</title>
</head>

<body>

<h1>List of Users</h1>
<?php
$users = show_users();
$livingwith = livingwith($_SESSION['UID']);
if (count($users)){
	?>
    <table border='1' cellspacing='0' cellpadding='5' width='500'>
    <?php
	foreach  ($users as $key => $value){
		echo "<tr valign='top'>\n";
		echo "<td>" .$key ."</td>\n";
		echo "<td>" .$value ;
		if (in_array($key,$livingwith)){
			echo " <small>
			<a href='/action.php?id=$key&do=unlivewith'>unlivewith</a></small>";
		} else {
			echo " <small>
			<a href='/action.php?id=$key&dolivewith'>livewith</a></small>";
		}
		echo "</td>\n";
		echo "</tr>\n";
	}
	?>
    </table>
    <?php
} else {
	?>
    <p><b>There are no Users</b></p>
    <?php
}
?>
</body>
</html>