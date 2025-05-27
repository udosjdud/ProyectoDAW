<?php

header('Content-Type: application/json');

try {
    require_once("../conexion.php");
    session_start();

    if (isset($_POST["titulo_lista"])) {
        $titulo_tabla = trim($_POST["titulo_lista"]);
        $id_espacioTrabajo = $_SESSION["id_espacio"];

        $cprep = $conexion->prepare("INSERT INTO lista (titulo, id_espacio_trabajo) VALUES (?, ?)");
        $cprep->bind_param("si", $titulo_tabla, $id_espacioTrabajo);

        if ($cprep->execute()) {
            echo json_encode([
                'tipo' => 'success',
                'mensaje' => 'Lista creada con éxito'
            ]);
        } else {
            echo json_encode([
                'tipo' => 'error',
                'mensaje' => 'Error al crear la lista'
            ]);
        }
    } else {
        echo json_encode([
            'tipo' => 'error',
            'mensaje' => 'No se proporcionó el título de la lista'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'tipo' => 'error',
        'mensaje' => 'Error en el servidor: ' . $e->getMessage()
    ]);
}
?>