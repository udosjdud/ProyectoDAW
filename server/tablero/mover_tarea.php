<?php
header('Content-Type: application/json');
require_once('../conexion.php');

try {
    $id_tarea = $_POST['id_tarea'];
    $id_lista = $_POST['id_lista'];

    if (!$id_tarea || !$id_lista) {
        echo json_encode(['tipo' => 'error', 'mensaje' => 'Datos incompletos']);
        exit;
    }

    // 1. Mueve la tarea a la lista y le da la nueva posición
    $stmt = $conexion->prepare("UPDATE tareas SET id_lista = ? WHERE id = ?");
    $stmt->bind_param("ii", $id_lista, $id_tarea);
    $stmt->execute();

    echo json_encode(['tipo' => 'success']);
} catch (Exception $e) {
    echo json_encode(['tipo' => 'error', 'mensaje' => $e->getMessage()]);
}
