<?php
header("Content-Type: application/json");

try {
    require_once("../conexion.php");
    session_start();

    if (isset($_POST['id_tarea'])) {

        $cprep = $conexion->prepare("DELETE FROM tareas WHERE id = ?");
        $cprep->bind_param("i", $_POST['id_tarea']);
        if ($cprep->execute()) {
            $cprep->close();
            echo json_encode([
                'tipo' => 'success',
                'mensaje' => 'Tarea eliminada correctamente'
            ]);
        }
    } else {
        echo json_encode([
            'tipo' => 'error',
            'mensaje' => 'No se ha proporcionado el ID de la tarea'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'tipo' => 'error',
        'mensaje' => 'Error al conectar con la base de datos'
    ]);
}

?>