<?php require_once('inc/load.inc.php');
		require_once("libs/ph_functions.php"); // might end up getting loaded twice, that's fine
		
		if(!LoggedIn()) {
			header("location: login.php");
		} else {
			$MyID = cleanMySQL($_SESSION['UID']);
		}
?>
<?php ('Connections/Ph.php'); 
?>
<?php require_once('Connections/Ph.php'); 
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "update")) {
  $updateSQL = sprintf("UPDATE profiles SET Lastname=%s, City=%s, Location=%s, Housename=%s, Bio=%s WHERE Firstname=%s",
                       GetSQLValueString($_POST['lastname'], "double"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['housename'], "text"),
                       GetSQLValueString($_POST['bio'], "text"),
                       GetSQLValueString($_POST['firstname'], "double"));

  mysql_select_db($database_Ph, $Ph);
  $Result1 = mysql_query($updateSQL, $Ph) or die(mysql_error());

  $updateGoTo = "profile.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "update")) {
  $insertSQL = sprintf("INSERT INTO profiles (Firstname, Lastname, City, Location, Housename, Bio) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['firstname'], "double"),
                       GetSQLValueString($_POST['lastname'], "double"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['housename'], "text"),
                       GetSQLValueString($_POST['bio'], "text"));

  mysql_select_db($database_Ph, $Ph);
  $Result1 = mysql_query($insertSQL, $Ph) or die(mysql_error());

  $insertGoTo = "profile.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<html>
<head>
<?php require_once("inc/head.inc.php"); ?>
<link href="styles/global.css" rel="stylesheet" type="text/css">
<title>Update Showroom</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php 
			require_once("inc/header.inc.php"); ?>
<form name="update" method="post" action="<?php echo $editFormAction; ?><?php echo $editFormAction; ?>">
  <span id="spryfirstname">
  <label>First Name:
    <input type="text" name="firstname" id="firstname">
    <br>
  <span class="textfieldRequiredMsg">A value is required.</span></label>
</span>
  <p>&nbsp;</p>
  <p><span id="sprylastname">
    <label>Last Name:
      <input type="text" name="lastname" id="lastname">
      <span class="textfieldRequiredMsg">A value is required.</span></label>
</span></p>
  <p>&nbsp;</p>
  <p>
    <label>City:
      <input type="text" name="city" id="city">
    </label>
  </p>
  <p>&nbsp;</p>
  <p>
    <label>Location:
      <input type="text" name="location" id="location">
    </label>
  </p>
  <p>&nbsp;</p>
  <p>
    <label>House name:
      <input type="text" name="housename" id="housename">
    </label>
  </p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>
    <label>Bio:
      <textarea name="bio" id="bio" cols="45" rows="4"></textarea>
    </label>
  </p>
  <p align="center">
    <input type="submit" name="submit" id="submit" value="Submit">
  </p>
  <input type="hidden" name="MM_update" value="update">
  <input type="hidden" name="MM_insert" value="update">
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("spryfirstname", "none");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprylastname", "none", {validateOn:["change"]});
</script>
</body>
</html>