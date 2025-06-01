<?php
header('Content-Type: application/json');

try {
    require_once("../conexion.php");
    session_start();

    if (isset($_POST['id_lista'])) {
        $id_lista = $_POST['id_lista'];
        $cprep = $conexion->prepare("DELETE FROM lista WHERE id = ?");
        $cprep->bind_param("i", $id_lista);
        if ($cprep->execute()) {
            $cprep->close();
            echo json_encode([
                'tipo' => 'success',
                'mensaje' => 'Lista eliminada correctamente'
            ]);
        } else {
            echo json_encode([
                'tipo' => 'error',
                'mensaje' => 'Error al eliminar la lista'
            ]);
        }
    }
} catch (Exception $e) {
    echo json_encode([
        'tipo' => 'error',
        'mensaje' => 'Error al conectar a la base de datos'
    ]);
}

?>