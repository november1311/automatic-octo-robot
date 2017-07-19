<?php require_once('inc/load.inc.php');
		require_once("libs/ph_functions.php"); // might end up getting loaded twice, that's fine
		
		if(!LoggedIn()) {
			header("location: login.php");
		} else {
			$MyID = cleanMySQL($_SESSION['UID']);
		}
$first=cleanMySQL(ucwords($_POST['firstname']));
$last=cleanMySQL(ucwords($_POST['lastname']));
$email=$_POST['email'];
$user=cleanMySQL(ucwords($_POST['username']));
$city=cleanMySQL(ucwords($_POST['city']));
$location=cleanMySQL(ucwords($_POST['location']));
$bio=cleanMySQL(ucwords($_POST['bio']));
// check the login details of the user and stop execution if not logged in

{ // set the flags for validation and messages
$status = "OK";
$msg = "";
// if name is les than 2 char then status is not OK
if (strlen($first)<2 || strlen($last)<2 || strlen($user)<4 || strlen($city)<0 || strlen($location)<0 || strlen($bio)<0) { 
$msg=$msg."Your name must be more than 2 character length<BR>";
$status="NOTOK";
}
if($status<>"OK"){ // if validation failed 
echo "<font face='Verdana' size='2' color=red>$msg</font><br><input type='button' value='Retry' onClick='history.go(-1)'>";
} else { // if all validations are passed
/////////////////////////////
/////////////////////////////
$pdo=$con->prepare("UPDATE Profiles SET first=:firstname, last=:lastname, email=:email WHERE UID='$_SESSION[UID]'");
$pdo->bindParam(':firstname',$first,PDO::PARAM_STR, 25);
$pdo->bindParam(':lastname',$last,PDO::PARAM_STR, 30);
$pdo->bindParam(':email',$email,PDO::PARAM_STR, 15);
$pdo->bindParam(':username',$user,PDO::PARAM_STR, 30);
$pdo->bindParam(':city',$city,PDO::PARAM_STR, 30);
$pdo->bindParam(':location',$location,PDO::PARAM_STR, 30);
if($pdo->execute()){
	echo "<font face='Verdana' size='2' color=green>Your profile was updated successfullly<br></font>";
} // End of if profile is ok
else {
	print_r($pdo->errorInfo()); // if any error is there it will be posted
	$msg=" <font face='Verdana' size='2' colorred>There was an error in updating your profile<br></font>";
} // end of if else if database updation failed
} // end of if else for status<>ok
echo $msg;
} // end of todo to check form inputs
		$ref = (isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"home.php");
		header("Location:".$_SERVER['HTTP_REFERER']); 

?>
