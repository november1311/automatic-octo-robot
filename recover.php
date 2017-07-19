<?php 	
	require_once("inc/load.inc.php"); 
	require_once("libs/ph_functions.php");
	if(LoggedIn())
	{
		// prevents logged in users from getting to this page
		header("location: home.php");
		exit();
	}
	$error = 0;
	if(isset($_GET['enterCode']) && isset($_GET['code']) && isset($_GET['email']))
	{
		$code = cleanMySQL($_GET['code']);
		$email = cleanMySQL($_GET['email']);
		$find = mysql_query("SELECT Email FROM Users WHERE newPassCode='$code' AND Email='$email'") or die(mysql_error($con));
		if(mysql_num_rows($find))
		{
			// go to change password step
			$step = "changePass";
			$_SESSION['changePass'] = $email;
		}
		else
		{
			header("Location: recover.php?enterCode=yes");
			exit();
		}
	}
	elseif(isset($_GET['enterCode']))
	{
		$step = "enterCode";
	}
	else
	{
		$step = 1;
	}
	if(Post())
	{
		if(isset($_POST['email']))
			$email = cleanMySQL($_POST['email']);
			
		if(isset($_POST['recover_step_1']))
		{
			// step one is finished, this should produce step 2
			$find = mysql_query("SELECT UID, Email FROM Users WHERE Email='$email'") or die(mysql_error());
			if(mysql_num_rows($find))
			{
				$info = mysql_fetch_array($find);
				$UID = cleanMySQL($info['UID']); // should be clean, but always double check.
				$find = mysql_query("SELECT Firstname, Lastname FROM Profiles WHERE UID='$UID'");
				if(mysql_num_rows($find))
				{
					$step = 2;
					$profile = mysql_fetch_array($find);
					$host = explode("@", $email);
					$host = ucwords($host[1]);
				}
				else
				{
					$error = 1;
				}
			}
			else
			{
				$error = 1;
			}
		}
		elseif(isset($_POST['recover_step_2']))
		{
			// step 2 is finished, this should produce step 3
			$code = time()+60*60*24; // this gives the user 24 hours to respond.
			$step = 3;
			$email = cleanMySQL($_POST['email']);
			$host = explode("@", $email);
			$host = ucwords($host[1]);
			$to = $_POST['email'];
			$subject = "You requested a new Paneshouse password";
			$message = "<html><head><title>Welcome to Paneshouse</title></head><body>"
			."<table width='100%'>"
				."<tr>"
					."<td>Hi there,<br/ ><br /> \r\n\r\n"
					."You recently asked to reset your Paneshouse password. To complete your request, please follow this link:<br /><br />\r\n\r\n

						http://www.paneshouse.com/recover.php?code=".$code."&email=".$to."<br /><br />\r\n
						
						Alternately, you may go to https://www.paneshouse.com/recover.php?enterCode=yes and enter the following password reset code:<br /><br />\r\n
						
						".$code."<br /><br />\r\n
						
						Thanks,<br />\r\n
						The Paneshouse Team"
					."</td>"
				."</tr>"
			."</table>"
			."</body>"
			."</html>";
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Paneshouse' . "\r\n" . 
				'Reply-To: No reply <no-reply@paneshouse.com>';
			$additional_parameters = "-f user@example.net";						
			$mail = mail($to, $subject, $message, $headers, $additional_parameters);
			if($mail)
			{
				// this makes sure the email with the the new $code is sent, and 
				// the database is updated at the same time.
				$update = mysql_query("UPDATE Users SET newPassCode='$code' WHERE Email='$email'") or die(mysql_error($con));
			}
		}
		elseif(isset($_POST['step']) && $_POST['step']=="enterCode")
		{
			$email = cleanMySQL($_POST['email']);
			$code = cleanMySQL($_POST['code']);
			$find = mysql_query("SELECT Email, newPassCode FROM Users WHERE Email='$email' AND newPassCode='$code'") or die(mysql_error($con));
			if(mysql_num_rows($find))
			{
				$step = "changePass";
				$_SESSION['changePass'] = $email;
			}
			else
			{
				$error = 1;
				$step = "enterCode";
			}
		}
		elseif(isset($_SESSION['changePass']) && isset($_POST['changePass']))
		{
			$p1 = $_POST['pass1']; // first input
			$p2 = $_POST['pass2']; // second password input
			if($p1!=$p2)
			{
				$step = "changePass";
				$error = 1;
			}
			else
			{
				$pass = sha1($p1 . "5spoonsOFsalt");
				$update = mysql_query("UPDATE Users SET Pass='$pass', newPassCode=NULL WHERE Email='$_SESSION[changePass]'") or die(mysql_error($con));
				if($update)
				{
					$_SESSION['notice'] = "Your password has been changed. You can now log in with your new password";
					unset($_SESSION['changePass']);
					header("Location: login.php");
					exit();
				}
			}
		}
	}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Paneshouse</title>
	<?php require_once("inc/head.inc.php"); ?>
