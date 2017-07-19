<?php require_once('inc/load.inc.php');
		require_once("libs/ph_functions.php"); // might end up getting loaded twice, that's fine
		
		if(!LoggedIn()) {
			header("location: login.php");
		} else {
			$MyID = cleanMySQL($_SESSION['UID']);
		}
?>

<?php
// *** Logout the current user.

?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UID, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UID)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 

    if (in_array($UID, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
  
     
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['UID'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo);
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_ProfileRecordset = "-1";
if (isset($_SESSION['UID'])) {
  $colname_ProfileRecordset = $_SESSION['UID'];
}
$query_ProfileRecordset = sprintf("SELECT * FROM profiles WHERE `UID` = %s", GetSQLValueString($colname_ProfileRecordset, "int"));
$ProfileRecordset = mysql_query($query_ProfileRecordset) or die(mysql_error());
$row_ProfileRecordset = mysql_fetch_assoc($ProfileRecordset);
$totalRows_ProfileRecordset = mysql_num_rows($ProfileRecordset);
?>
<html>
<head>
<title>My Showroom</title>
<?php require_once("inc/head.inc.php"); ?>
<link href="styles/global.css" rel="stylesheet" type="text/css">
</head>

<body text="#006600" link="#360" vlink="#360" alink="#360" >
<?php 
			require_once("inc/header.inc.php"); ?>
    <div id='lContainer'>
        <div id='leftCol'>
        	<?php include("inc/leftCol.inc.php"); ?>
                 <div id='loggedInFooter'>
            	<?php include("inc/loggedInFooter.inc.php"); ?>
                
            </div>
        </div>
        <div id='centerCol'> 
        <div id="content">
<p>&nbsp;</p>
<p>&nbsp;</p>

	
    
    
    	



   
		</div></div>
	</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($ProfileRecordset);
?>
