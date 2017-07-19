<?php	include('inc/load.inc.php');       
//We check if the user is logged
if(isset($_SESSION['UID']))
{
	//We check if the form has been sent
	if(isset($_POST['username'], $_POST['password'], $_POST['passverif'], $_POST['email'], $_POST['avatar']))
	{
		//We remove slashes depending on the configuration
		if(get_magic_quotes_gpc())
		{
			$_POST['username'] = stripslashes($_POST['username']);
			$_POST['password'] = stripslashes($_POST['password']);
			$_POST['passverif'] = stripslashes($_POST['passverif']);
			$_POST['email'] = stripslashes($_POST['email']);
			$_POST['avatar'] = stripslashes($_POST['avatar']);
		}
		//We check if the two passwords are identical
		if($_POST['password']==$_POST['passverif'])
		{
			//We check if the password has 6 or more characters
			if(strlen($_POST['password'])>=6)
			{
				//We check if the email form is valid
				if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email']))
				{
					//We protect the variables
					$username = mysql_real_escape_string($_POST['username']);
					$password = mysql_real_escape_string($_POST['password']);
					$email = mysql_real_escape_string($_POST['email']);
					$avatar = mysql_real_escape_string($_POST['avatar']);
					//We check if there is no other user using the same username
					$dn = mysql_fetch_array(mysql_query('select count(*) as nb from users where Username="'.$username.'"'));
					//We check if the username changed and if it is available
					if($dn['nb']==0 or $_POST['username']==$_SESSION['username'])
					{
						//We edit the user informations
						if(mysql_query('update users set Username="'.$username.'", Pass="'.$password.'", Email="'.$email.'", avatar="'.$avatar.'" where id="'.mysql_real_escape_string($_SESSION['UID']).'"'))
						{
							//We dont display the form
							$form = false;
							//We delete the old sessions so the user need to log again
							unset($_SESSION['Username'], $_SESSION['UID']);
?>
<div class="message">Your informations have successfuly been updated. You need to login again.<br />
<a href="login.php">Log In</a></div>
<?php
						}
						else
						{
							//Otherwise, we say that an error occured
							$form = true;
							$message = 'An error occurred while updating your informations.';
						}
					}
					else
					{
						//Otherwise, we say the username is not available
						$form = true;
						$message = 'The username you want to use is not available, please choose another one.';
					}
				}
				else
				{
					//Otherwise, we say the email is not valid
					$form = true;
					$message = 'The email you entered is not valid.';
				}
			}
			else
			{
				//Otherwise, we say the password is too short
				$form = true;
				$message = 'Your password must contain at least 6 characters.';
			}
		}
		else
		{
			//Otherwise, we say the passwords are not identical
			$form = true;
			$message = 'The passwords you entered are not identical.';
		}
	}
	else
	{
		$form = true;
	}
	if($form)
	{
		//We display a message if necessary
		if(isset($message))
		{
			echo '<strong>'.$message.'</strong>';
		}
		//If the form has already been sent, we display the same values
		if(isset($_POST['username'],$_POST['password'],$_POST['email']))
		{
			$pseudo = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
			if($_POST['password']==$_POST['passverif'])
			{
				$password = htmlentities($_POST['password'], ENT_QUOTES, 'UTF-8');
			}
			else
			{
				$password = '';
			}
			$email = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');
			$avatar = htmlentities($_POST['avatar'], ENT_QUOTES, 'UTF-8');
		}
		else
		{
			//otherwise, we display the values of the database
			$dnn = mysql_fetch_array(mysql_query('select Username,Pass,Email,avatar from users where UID="'.$_SESSION['UID'].'"'));
			$username = htmlentities($dnn['Username'], ENT_QUOTES, 'UTF-8');
			$password = htmlentities($dnn['Pass'], ENT_QUOTES, 'UTF-8');
			$email = htmlentities($dnn['Email'], ENT_QUOTES, 'UTF-8');
			$avatar = htmlentities($dnn['avatar'], ENT_QUOTES, 'UTF-8');
		}
		//We display the form
?>
<?php
	}
}
else
{
?>
<div class="message">To access this page, you must be logged.<br />
<a href="login.php">Log In</a></div>
<?php
}

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Edit Showroom - Paneshouse</title>
    	<?php require_once("inc/head.inc.php"); ?>
    </head>
    <body>
<style type="text/css">

    body { background:fixed #FFF }
</style>
     <?php  require_once("inc/header.inc.php");?>
<div id='lContainer'>
        <div id='leftCol'>
        	<?php include("inc/leftCol.inc.php"); ?>
                 <div id='loggedInFooter'>
            	<?php include("inc/loggedInFooter.inc.php"); ?>
                
            </div>
        </div>
        <div align="left" id="main">
                <div id='centerCol'>
                <div id="content"> 
<div class="content">
    <form method="post" action="edit_infos.php">
        <div class="center">
        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="4">
                <tr>You can edit and/or update your Showroom:</tr>
            <tr>
            <td class='indexLabel'><label for="username">Username:</label></td>
            <td><input type="text" name="username" id="username" value="<?php echo $username; ?>" /></td>
            </tr><br />
            <tr>
            <td class='indexLabel'><label for="password">Password:<span class="small"><br>
              (6 characters min.)</span></label></td>
            <td><input type="password" name="password" id="password" value="<?php echo $password; ?>" /></td>
            </tr><br />
            <tr>
            <td class='indexLabel'><label for="passverif">Password:<span class="small">(verification)</span></label></td>
            <td><input type="password" name="passverif" id="passverif" value="<?php echo $password; ?>" /></td>
            </tr><br />
            <tr>
            <td class='indexLabel'><label for="email">Email:</label></td>
            <td><input type="text" name="email" id="email" value="<?php echo $email; ?>" /></td>
            </tr><br />
            <tr>
            <td class='indexLabel'><label for="avatar">Avatar:<span class="small">(optional)</span></label></td>
            <td><input type="text" name="avatar" id="avatar" value="<?php echo $avatar; ?>" /></td>
            </tr><br />
            <tr>
			<td>&nbsp;</td>
            <td><input type="submit" value="Send" /></td>
            </tr>
            </table>
        </div>
    </form>
					</div>
        		</div>
    	    </div>
        </div>
    </div>

	</body>
</html>