</head>

<body>
	<?php require_once("inc/afterbody.inc.php"); ?>
	<div id='blueTop'>
    <div id='indexBlueTopContents'>
        	<a href='index.php' title='Go to Paneshouse Home'>
            	<img src="images/index/logo.png" alt="Paneshouse Logo" id='indexLogo' />
            </a>
                <div id='indexRight'>
               	  <form method='post' action='login.php'>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td align="left" valign="middle" class='loginWords'>Email</td>
                                <td align="left" valign="middle" class='loginWords'>Password</td>
                                <td align="left" valign="middle">&nbsp;</td>
                              </tr>
                              <tr>
                                <td align="left" valign="middle"><input type='text' autocomplete="off" id='email' name='email' tabindex='1' class='loginText' /></td>
                                <td align="left" valign="middle"><input type='password' id='pass' name='pass' tabindex='2' class='loginText' /></td>
                                <td align="left" valign="middle"><input type='submit' value='Log In' tabindex="4" id='indexLogin' /></td>
                              </tr>
                              <tr>
                                <td align="left" valign="middle" id='indexPersist'><label><input type="checkbox" name='stayLogged' tabindex="3" value='1' checked='1' />Keep me logged in</label></td>
                                <td align="left" valign="middle"><a href='recover.php' class='loginLink'>Forgot your password?</a></td>
                                <td align="left" valign="middle">&nbsp;</td>
                              </tr>
                        </table>
					</form>
            </div>
    </div>
    </div>
	<div id='indexContentsW'>
    	<div id='indexGuts'>
        	<?php if($step==1) { ?>
            <form method='post' action='recover.php'>
        	<div id='recover_frame'>
            	<div id='login_title'>
                	Identify Your Account                    
                </div>
                <?php
				if($error) { ?>
                <div id='login_error'>
                	<span id='login_error_title'>We couldn't find your account</span>
                    The email you entered does not belong to any account. Make sure that it is typed correctly.
                </div>
                <?php } ?>
                <div>
                <div class='fs11'>
                	Before we can reset your password, you need to enter the information below to help identify your account:
                </div>
                       <div id='recover_form_container'>
                       
                           	<img src="images/email_icon.gif" width="32" height="32" class="fleft pad5">
                            <span class='disBlock bold'>Enter your email.</span>
                            <input type='email' name='email' placeholder="Email: you@domain.com" class='login_form_input' id='recover_form_email'<?php echo (isset($_POST['email']) ? " value='".$_POST['email']."'" : ""); ?> />
                            
                       </div>
                </div>
            </div>
        	<div id='recover_page_footer'>
            	<div align='right'>
                	<a href='recover.php?enterCode' class='lightBlue fleft pad5'>Know your reset code?</a>
               	<input type='submit' class='buttonConfirm' name='recover_step_1' id='recover_pass_confirm' value='Search' />
                    <input type='button' class='buttonCancel' id='recover_pass_cancel' value='Cancel'>
                </div>	
            </div>
            </form>
            <?php } elseif($step==2) { ?>
            <form method='post' action='recover.php'>
        	<div id='recover_frame'>
            	<div id='login_title'>
                	Reset Your Password?                   
                </div>
                <div>
                    <div class='fs11'>
                        If you're sure that this is your account, please click Reset Password. We'll send you an email to reset your password. <hr />
                      	<div class='fleft'><?php echo $profile['Firstname'] . " " . $profile['Lastname']; ?></div>
                        <div class='fright bold'><?php echo $email;?></div>
                  </div>
                </div>
            </div>
        	<div id='recover_page_footer'>
            	<div align='right'>
                	<input type='submit' class='buttonConfirm' name='recover_step_2' id='recover_pass_confirm' value='Send code to <?php echo $host;?>' />
                    <input type='button' class='buttonCancel' id='recover_pass_not_my_account' value='Not My Account'>
                    <input type='hidden' name='step' value='3' />
                    <input type='hidden' name='email' value='<?php echo $email;?>' />
                </div>	
            </div>
            </form>
            <?php } elseif($step==3) { 
				$email = cleanMySQL($_POST['email']);
			?>
        	<div id='recover_frame'>
            	<div id='login_title'>
                	Please check your email                  
                </div>
                <div>
                    <div class='fs11'>
                        An email has been sent to <font class='bold'><?php echo $email;?></font>
                        <br /><br />
                    </div>
                </div>
            </div>
        	<div id='recover_page_footer'>
            	<div align='right'>
                	<input type='button' class='buttonConfirm' name='inputCode' onClick='window.open("http://<?php echo $host; ?>/")' value='Go to <?php echo $host; ?>' />
                    <input type='button' class='buttonCancel' id='recover_pass_cancel' value='Done'>
                </div>	
            </div>
            <?php } elseif($step=="enterCode") { ?>
            <form method='post' action='recover.php'>
        	<div id='recover_frame'>
            	<div id='login_title'>
                	Enter Code
                </div>
                <div>
                    <div class='fs11'>
 				<?php if($error) { ?>
                <div id='login_error'>
                	<span id='login_error_title'>Code invalid</span>
                    Either the email you gave us was incorrect, or the code was incorrect.
                </div>
                <?php } ?>
                	Enter the code that was emailed to you, along with your email address                
                    <br /><br />
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class='bold grey textRight width150 pad5'>Email</td>
                        <td><input type='email' class='login_form_input' name='email' placeholder='Your Email' /></td>
                      </tr>
                      <tr>
                        <td class='bold grey textRight width150 pad5'>Code</td>
                        <td><input type='text' class='login_form_input' name='code' placeholder='Code' /></td>
                      </tr>
                    </table>
                    </div>
                </div>
            </div>
        	<div id='recover_page_footer'>
            	<div align='right'>
                	<input type='submit' class='buttonConfirm' name='enterCode' value='Enter Code' />
                    <input type='button' class='buttonCancel' id='recover_pass_cancel' value='Cancel'>
                    <input type='hidden' name='step' value='enterCode' />
                </div>	
            </div>
            </form>
            <?php } elseif($step=="changePass" && isset($_SESSION['changePass'])) { ?>
            <form method='post' action='recover.php'>
        	<div id='recover_frame'>
            	<div id='login_title'>
                	Change your password
                </div>
                <div>
                    <div class='fs11'>
 				<?php if($error) { ?>
                <div id='login_error'>
                	<span id='login_error_title'>Passwords do not match</span>
                    Please make sure that both password fields are typed correctly.
                </div>
                <?php } ?>
               	Change your password for <strong><?php echo $_SESSION['changePass']; ?></strong>             
                    <br /><br />
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class='bold grey textRight width150 pad5'>Password</td>
                        <td><input type='password' class='login_form_input' name='pass1' placeholder='Password' /></td>
                      </tr>
                      <tr>
                        <td class='bold grey textRight width150 pad5'>Re-enter Password</td>
                        <td><input type='password' class='login_form_input' name='pass2' placeholder='Re-enter Password' /></td>
                      </tr>
                    </table>
                    </div>
                </div>
            </div>
        	<div id='recover_page_footer'>
            	<div align='right'>
                	<input type='submit' class='buttonConfirm' name='changePass' value='Enter Code' />
                    <input type='button' class='buttonCancel' id='recover_pass_cancel' value='Cancel'>
                    <input type='hidden' name='step' value='changePass' />
                </div>	
            </div>
            </form>
            <?php } else { ?>
            	<script>window.location='./recover.php';</script>
            <?php } ?>
        </div>
    </div>
	<?php require_once("inc/footer.inc.php"); ?>
</body>
</html>