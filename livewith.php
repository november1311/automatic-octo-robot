<?php 	require_once("inc/load.inc.php"); ?>
<html>
<head>

<link href="/styles/global.css" type="text/css" rel="stylesheet" />
<script src="/libs/jquery-1.10.2.min.js" type="text/javascript"> </script>
<script src="/libs/java_lib.js" type="text/javascript"></script>
<?php require_once("/libs/ph_functions.php"); ?>


<title>
Paneshouse
</title>
</head>
<body>
<h2> </h2>
<div style="margin-bottom:40px;">

<?php
$command=mysql_query("SELECT * from users");
while($data=mysql_fetch_row($command))
{
$userid=$data[0];
?>
<div class="box">
<div class="picture"><img src="<?php echo $data[2];?>"></div>
<div class="user_data">

<div class="follow_box">
<?php

$livewith_check="select * from livewith_user WHERE uid_lk='$UID' and user_id='$UID' ";
$user_sql=mysql_query($livewith_check);
$count=mysql_num_rows($user_sql);
if($count==0)
{
echo "<div id='follow$userid'><a href='' class='follow' id='$userid'><span class='btn' style='width:70px;'><b> Follow </b></span></a></div>";
echo"<div id='remove$userid' style='display:none'><a href='#' class='remove' id='$userid'><span class='btn btn-info' style='width:70px;'><b> Livingwith </b></span></a></div>";
}
else
{
echo "<div id='follow$userid' style='display:none'><a href='' class='follow' id='$userid'><span class='btn' style='width:70px;'><b> Follow </b></span></a></div>";
echo"<div id='remove$userid'><a href='#' class='remove' id='$userid'><span class='btn btn-info' style='width:70px;'><b> Following </b></span></a></div>";
}



?>
</div>
<div><b><?php echo $data[1];?></b></div>

</div>
</div>


<?php
}

?>

</body>

</html>
