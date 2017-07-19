<?php
	include('inc/load.inc.php'); 
        $result = mysql_query("SELECT * FROM writes ORDER BY ID DESC");
        $num=mysql_num_rows($result);
        while($row = mysql_fetch_array($result))
        {
            $temp = $row['str'];
            echo "<div id='myDiv' class='myDivClass'> <img src='images.jpg' float=left  id='im'/> <f>paneshouse:</f><br/><div id='g'>$temp</div> </div>";
 
        }
 
?>