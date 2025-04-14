<?php
    if(isset($_POST['registro'])) {
        try{
            require('conexion.php');
            $email = $_POST['correo'];
            if (filter_var($email, FILTER_VALIDATE_EMAIL) && (str_ends_with($email, '.com') || str_ends_with($email, '.es'))) {
                // El correo es válido, despues guardar el usuario
            } else {
                echo("El correo no es válido. Debe contener un @ y acabar en .com o .es");
            }
        }catch(Trowable $t){
            echo "<p>Error: " . $t->getMessage() . "</p>";
        }
    }

    if(isset($_POST['inicioSesion'])){
        try{

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
                echo("El correo no es válido. Debe contener un @ y acabar en .com o .es");
            }
        }catch(Trowable $t){
            echo("<p>Error: " . $t->getMesssage() . "</p>");
        }
    }
?>