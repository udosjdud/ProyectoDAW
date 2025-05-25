<?php
header('Content-Type: application/json');

try {
    require_once('../conexion.php');
    session_start();
} catch (Throwable $t) {
    echo json_encode(['mensaje' => 'Error en la conexión a la base de datos']);
    exit();
}

if (isset($_POST['titulo_tabla'])) {
    $titulo_tabla = $_POST['titulo_tabla'];
    $id_usuario = $_SESSION['id'];

    // Verificar si existen tableros con el mismo título para el usuario
    $consulta = $conexion->prepare("SELECT * FROM espacios_trabajos WHERE titulo = ? AND id_propietario = ?");
    $consulta->bind_param("si", $titulo_tabla, $id_usuario);
    $consulta->execute();
    $result = $consulta->get_result();

    if ($result->num_rows != 0) {
        echo json_encode([
            'tipo' => 'error',
            'mensaje' => 'Ya existe un tablero con ese título'
        ]);
    } else {
        // Crear el tablero
        $cprep = $conexion->prepare("INSERT INTO espacios_trabajos (titulo, id_propietario) VALUES (?, ?)");
        $cprep->bind_param("si", $titulo_tabla, $id_usuario);

        if ($cprep->execute()) {
            $last_id = $conexion->insert_id;
            // Preparar la consulta SQL 
            $consulta2 = $conexion->prepare("SELECT fecha_creacion FROM espacios_trabajos WHERE id = ?");
            // Asociar el valor de last_id al parámetro ? de la consulta, "i" indica que el parámetro es un entero
            $consulta2->bind_param("i", $last_id);
            // Ejecutar la consulta
            $consulta2->execute();
            // Obtener el resultado
            $result2 = $consulta2->get_result();

            if ($fila = $result2->fetch_assoc()) {
                echo json_encode([
                    'tipo' => 'success',
                    'mensaje' => 'Tablero creado correctamente',
                    'fecha_creacion' => $fila['fecha_creacion'],
                    'id' => $last_id
                ]);
            } else {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'No se pudo obtener la fecha de creación'
                ]);
            }

            $consulta2->close();
        } else {
            echo json_encode([
                'tipo' => 'error',
                'mensaje' => 'Error al crear el tablero'
            ]);
        }

        $cprep->close();
    }

    $consulta->close();
    $conexion->close();
}
?>