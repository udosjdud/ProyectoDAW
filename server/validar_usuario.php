<?php

if (isset($_POST['registro'])) {
    try {
        require('../server/conexion.php');
        $email = $_POST['correo'];

        // Validación del correo
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && (str_ends_with($email, '.com') || str_ends_with($email, '.es'))) {

            // Conexión y selección de base de datos
            if (mysqli_select_db($conexion, $bbdd)) {

                // Comprobamos si el email ya existe usando consultas preparadas
                $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE correo = ?");
                $consulta->bind_param("s", $email);
                $consulta->execute();
                $resultado = $consulta->get_result();

                if ($resultado->num_rows == 0) {

                    // Verificamos que las contraseñas coincidan
                    if ($_POST['password'] == $_POST['re_password']) {

                        // Datos del formulario
                        $nombre = $_POST['nombre'];
                        $correo = $_POST['correo'];
                        $passw = $_POST['password'];

                        // Contraseña encriptada
                        $hashed_password = password_hash($passw, PASSWORD_DEFAULT);

                        // Consulta para insertar el nuevo usuario
                        $consulta = $conexion->prepare("INSERT INTO usuarios (nombre, correo, passw) VALUES (?, ?, ?)");
                        $consulta->bind_param("sss", $nombre, $correo, $hashed_password);

                        if ($consulta->execute()) {
                            session_start();
                            $_SESSION['usuario'] = $_POST['nombre'];
                            $_SESSION['correo'] = $_POST['correo'];
                            $_SESSION['logueado'] = true;
                            $_SESSION['hora'] = time();

                            // Obtener el ID del usuario recién insertado
                            $last_id = $conexion->insert_id;
                            $_SESSION['id'] = $last_id;

                            header("Location: ../paginas/aplicacion/espacio_trabajo.php");
                        } else {
                            header("Location: ../paginas/registro.html?error=insert_error");
                        }

                    } else {
                        header("Location: ../paginas/registro.html?error=passwords_dont_match");
                    }

                } else {
                    header("Location: ../paginas/registro.html?error=email_exists");
                }
            } else {
                header("Location: ../paginas/registro.html?error=bd_error");
            }
        } else {
            header("Location: ../paginas/registro.html?error=invalid_email");
        }
    } catch (Throwable $t) {
        header("Location: ../paginas/registro.html?error=server_error&message=" . urlencode($t->getMessage()));
    }
}

if (isset($_POST['iniciarSesion'])) {
    try {
        require('../server/conexion.php');
        $email = $_POST['correo'];

        // Validación del correo
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && (str_ends_with($email, '.com') || str_ends_with($email, '.es'))) {

            // Consultas preparadas para evitar inyección SQL
            $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
            $pass = $_POST['password'];

            // Consulta para verificar las credenciales del usuario
            $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE correo = ?");
            $consulta->bind_param("s", $correo);
            $consulta->execute();
            $resultado = $consulta->get_result();

            if ($resultado->num_rows == 1) {
                $fila = $resultado->fetch_assoc();

                // Verificamos la contraseña usando password_verify
                if (password_verify($pass, $fila['passw'])) {
                    session_start();
                    $_SESSION['usuario'] = $fila['nombre'];
                    $_SESSION['correo'] = $_POST['correo'];
                    $_SESSION['id'] = $fila['id'];
                    $_SESSION['logueado'] = true;
                    $_SESSION['hora'] = time();
                    header("Location: ../paginas/aplicacion/espacio_trabajo.php");
                    exit();
                } else {
                    header("Location: ../paginas/login.html?error=invalid_credentials");
                }
            } else {
                header("Location: ../paginas/login.html?error=invalid_credentials");
            }
        } else {
            header("Location: ../paginas/login.html?error=invalid_email");
        }
    } catch (Throwable $t) {
        header("Location: ../paginas/registro.html?error=server_error&message=" . urlencode($t->getMessage()));
    }
}
?>