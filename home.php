<?php 	require_once("inc/load.inc.php");
		require_once("libs/ph_functions.php"); // might end up getting loaded twice, that's fine
		
		if(!LoggedIn()) {
			header("location: login.php");
		} else {
			$MyID = cleanMySQL($_SESSION['UID']);
		}
	{	
		$My = mysql_query("SELECT Firstname, Lastname, Username, Pic FROM Profiles WHERE UID='$MyID'", $con) or die(mysql_error($con));
		$My = mysql_fetch_array($My);
	}
	$pic = mysql_query("SELECT Firstname, Lastname, Username, Sex, Pic FROM Profiles WHERE UID='$MyID'") or die(mysql_error($con));
	if($pic) {
		$fetch = mysql_fetch_array($pic);
		if(!empty($fetch['Pic'])) {
			$My['Pic'] = "images/uploads/".$fetch['Pic'];
		} else {
			if($fetch['Sex']==1) {
				$sex = "female";
			} else { 
				$sex = "male";
			}
			$My['Pic'] = "images/profiles/".$sex."_small.gif";
			unset($sex);
		}
		$My['Name'] = $fetch['Firstname'] . " " . $fetch['Lastname'] . " " . $fetch['Username'];
	} else {
		$My['Pic'] = NULL; // makes sure this variable is set (isset())
		$My['Name'] = NULL;
	}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Paneshouse</title>
	
	<?php require_once("inc/head.inc.php"); ?>
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

<?php include("inc/feedHome.inc.php"); ?>

		<br clear="all" /><br clear="all" />
			
			</div>

		</div>        
	</div>
</div>

<div style="float:left;" id="content2">
		
		<div class="header-div" align="right"> <span> Close X </span> </div>
		
		<div id="placer">
		
		</div>
	
</div>


</div>
        </div>
    </div>

            
    </body>
   </html>