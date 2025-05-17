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

$id_usuario = $_SESSION['id'];

if (isset($_POST['mostrar'])) {

    // Si se quiere mostrar todas las tablas
    if ($_POST['mostrar'] == 'todas') {

        try {
            $cprep = $conexion->prepare("SELECT * FROM espacios_trabajos WHERE id_propietario = ?");
            $cprep->bind_param("i", $id_usuario);
            $cprep->execute();
            $resultado = $cprep->get_result();

            if ($resultado->num_rows < 0) {
                echo json_encode([
                    'tipo' => 'null',
                    'mensaje' => "No tienes tablas creadas"
                ]);
            } else {
                echo json_encode([
                    'tipo' => 'success',
                    'mensaje' => 'Mostrando las tablas',
                    'data' => $resultado->fetch_all(MYSQLI_ASSOC)   // Devuelve un array de arrays asociativos con los datoas de las tablas

                ]);
            }

        } catch (Throwable $t) {
            echo json_encode([
                'tipo' => 'error',
                'mensaje' => $t->getMessage()
            ]);
        }
    }
}
?>