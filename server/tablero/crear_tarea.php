<?php
header("Content-type: application/json");

try {
    require_once("../conexion.php");
    session_start();

    if (isset($_POST['id_lista']) && isset($_POST['titulo_tarea'])) {

        $id_lista = $_POST['id_lista'];
        $titulo_tarea = $_POST['titulo_tarea'];

        // 1. Obtener la última posición en la lista
        $prepPos = $conexion->prepare("SELECT MAX(posicion) AS max_pos FROM tareas WHERE id_lista = ?");
        $prepPos->bind_param("i", $id_lista);
        $prepPos->execute();
        $resPos = $prepPos->get_result();
        $row = $resPos->fetch_assoc();
        $nueva_pos = $row['max_pos'] !== null ? $row['max_pos'] + 1 : 0;

        // 2. Insertar tarea con posición
        $cprep = $conexion->prepare("INSERT INTO tareas (titulo, id_lista, posicion) VALUES (?, ?, ?)");
        $cprep->bind_param("sii", $titulo_tarea, $id_lista, $nueva_pos);

        if ($cprep->execute()) {
            $last_id = $conexion->insert_id;
            echo json_encode([
                'tipo' => 'success',
                'mensaje' => 'Tarea creada correctamente',
                'id' => $last_id,
                'posicion' => $nueva_pos
            ]);
        } else {
            echo json_encode([
                'tipo' => 'error',
                'mensaje' => 'Error al crear la tarea'
            ]);
        }

    } else {
        echo json_encode([
            'tipo' => 'error',
            'mensaje' => 'No se ha enviado el id de la lista o el título'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'tipo' => 'error',
        'mensaje' => 'Error al conectar con la base de datos: ' . $e->getMessage()
    ]);
    exit();
}
?>