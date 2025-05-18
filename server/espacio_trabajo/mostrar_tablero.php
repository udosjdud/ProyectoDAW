<?php
header("content-type: application/json");

try {
    require_once('../conexion.php');
    session_start();
} catch (Throwable $t) {
    echo json_encode([
        'tipo' => 'error',
        'mensaje' => $t->getMessage()
    ]);
    exit();
}
$id_tabla = $_POST['id_tabla'];
if (isset($_POST['id_tabla'])) {

    try {
        $cprep = $conexion->prepare("SELECT * FROM espacios_trabajos WHERE id = ?");
        $cprep->bind_param("i", $id_tabla);
        $cprep->execute();
        $resultado = $cprep->get_result();

        if ($resultado->num_rows == 0) {
            echo json_encode([
                'tipo' => 'null',
                'mensaje' => "Error al seleccionar el tablero"
            ]);
        } else {
            echo json_encode([
                'tipo' => 'success',
                'mensaje' => 'Mostrando el tablero',
                'data' => $resultado->fetch_all(MYSQLI_ASSOC)   // Devuelve un array de arrays asociativos con los datos de las tablas
              ]);
            }

        } catch (Throwable $t) {
            echo json_encode([
                'tipo' => 'error',
                'mensaje' => $t->getMessage()
            ]);
        }
    }

?>