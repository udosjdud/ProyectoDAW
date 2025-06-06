<?php
header("Content-Type: application/json");

if (isset($_POST['id_tabla']) && isset($_POST['accion'])) {

    $id_tabla = $_POST['id_tabla'];
    $accion = $_POST['accion'];

    try {
        require_once("../conexion.php");

        if ($accion == "eliminar") {
            $cprep = $conexion->prepare("DELETE FROM espacios_trabajos WHERE id = ?");
            $cprep->bind_param("i", $id_tabla);
            $cprep->execute();
            if ($cprep->affected_rows > 0) {
                echo json_encode([
                    "tipo" => "success",
                    "mensaje" => "Tabla eliminada correctamente"
                ]);
            } else {
                echo json_encode([
                    "tipo" => "error",
                    "mensaje" => "No se pudo eliminar la tabla"
                ]);
            }
        }

        if ($accion == "editar") {
            $titulo = $_POST['titulo'];
            $cprep = $conexion->prepare("UPDATE espacios_trabajos SET titulo = ? WHERE id = ?");
            $cprep->bind_param("si", $titulo, $id_tabla);
            $cprep->execute();
            if ($cprep->affected_rows > 0) {
                echo json_encode([
                    "tipo" => "success",
                    "mensaje" => "Tabla actualizada correctamente"
                ]);
            } else {
                echo json_encode([
                    "tipo" => "error",
                    "mensaje" => "No se pudo actualizar la tabla"
                ]);
            }
        }

    } catch (Exception $e) {
        echo json_encode([
            "tipo" => "error",
            "mensaje" => "Error al eliminar la tabla: " . $e->getMessage()
        ]);
    }
}

?>