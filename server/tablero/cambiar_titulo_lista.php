<?php
header("Content-Type: application/json");

try {
    require_once("../conexion.php");
    session_start();

    if (isset($_POST['id_lista']) && isset($_POST['titulo_lista'])) {
        $id_lista = $_POST['id_lista'];
        $titulo_lista = $_POST['titulo_lista'];

        $cprep = $conexion->prepare("UPDATE lista SET titulo = ? WHERE id = ?");
        $cprep->bind_param("si", $titulo_lista, $id_lista);
        try {
            $cprep->execute();
            $cprep->close();
            echo json_encode([
                'tipo' => 'success',
                'mensaje' => 'Lista actualizada correctamente'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'tipo' => 'error',
                'mensaje' => 'Error al actualizar la lista'
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