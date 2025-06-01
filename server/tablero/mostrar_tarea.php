<?php
header('Content-Type: application/json');

try {
    require_once('../conexion.php');
    session_start();

    $id_lista = $_POST['id_lista'];

    $cprep = $conexion->prepare("SELECT * FROM tareas WHERE id_lista = ?  ORDER BY posicion ASC");
    $cprep->bind_param("i", $id_lista);
    $cprep->execute();
    $result = $cprep->get_result();

    if ($result->num_rows != 0) {
        echo json_encode([
            'tipo' => 'success',
            'data' => $result->fetch_all(MYSQLI_ASSOC)
        ]);
        exit();
    }

    echo json_encode([
        'tipo' => 'success',
        'data' => [] // lista vacía de tareas
    ]);
    exit();

} catch (Exception $e) {
    echo json_encode([
        'tipo' => 'error',
        'mensaje' => $e->getMessage()
    ]);
    exit();
}

?>