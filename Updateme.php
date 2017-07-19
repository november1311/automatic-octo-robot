<?php 	require_once("inc/load.inc.php");
		require_once("libs/ph_functions.php"); ?>

<html>
<head>
<?php require_once('inc/head.inc.php'); ?>
<title>Update Showroom</title>
</head>
<body>
<style type="text/css">
	td,th {
	color: #030;
}
body { background:fixed #FFF 
}

    </style>
<?php 
			require_once("inc/header.inc.php"); ?>
<div id='lContainer'>
        <div id='leftCol'>
        	<?php include("inc/homeleftCol.inc.php"); ?>
                 <div id='loggedInFooter'>
            	<?php include("inc/loggedInFooter.inc.php"); ?>
            </div>
        </div>            
<div align="left" id="main">
<div id='centerCol'> 
<div id="content">

<div id='navNameNPic'>
                <a href='profile.php?id=<?php echo $MyID; ?>'>
                    <img src='<?php echo $My['Pic']; ?>' id='navPic' width='40' height='40'/>
                </a>
<a href='profile.php?id=<?php echo $MyID; ?>'  class='profileLink'><?php echo $My['Firstname'] . " " . $My['Lastname']; ?></a>
<p></p>
<br>        
<span class='navTitle'>Update Showroom:</span>
<p></p>
<div>
<form name="update" method="post" action="update.php">

    <label>First name:</label>
      <input name="firstname" type="text" id="firstname" size="40">
      <br>
      <br>
      <label>Last name:</label>
      <input name="lastname" type="text" id="lastname" size="40">
      <br>
      <br>
      <label>Email:</label>
      <input name="email" type="text" id="email" size="40">
      <br>
      <br>
      <label>Username:</label>
      <input name="username" type="text" id="username" size="40">
      <br>
      <br>
      <label>Location:</label>
      <input name="location" type="text" id="location" size="40">
      <br>
      <br>
      <label>Bio:</label>
      <textarea style="width:52%" name="bio" id="bio" cols="25" rows="3"></textarea>
    
  <p align="center">
    <input type="submit" name="update" id="update" value="Update">
  </p>
</form>
				</div>
			</div>
 	   </div>
    </div>
 </div>
</div>
</body>
</html>