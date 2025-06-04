<?php
header('Content-Type: application/json');

try {
    require_once('../conexion.php');
    session_start();

    $id_espacio = $_SESSION['id_espacio'];

    $cprep = $conexion->prepare("SELECT * FROM lista WHERE id_espacio_trabajo = ?");
    $cprep->bind_param("i", $id_espacio);
    $cprep->execute();
    $result = $cprep->get_result();

    if ($result->num_rows != 0) {
        echo json_encode([
            'tipo' => 'success',
            'data' => $result->fetch_all(MYSQLI_ASSOC)
        ]);
        exit();
    } else {
        echo json_encode([
            'tipo' => 'success',
            'data' => []
        ]);
        exit();
    }

} catch (Exception $e) {
    echo json_encode([
        'tipo' => 'error',
        'mensaje' => $e->getMessage()
    ]);
    exit();
}

?>