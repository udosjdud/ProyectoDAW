<?php
session_start();

// Variables de sesión
$usuario = $_SESSION['usuario'];
$correo_usuario = $_SESSION['correo'];

if (!isset($_SESSION['logueado'])){
    header('Location: ../index.html');
}

if (isset($_POST['cerrar_sesion'])){
    if ($_POST['cerrar_sesion'] == 'true'){
        session_destroy();
        //echo '../index.html';
    }
}

?>