<?php

header("Content-Type: application/json");

try {
    require_once("../conexion.php");
    session_start();
} catch (Exception $e) {
    echo json_encode(array("error" => $e->getMessage()));
}

if (isset($_POST["titulo_tabla"])) {
    $titulo_tabla = trim($_POST["titulo_tabla"]);
    $id_espacioTrabajo = $_SESSION["id_tabla"];
    
    $cprep = $conexion->prepare("INSERT INTO lista (titulo, id_espacio_trabajo) VALUES (?, ?)");
    $cprep->bind_param("si", $titulo_tabla, $id_espacioTrabajo);

    if($cprep->execute()){
        
    }

}

?>