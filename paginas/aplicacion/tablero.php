<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tablero</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel='stylesheet' type='text/css' media='screen' href='../../estilos/tablero.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../estilos/user.css'>
</head>

<body>
    <?php
    require_once("../../server/sesiones.php");
    ?>

    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <a href="espacio_trabajo.php" class="btn btn-light btn-outline-dark me-3">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                    <h1 class="" id="titulo-tablero">
                        <?php echo htmlspecialchars($_POST['titulo_tabla']); ?>
                    </h1>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="main-content">
     
        </div>

    <?php
    require_once("common/user.php");
    ?>
    </main>

    <?php
    require_once("common/footer.php");
    ?>
</body>
<script src="../../scripts/user.js"></script>

</html>