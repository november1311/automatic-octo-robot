<?php
	require_once("libs/ph_functions.php");
	if(Post())
	{
		require_once("inc/load.inc.php");
		$user = cleanMySQL(ucwords($_POST['username']));
		$first = cleanMySQL(ucwords($_POST['firstname']));
		$last = cleanMySQL(ucwords($_POST['lastname']));
		$email = cleanMySQL(strtolower($_POST['email_reg']));
		$email2 = cleanMySQL(strtolower($_POST['email_confirm']));
		$password = sha1($_POST['password'] . "5spoonsOFsalt");
		$sex = cleanMySQL($_POST['sex']);
		$birthdate = cleanMySQL($_POST['birthday_month'] . "/" . $_POST['birthday_day'] . "/" . $_POST['birthday_year']);
		$_POST['avatar'] = stripslashes($_POST['avatar']);
		$avatar = mysql_real_escape_string($_POST['avatar']);

		// start PHP validation
		if(!isset($_SESSION)) {
			session_start();
		}
		if(strlen($user)<4 || strlen($first)<2 || strlen($last)<2 || $email!=$email2 || (strlen($sex)>1 && ($sex!=1 || $sex!=2)) || $_POST['birthday_month']==0 || $_POST['birthday_day']==0 || $_POST['birthday_year']==0) {
			$_SESSION['reg_error'] = "All fields must be filled";
			Back();
			exit();
		}
		// Search for existing username
				$dn = mysql_num_rows(mysql_query('select UID from users where username="'.$user.'"'));
				if($dn==0)
				{
					}
				else
				{
					//Otherwise, we say the username is not available
					$_SESSION['reg_error']= "That username already exists.";
					header("Location: index.php");
					exit();
				}

		// Search for existing user in our "users" table
		$find = mysql_query("SELECT Email FROM Users WHERE Email='$email'", $con) or die(mysql_error());
		if(!mysql_num_rows($find)) {
			$insert = mysql_query("INSERT INTO Users(Email, Username, Pass, avatar, signup_date) VALUES('$email', '$user', '$password', '.$avatar.', '.time()')", $con) or die(mysql_error());
			if($insert)
			{
				$find = mysql_query("SELECT UID FROM Users WHERE Email='$email'", $con) or die(mysql_error());
				$F = mysql_fetch_array($find);
				if($F)
				{
					$insert = mysql_query("INSERT INTO Profiles(UID, Username, Firstname, Lastname, Sex, Birthday) VALUES('$F[UID]', '$user', '$first', '$last', '$sex', '$birthdate')", $con) or die(mysql_error());
					$_SESSION['account_created'] = "You're account was successfully created.";
					header("Location: home.php");
					exit();
				}
			}
		}
		else
		{
			$_SESSION['reg_error'] = "That email address exists.";
			header("Location: login.php");
			exit();
		}
	}
	else
	{
		header("Location: http://www.paneshouse.com/");
		exit();
	}
?>