<?php
include("../modelo/conexion.php");
$email = $_POST['correo'];
$obj= new conexion;
$obj->recupera($email);
$obj->cerrar();
?>
