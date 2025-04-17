<?php

if (isset($_POST['registro'])) {
    try {
        require('../server/conexion.php');
        $email = $_POST['correo'];
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && (str_ends_with($email, '.com') || str_ends_with($email, '.es'))) {

            $conexion = mysqli_connect($servidor, $usuario, $password, $bbdd);
            mysqli_query($conexion, "SET NAMES 'UTF8'");

            if (mysqli_select_db($conexion, $bbdd)) {

                $consulta = "SELECT * FROM usuarios WHERE correo='$email'";
                $resultado = mysqli_query($conexion, $consulta);

                if (mysqli_num_rows($resultado) == 0) {
                    
                    if ($_POST['password'] == $_POST['re_password']) {

                        $nombre = $_POST['nombre'];
                        $correo = $_POST['correo'];
                        $passw = $_POST['password'];

                        $consulta = "INSERT INTO usuarios (nombre, correo, passw) VALUES ('$nombre', '$correo', AES_ENCRYPT('$passw', 'almandrullos'))";
                        
                        if(mysqli_query($conexion, $consulta)) {
                            header("Location: ../paginas/espacio_trabajo.html");
                        } else {
                            header("Location: ../paginas/registro.html?error=insert_error");
                        }

                    } else {
                        header("Location:../paginas/registro.html?error=passwords_dont_match");
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


if (isset($_POST['inicioSesion'])) {
    try {

        $email = $_POST['correo'];
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && (str_ends_with($email, '.com') || str_ends_with($email, '.es'))) {
            // El correo es válido
            $conexion = mysqli_connect($servidor, $usuario, $password, $bbdd);
            mysqli_query($conexion, "SET NAMES 'UTF8'");

            $user = mysqli_real_escape_string($conexion, $_POST['correo']);
            $pass = mysqli_real_escape_string($conexion, $_POST['password']);

            $consulta = "SELECT * FROM usuarios WHERE user='$user' AND AES_DECRYPT(pass, 'almandrullos')='$pass'";
            $resultado = mysqli_query($conexion, $consulta);

            if (mysqli_num_rows($resultado) == 1) {
                $_SESSION['usuario'] = $_POST['usuario'];
                $_SESSION['logueado'] = true;
                $_SESSION['hora'] = time();
                header("Location: pagina_principal.php");
            } else {
                header("Location: login.php?mensaje=error");
            }
        } else {
            echo ("El correo no es válido. Debe contener un @ y acabar en .com o .es");
        }
    } catch (Trowable $t) {
        echo ("<p>Error: " . $t->getMesssage() . "</p>");
    }
}
?>