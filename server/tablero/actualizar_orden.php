<?php
header('Content-Type: application/json');
require_once('../conexion.php');

try {
    $input = json_decode(file_get_contents('php://input'), true);   // Para recibir datos en formato JSON 
    $id_lista = $input['id_lista'];
    $tareas = $input['tareas'];

    $cprep = $conexion->prepare("UPDATE tareas SET posicion = ?, id_lista = ? WHERE id = ?");

    // Actualizar la posición de cada tarea en la lista en la base de datos
    foreach ($tareas as $tarea) {
        $posicion = $tarea['posicion'];
        $id_tarea = $tarea['id_tarea'];
        $cprep->bind_param("iii", $posicion, $id_lista, $id_tarea);
        $cprep->execute();
    }

    echo json_encode(['tipo' => 'success']);
} catch (Exception $e) {
    echo json_encode(['tipo' => 'error', 'mensaje' => $e->getMessage()]);
}
