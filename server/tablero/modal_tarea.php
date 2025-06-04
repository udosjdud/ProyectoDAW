<?php
header("Content-Type: application/json");

try {

    require_once("../conexion.php");
    session_start();

    if (isset($_POST['id_tarea']) || isset($_POST['id_subtarea'])) {

        $id_tarea = $_POST['id_tarea'];
        $accion = $_POST['accion'];

        if ($accion == "cargarDatos") {
            $cprep = $conexion->prepare("SELECT * FROM tareas WHERE id = ?");
            $cprep->bind_param("i", $id_tarea);
            try {
                $cprep->execute();
                $resultado = $cprep->get_result();
                $tarea = $resultado->fetch_assoc();
                $cprep->close();
                $cprep = $conexion->prepare("SELECT * FROM subtarea WHERE id_tarea = ?");
                $cprep->bind_param("i", $id_tarea);
                try {
                    $cprep->execute();
                    $resultado = $cprep->get_result();
                    $subtareas = $resultado->fetch_all(MYSQLI_ASSOC);
                    $cprep->close();
                    echo json_encode([
                        'tipo' => 'success',
                        'mensaje' => 'Datos cargados correctamente',
                        'data' => [
                            'tarea' => $tarea,
                            'subtareas' => $subtareas
                        ]
                    ]);
                } catch (Exception $e) {
                    echo json_encode([
                        'mensaje' => 'Error al cargar las subtareas'
                    ]);
                }
            } catch (Exception $e) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Error al cargar los datos de la tarea'
                ]);
            }
        }

        if ($accion == "descripcion") {
            $descripcion_tarea = $_POST['descripcion_tarea'];
            $cprep = $conexion->prepare("UPDATE tareas SET descripcion = ? WHERE id = ?");
            $cprep->bind_param("si", $descripcion_tarea, $id_tarea);

            try {
                $cprep->execute();
                echo json_encode([
                    'tipo' => 'success',
                    'mensaje' => 'Descripción actualizada correctamente'
                ]);
                $cprep->close();
            } catch (Exception $e) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Error al actualizar la descripción'
                ]);
            }
        }

        if ($accion == "subtarea") {
            $titulo_subtarea = $_POST['titulo_subtarea'];
            $cprep = $conexion->prepare("INSERT INTO subtarea (titulo, id_tarea) VALUES (?, ?)");
            $cprep->bind_param("si", $titulo_subtarea, $id_tarea);
            try {
                $cprep->execute();
                $id_subTarea = $conexion->insert_id;
                echo json_encode([
                    'tipo' => 'success',
                    'mensaje' => 'Subtarea creada correctamente',
                    'id_subTarea' => $id_subTarea
                ]);
                $cprep->close();
            } catch (Exception $e) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Error al crear la subtarea'
                ]);
            }
        }

        if ($accion == "subTareaCompletado") {
            $completado = $_POST['completado'];
            $id_subtarea = $_POST['id_subtarea'];
            $cprep = $conexion->prepare("UPDATE subtarea SET completado = ? WHERE id = ?");
            $cprep->bind_param("ii", $completado, $id_subtarea);
            try {
                $cprep->execute();
                $cprep->close();
                echo json_encode([
                    'tipo' => 'success',
                    'mensaje' => 'Subtarea actualizada correctamente'
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Error al actualizar la subtarea'
                ]);
            }
        }

        if ($accion == "fechaVencimiento") {
            $fecha_vencimiento = $_POST['fecha_vencimiento'];
            $cprep = $conexion->prepare("UPDATE tareas SET fecha_vencimiento = ? WHERE id = ?");
            $cprep->bind_param("si", $fecha_vencimiento, $id_tarea);
            try {
                $cprep->execute();
                $cprep->close();
                echo json_encode([
                    'tipo' => 'success',
                    'mensaje' => 'Fecha de vencimiento actualizada correctamente'
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Error al actualizar la fecha de vencimiento'
                ]);
            }
        }
    }


} catch (Exception $e) {
    echo json_encode([
        'tipo' => 'error',
        "mensaje" => $e->getMessage()
    ]);
}

?>