<?php
include("./basededatos/config.php");
function connect_db(){
    $connect = new PDO("mysql:host=" . DB_HOST .";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
    return $connect;
}
function getRedirect(){
  $redirect =  urlencode($_SERVER["REQUEST_URI"]);

  return  "&redirect=" .  urlencode(str_replace("state=exclusive", "state=normal",$_SERVER["REQUEST_URI"]));
}
?>
