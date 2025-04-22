<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Espacio de Trabajo</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel='stylesheet' type='text/css' media='screen' href='../../estilos/espacio_trabajo.css'>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky">
                    <div class="list-group list-group-flush mt-4">
                        <button id="todas-tablas" class="list-group-item list-group-item-action py-3">
                            <i class="bi bi-table me-2"></i>
                            <span>Todas mis tablas</span>
                        </button>
                        <button id="mis-tablas" class="list-group-item list-group-item-action py-3">
                            <i class="bi bi-person-workspace me-2"></i>
                            <span>Mis tablas</span>
                        </button>
                        <button id="compartidos" class="list-group-item list-group-item-action py-3">
                            <i class="bi bi-share me-2"></i>
                            <span>Compartidos conmigo</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <button class="btn btn-primary d-md-none btn-ham" type="button" data-bs-toggle="collapse"
                        data-bs-target="#sidebar">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="titulo-h1 d-flex justify-content-center">
                        <h1 class="h2 text-light">Espacio de trabajo</h1>
                    </div>
                </div>

                <div class="content-area">
                    <!-- El contenido se pinta aquí -->
                    <p>Selecciona una opción del menú para comenzar.</p>
                </div>

                <div class="user-area">
                    <div class="content-user">
                        <div class="setting-area">
                            <div class="setting-list">
                                <button id="" class="btn-setting btn btn-link text-decoration-none"><i class="bi bi-gear"></i> Configuración</button>
                                <button id="btn-cerrar-sesion" class="btn-setting btn btn-link text-decoration-none"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php
        require_once("common/footer.php");
    ?>
</body>
<script src='../../scripts/espacio_trabajo.js'></script>

</html>