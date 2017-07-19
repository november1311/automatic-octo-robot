<?php require_once("inc/load.inc.php");
	  require_once("inc/head.inc.php");
?>
<?php
if($_POST['user_id']);

$user_id=$_POST['user_id'];
$user_id = mysql_real_escape_string($user_id);
 
$sql= mysql_query("DELETE from livingwith Where tenant_id='$UID' and user_id='$user_id'");
while ($row=mysql_fetch_array($sql))
{
	$id=$row["user_id"];
	?>
<div id="remove <?php echo $id; ?>" style="display:none"> You Following
<a href="#" class="remove" id="<?php echo $id; ?>">
<span class="remove_b"> remove </span></a>
</div>
<?php
}
?>