<?php include_once("inc/load.inc.php");
	isset($_REQUEST['name'])?
	$q=$_REQUEST['name']: $q='';// just to escape undesirable characters
	$q=mysql_real_escape_string($q);
	if(empty($q)){	//this will be displayed if search value is blank
	echo"";
	} else {// this part will perform our database query
	$sql="select * from profiles where username like '%$q%' or lower(concat_ws('',Firstname, Lastname)) like '%$q%'";
	$rs=mysql_query($sql) or die ('could not connect to database:'.mysql_error());
	$num=mysql_num_rows($rs);
	if($num>=1){
		// this will display how many records found
		// and also the actual record
		echo"<div style='margin: 0 0 10px 0; font-weight:bold;'>
		<strong>$num Tenant(s) found!</strong></div>";
		while ($row=mysql_fetch_array($rs)){
			echo"<div>".$row['Firstname']." ".$row['Lastname']."</div>";}
	} else {
		// if no records found
		echo"<b>The name does not exist in our database!Try again</b>";
	}}
?>