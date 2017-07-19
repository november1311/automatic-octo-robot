<?php 	
	require_once("inc/load.inc.php"); 
	require_once("libs/ph_functions.php");
	if(LoggedIn())
	{
		header("location: home.php");
		exit();
	}
	$error = 0;	
	if(Post())
	{
		if(isset($_POST['pass']))
		{
			$pass = $_POST['pass']; // from login.php; can be used for user tracking.
		}
		elseif(isset($_POST['password']))
		{
			$pass = $_POST['password']; // from index.php
		}
		$cookie = 0;
		if(isset($_POST['stayLogged']))
		{
			$cookie = 1;
		}
		$password = sha1($pass . "5spoonsOFsalt"); // this is the salt we used when a user registers. 
		$email = cleanMySQL($_POST['email']);
		$find = mysql_query("SELECT UID, Email, Pass FROM Users WHERE Email='$email' AND Pass='$password'", $con) or die(mysql_error());
		if(mysql_num_rows($find))
		{
			$info = mysql_fetch_array($find);
			$_SESSION['UID'] = $info['UID'];
			if($cookie)
			{
				setcookie("myPaneshouse_UID", $info['UID'], time()+60*60*31);
				setcookie("myPaneshouse__", $info['Pass'], time()+60*60*31);
			}
			header("location: home.php");
			exit();
		}
		else
		{
			$error = 1; 
		}
	}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Log In | Paneshouse</title>
<?php require_once("inc/head.inc.php"); ?>
</head>

<body>
<?php require_once("inc/afterbody.inc.php"); ?>
<div id='blueTop'>
<div id='indexBlueTopContents'>
  <a href='./' title='Go to Paneshouse Home'><img src="images/index/logo.png" alt="Paneshouse Logo" id='indexLogo' />
  </a>
  </div>
</div>
<div id='indexContentsW'>
<div id='indexGuts'>
        	<div id='login_frame'>
            	<div id='login_title'>
                	Paneshouse Login
                </div>
                <?php
				if($error) { ?>
                <div id='login_error'>
                	<span id='login_error_title'>Please re-enter your password</span>
                    The password you entered is incorrect. Please try again (make sure your caps lock is off).<br />
                    Forgot your password? <a href='recover.php' class='redLink'>Request a new one.</a>
                </div>
                <?php } ?>
                <div>
                	<form method='post' action='login.php'>
                        <div id='login_form_container'>
                        	<div class='dInlineB' align="left">
                            	<label class='login_form_label' for='email'>Email:</label>
                                <input type='email' name='email' id='email' tabindex="1" class='login_form_input'<?php echo (isset($_POST['email']) ? " value='".$_POST['email']."'" : "");?> />
                            </div>
                        	<div class='dInlineB' align="left">
                            	<label class='login_form_label' for='password'>Password:</label>
                                <input type='password' name='password' id='password' tabindex="2" class='login_form_input' />
                            </div>
                         	<div align="left">
                            	<div class='login_form_spacer'>&nbsp;</div>
                                <div class='dInline fs11'>
                                	<label for='login_form_stay'>
                                    	<input type='checkbox' name='stayLogged' tabindex="3" checked='checked' value='1' id='login_form_stay' />
                                        Keep me logged in
                                    </label>
                                </div>
                            </div>
                            <div class='mt4'>
                            	<div class='login_form_spacer'>&nbsp;</div>
                            	<input type='submit' name='login' tabindex="4" value='Log In' id='login_button' />
                                <span class='fs11'> or <a href='./' class='boldBlue'>Sign up for Paneshouse</a></span>
                            </div>
                            <div class='mt4'>
                            	<div class='login_form_spacer'>&nbsp;</div>
                                <a href='recover.php' class='fs11 lightBlue'>Forgot your password?</a>
                            </div>
                       </div>
                    </form>
                </div>
            </div>
        	<div id='login_page_footer'>
            	<?php // you can add a footer in here through this page, or from a required/included php file; ?>
            </div>
  </div>
</div>
<?php require_once("inc/footer.inc.php"); ?>
</body>
</html>