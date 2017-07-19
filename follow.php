<?php require_once("inc/load.inc.php");
	  require_once("inc/head.inc.php");
?>
<?php 
if($_POST['user_id']);

$user_id=$_POST['user_id'];
$user_id = mysql_real_escape_string($user_id);

$sql= mysql_query("INSERT into livingwith(tenant_id,user_id) values ('$UID','$user_id'");
while ($row=mysql_fetch_array($sql))
{
	$id=$row["user_id"];
?>
<div id="follow <?php echo $id; ?>">
<a href="#" class="follow" id="<?php echo $id; ?>">
<span class="follow_b"> Follow </span></a>
</div>
<?php
}
?>