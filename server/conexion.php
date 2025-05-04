<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$bbdd = "proyecto_daw";

$conexion = mysqli_connect($servidor, $usuario, $password, $bbdd);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

mysqli_query($conexion, "SET NAMES 'UTF8'");
?>