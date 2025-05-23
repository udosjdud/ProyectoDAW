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
    <script src="../../scripts/tablero.js" defer></script>
    <script src="../../scripts/user.js" defer></script>
</head>

<body>
    <?php
    require_once("../../server/sesiones.php");

    if (isset($_POST['titulo_tabla'])) {
        $_SESSION['titulo_tabla'] = $_POST['titulo_tabla'];
    }

    ?>

    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <div class="d-flex align-items-center">
                        <a href="espacio_trabajo.php" class="btn btn-light me-3">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                        <h1 id="titulo-tablero">
                            <?php echo htmlspecialchars($_SESSION['titulo_tabla']); ?>
                        </h1>
                    </div>
                    <button class="add-list-btn" data-bs-toggle="modal" data-bs-target="#addListModal">
                        <i class="bi bi-plus-lg"></i>
                        Añadir Lista
                    </button>
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

<!-- Agregar antes del cierre de body -->
<div class="modal fade" id="addListModal" tabindex="-1" aria-labelledby="addListModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addListModalLabel">Nueva Lista</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addListForm">
                    <div class="mb-3">
                        <label for="titulo-lista" class="form-label">Título de la Lista</label>
                        <input type="text" class="form-control" id="titulo-lista" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="addListForm" class="btn btn-primary">Crear Lista</button>
            </div>
        </div>
    </div>
</div>

</html>
