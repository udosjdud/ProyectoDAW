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
    <link rel='stylesheet' type='text/css' media='screen' href='../../estilos/user.css'>
    <script src='../../scripts/espacio_trabajo.js' defer></script>
    <script src='../../scripts/user.js' defer></script>
</head>

<body>

    <?php
    require_once("../../server/sesiones.php");
    ?>

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
                <div class="d-flex align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <button class="btn btn-primary d-md-none btn-ham" type="button" data-bs-toggle="collapse"
                        data-bs-target="#sidebar">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="titulo-h1 d-flex justify-content-center">
                        <h1 class="h1 text-light">Espacio de trabajo de <?php echo $usuario ?></h1>
                    </div>
                </div>

                <!-- Sección de acciones mejorada -->
                <div class="actions-section mb-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div class="action-title">
                            <h2 class="section-title mb-0">Mis Tableros</h2>
                            <p class="section-subtitle text-muted mb-0">Gestiona y organiza tus proyectos</p>
                        </div>
                        <div class="action-buttons d-flex gap-2 flex-wrap">
                            <button class="btn btn-warning btn-action" id="btn-add-form" data-bs-toggle="modal"
                                data-bs-target="#addTableModal" title="Añadir nuevo tablero">
                                <i class="bi bi-plus-circle"></i>
                                <span class="btn-text d-none d-sm-inline">Añadir Tablero</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal para añadir tabla -->
                <div class="modal fade" id="addTableModal" tabindex="-1" aria-labelledby="addTableModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addTableModalLabel">Añadir nueva tabla</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="add_tabla_form" method="POST">
                                    <div class="mb-3">
                                        <label for="titulo" class="form-label">Título de la tabla: </label>
                                        <input type="text" class="form-control" id="titulo_tabla" name="titulo_tabla"
                                            maxlength="30" pattern="[^<>]*" title="No se permiten los caracteres < y >"
                                            required>
                                    </div>

                                    <div class="content_btn mt-4 d-flex gap-2 justify-content-end">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-warning" id="btn_addTabla">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para editar tabla -->
                <div class="modal fade" id="editTableModal" tabindex="-1" aria-labelledby="editTableModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editTableModalLabel">Editar nombre de la tabla</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="edit_tabla_form" method="POST">
                                    <div class="mb-3">
                                        <label for="nuevo_titulo_tabla" class="form-label">Nuevo título de la tabla: </label>
                                        <input type="text" class="form-control" id="nuevo_titulo_tabla" name="nuevo_titulo_tabla"
                                            maxlength="30" pattern="[^<>]*" title="No se permiten los caracteres < y >"
                                            required>
                                    </div>
                                    <input type="hidden" id="edit_tabla_id" name="edit_tabla_id">

                                    <div class="content_btn mt-4 d-flex gap-2 justify-content-end">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-warning" id="btn_editTabla">Guardar cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mostrar tablas  -->
                <div class="content-area">
                    <div class="content-tables">

                    </div>
                </div>

                <?php
                require_once("common/user.php");
                ?>
            </main>
        </div>
    </div>

    <?php
    require_once("common/footer.php");
    ?>
</body>

</html>