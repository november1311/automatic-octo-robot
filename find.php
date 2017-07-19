<?php echo $_SERVER['REQUEST_METHOD']."<br/>";
  foreach($_POST as $t=> $v){echo $t."->".$v."<br/>";} ?>