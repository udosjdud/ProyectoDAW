<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro de Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">
            <h3>Registro de Usuario</h3>
          </div>
          <div class="card-body">
            <!-- Formulario de registro -->
            <form action="validar_usuario.php" method="POST">
              <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
              </div>
              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <!--Al menos una letra minúscula, al menos una letra mayúscula, al menos un digito, al menos un caracter especial y mínimo 8 caracteres de longitud -->
                <input type="password" class="form-control" id="password" name="password"
                  pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$"
                  title="La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, una letra minúscula, un número y un carácter especial."
                  required>
              </div>
              <button type="submit" class="btn btn-primary w-100" name="registro">Registrarse</button>
            </form>
          </div>
          <div class="card-footer text-center">
            <small>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></small>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>