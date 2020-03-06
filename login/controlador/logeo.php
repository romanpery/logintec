<?php
include("../modelo/conexion.php");

$user = $_POST['user'];
$pass = $_POST['password'];

$obj = new conexion;
$obj->logeo($user, $pass);
$obj->cerrar();
?>
