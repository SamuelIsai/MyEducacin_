<?php

$servername = "localhost";
$nameuser = "root";
$contrasenia = "";
$BDname = "myeducacin";

$mysqli = new mysqli($servername, $nameuser, $contrasenia, $BDname);
$mysqli->set_charset("utf8");

?>