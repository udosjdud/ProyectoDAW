<?php
session_start();

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