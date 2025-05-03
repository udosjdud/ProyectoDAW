<?php
    // Aquí se agrega la tabla a la base de datos 
    require_once('conexion.php');
    require_once('sesiones.php');

    if(isset($_POST['titulo_tabla'])) {
        $titulo_tabla = $_POST['titulo_tabla'];
        $id_usuario = $_SESSION['usuario'];

        // Conexión a la base de datos
        $conexion = mysqli_connect($servidor, $usuario, $password, $bbdd);
        mysqli_query($conexion, "SET NAMES 'UTF8'");
            
        
        if ($conexion){
            // Verificar si existen tableros con el mismo título para el usuario
            $query = "SELECT * FROM espacios_trabajos WHERE titulo = '$titulo_tabla' AND propietario = '$id_usuario'";
            $result = mysqli_query($conexion, $query);
            
            if (mysqli_num_rows($result) > 0){
                alert("Ya existe un tablero con ese título");
            }else{
                // Crear la tabla en la base de datos
                $consulta = "INSERT INTO espacios_trabajos (titulo, propietario) VALUES ('$titulo_tabla', '$id_usuario')";
                if(mysqli_query($conexion, $consulta)){
                    echo "Tablero creado";
                }else{
                    echo "Error al crear el tablero";
                }  
            }
        }else{
            echo "Error en la conexión a la base de datos: " . mysqli_connect_error();
            exit();
        }
    }

?>