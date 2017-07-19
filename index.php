<?php 
	require_once("inc/load.inc.php"); 
	require_once("libs/ph_functions.php");
	if(LoggedIn()) {
		header("Location: home.php");
		exit();
	} else {
		// check for cookies
		if(isset($_COOKIE['myPaneshouse_UID']) && isset($_COOKIE['myPaneshouse__'])) {
			// clean and check for existing user
			$UID = cleanMySQL($_COOKIE['myPaneshouse_UID']);
			$Pass = cleanMySQL($_COOKIE['myPaneshouse__']);
			$find = mysql_query("SELECT UID FROM Users WHERE UID='$UID' AND Pass='$Pass'") or die(mysql_error($con));
			if(mysql_num_rows($find)) {
				$_SESSION['UID'] = $_COOKIE['myPaneshouse_UID'];
				header("Location: home.php");
				exit();
			} else {
				// unset both cookies - they can be recreated when the user logs in again
				setcookie('myPaneshouse_UID', '', time()-3600);
				setcookie('myPaneshouse__', '', time()-3600);
			}
		}
	}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Welcome to Paneshouse - Log In, Sign Up or Learn More</title>
<?php require_once("inc/head.inc.php"); ?>
<link href="styles/global.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">

td,th {
	color: #360;
	border-top-style: solid;
	border-right-style: none;
	width: 120%;
	height: 48px;
	border-top-color: #D6D6D6;
	border-right-color: #D6D6D6;
	border-bottom-color: #D6D6D6;
	border-left-color: #D6D6D6;
	font-family: Verdana, Geneva, sans-serif,;
	font-weight: normal;
	font-variant: normal;
	font-style: normal;
	font-size: 14px;
}
a:link {
	color: #360;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #360;
}
a:hover {
	text-decoration: underline;
	color: #360;
}
a:active {
	text-decoration: none;
	color: #360;
}
</style>
<link href="images/Icon.ico" id="Paneshouse" title="Home">
</head>

<body bgcolor="#030" text="#006600" link="#360" vlink="#360" alink="#360">
<?php require_once("inc/afterbody.inc.php"); ?>
<div id='blueTop'>
<div id='indexBlueTopContents'>
  <div id='indexRight'>
    <form action='login.php' method='post' id="loginform">
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" id="logintable">
<tr>
<td align="left" valign="middle" class='loginWords'>Email:</td>
<td align="left" valign="middle" class='loginWords'>Password:</td>
<td align="left" valign="middle">&nbsp;</td>
</tr>
<tr>
<td height="40" align="left" valign="middle"><input type='text' autocomplete="off" id='email' name='email' tabindex='1' class='loginText' /></td>
<td align="left" valign="middle"><input type='password' id='pass' name='pass' tabindex='2' class='loginText' /></td>
<td align="left" valign="middle"><input type='submit' value='Log In' tabindex="4" id='indexLogin' /></td>
</tr>
<tr>
<td align="left" valign='middle' id='indexPersist'><label><input type="checkbox" name='stayLogged' tabindex='3' value='1' checked='1' />
Keep me logged in</label></td>
<td align="left" valign="middle"><a href='recover.php' class='loginLink'>Forgot your password?</a></td>
<td align="left" valign="middle">&nbsp;</td>
</tr>
</table>
</form>
</div>
  <a href='./' title='Go to Paneshouse Home'><img src="images/index/logo.png" alt="Paneshouse Logo" width="458" height="40" id='indexLogo' /></a>
  </div>
</div></br>
<div id='indexGuts'>
  <p>&nbsp;  </p>
  <p>&nbsp; </p>
  <div>
    <div id='indexRightArea'>
      <div class='indexBold' id='signUpText'>
Sign up
<div class='noBold fs16'>It's free and easy to use.</div>
</div>
<div id='regForm'>
<form action='register.php' method='post' name='reg' id='reg'>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="4" id="regForm">
<tr>
<td class='indexLabel'>Username:</td>
<td><input type='text' class='indexReg' id='username' name='username' /></td>
</tr>
<tr>
<td class='indexLabel'>First Name:</td>
<td><input type='text' class='indexReg' id='firstname' name='firstname' /></td>
</tr>
<tr>
<td class='indexLabel'>Last Name:</td>
<td><input type='text' class='indexReg' id='lastname' name='lastname' /></td>
</tr>
<tr>
<td class='indexLabel'>Your Email:</td>
<td><input type='email' class='indexReg' id='email_reg' name='email_reg' /></td>
</tr>
<tr>
<td class='indexLabel'>Re-enter Email:</td>
<td><input type='text' class='indexReg' id='email_confirm' name='email_confirm' /></td>
</tr>
<tr>
<td class='indexLabel'>New Password:</td>
<td><input name='password' type='password' class='indexReg' id='password' /></td>
</tr>
<tr>
<td height="75" class='indexLabel'>I Am:</td>
<td>
<select name='sex' class='indexSelect' id='sex'>
<option selected="selected" value='0'>Select Sex:</option>
<option value='1'>Female</option>
<option value='2'>Male</option>
</select>
</td>
</tr>
<tr>
<td class='indexLabel'>Birthday:</td>
<td>
  <pre>     <select name='birthday_month' id='birthday_month' class='indexSelect'>        <option selected="selected" value='0'>Month:</option> <?php
for($i=1; $i<=12; $i++)
{
echo "<option value='$i'>".date("M", mktime(0, 0, 0, $i))."</option>\n";
}
?> </select> <select name='birthday_day' id='birthday_day' class='indexSelect'>   <option selected="selected" value='0'>Day:</option>   <?php
for($i=1; $i<=31; $i++)
{
echo "<option value='$i'>$i</option>\n";
}
?> </select> <select name='birthday_year' id='birthday_year' class='indexSelect'>   <option selected="selected" value='0'>Year:</option>   <?php
for($i=date("Y"); $i>=date("Y")-100; $i--)
{
echo "<option value='$i'>$i</option>\n";
}
?> </select>      
<a href='javascript: void(0);' class='smallLinkA' id='why_provide_birthday'>Why provide my date of birth?</a> </pre></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type='button' id='signup' value='Sign Up' /></td>
</tr>
</table>
</form>
</div>
<div id='reg_error'>
</div>
    <div class='indexBold w450'>Find out whats happening in Organisations, Connect and Livewith other Tenants on Paneshouse.
    </div>
 <?php require_once("inc/footer.inc.php"); ?>
  
</body>

</html>