<?php
include("../modelo/conexion.php");
$usuario = $_POST['usuario'];
$email = $_POST['email'];
$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];

$obj = new conexion;
$obj->registro($usuario,$email,$pass1,$pass2);
$obj->cerrar();
?>
