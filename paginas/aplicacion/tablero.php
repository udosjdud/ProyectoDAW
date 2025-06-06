<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>TaskMaster</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel='stylesheet' type='text/css' media='screen' href='../../estilos/tablero.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../estilos/user.css'>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="../../scripts/tablero.js" defer></script>
    <script src="../../scripts/user.js" defer></script>
</head>

<body>
    <?php
    require_once("../../server/sesiones.php");

    // Guardad variables importantes en variables de sesión para usarlas en otros archivos php
    if (isset($_POST['titulo_tabla'])) {
        $_SESSION['titulo_tabla'] = $_POST['titulo_tabla'];
        $_SESSION['id_espacio'] = $_POST['id_espacio']; // Muy importante
    }

    ?>

    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <div class="d-flex flex-wrap align-items-center justify-content-between w-100">
                    <div class="d-flex align-items-center mb-2 mb-lg-0">
                        <a href="espacio_trabajo.php" class="btn btn-light me-3">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                        <h1 id="titulo-tablero" class="mb-0 text-break">
                            <?php echo htmlspecialchars($_SESSION['titulo_tabla']); ?>
                        </h1>
                    </div>
                    <button class="add-list-btn btn btn-primary mt-2 mt-lg-0" data-bs-toggle="modal"
                        data-bs-target="#addListModal">
                        <i class="bi bi-plus-lg"></i>
                        <span class="d-none d-sm-inline">Añadir Lista</span>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Modal para añadir listas -->
    <div class="modal fade" id="addListModal" tabindex="-1" aria-labelledby="addListModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addListModalLabel">Nueva Lista</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add_ListForm">
                        <div class="mb-3">
                            <label for="titulo_lista" class="form-label">Título de la Lista</label>
                            <input type="text" class="form-control" id="titulo_lista" maxlength="20" 
                                   pattern="[^<>]*" title="No se permiten los caracteres < y >" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="add_ListForm" class="btn btn-primary">Crear Lista</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para añadir tareas -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">Nueva Tarea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add_TaskForm">
                        <div class="mb-3">
                            <label for="titulo_tarea" class="form-label">Título de la Tarea</label>
                            <input type="text" class="form-control" id="titulo_tarea" maxlength="20" 
                                   pattern="[^<>]*" title="No se permiten los caracteres < y >" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="add_TaskForm" class="btn btn-primary">Crear Tarea</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para las tareas -->
    <div class="modal fade" id="tareaModal" tabindex="-1" aria-labelledby="tareaModalLabel" aria-hidden="true"
        data-id="">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center w-100">
                        <i class="bi bi-card-text me-3 fs-4"></i>
                        <h4 class="modal-title mb-0 flex-grow-1" id="tareaModalLabel"></h4>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <!-- Sección principal izquierda -->
                        <div class="col-lg-8">
                            <!-- Descripción -->
                            <div class="section-container mb-4">
                                <div class="section-header">
                                    <i class="bi bi-text-paragraph me-2"></i>
                                    <h6 class="mb-0">Descripción</h6>
                                </div>
                                <div class="section-content">
                                    <textarea class="form-control" id="descripcion_tarea" rows="4"
                                        placeholder="Añade una descripción más detallada..."></textarea>
                                    <button id="btnGuardar_descripcion" class="btn btn-success btn-sm mt-3 d-none">
                                        <i class="bi bi-check-lg me-1"></i>Guardar cambios
                                    </button>
                                </div>
                            </div>

                            <!-- Subtareas -->
                            <div class="section-container">
                                <div class="section-header">
                                    <i class="bi bi-check2-square me-2"></i>
                                    <h6 class="mb-0">Subtareas</h6>
                                </div>
                                <div class="section-content">
                                    <div class="subtareas-list" id="subtareas-list"></div>

                                    <button class="btn btn-outline-primary btn-sm w-100 mt-3 add-subtarea-btn"
                                        data-bs-toggle="modal" data-bs-target="#addSubtaskModal">
                                        <i class="bi bi-plus-lg me-2"></i>Añadir subtarea
                                    </button>

                                </div>
                            </div>
                        </div>

                        <!-- Panel lateral derecho -->
                        <div class="col-lg-4">
                            <!-- Fecha límite -->
                            <div class="section-container">
                                <div class="section-header">
                                    <i class="bi bi-calendar-event me-2"></i>
                                    <h6 class="mb-0">Fecha de vencimiento</h6>
                                </div>
                                <div class="section-content">
                                    <div class="mb-3">
                                        <input type="date" class="form-control date-input" id="fecha_vencimiento">
                                    </div>
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="bi bi-clock me-2"></i>
                                        <small id="fecha_vencimiento_info">Opcional: establece una fecha de vencimiento</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-between w-100">
                        <button type="button" class="btn btn-outline-danger" id="eliminarTarea">
                            <i class="bi bi-trash me-1"></i>Eliminar tarea
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-1"></i>Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para añadir subtareas -->
    <div class="modal fade" id="addSubtaskModal" tabindex="-1" aria-labelledby="addSubtaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubtaskModalLabel">Nueva Subtarea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add_SubtaskForm">
                        <div class="mb-3">
                            <label for="titulo_subtarea" class="form-label">Título de la Subtarea</label>
                            <input type="text" class="form-control" id="titulo_subtarea" maxlength="20" 
                                   pattern="[^<>]*" title="No se permiten los caracteres < y >" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#tareaModal">Cancelar</button>
                    <button type="submit" form="add_SubtaskForm" class="btn btn-primary" id="btnAñadir_subtarea">Crear Subtarea</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar lista -->
    <div class="modal fade" id="editListModal" tabindex="-1" aria-labelledby="editListModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editListModalLabel">Editar Lista</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit_ListForm">
                        <div class="mb-3">
                            <label for="nuevo_titulo_lista" class="form-label">Nuevo Título de la Lista</label>
                            <input type="text" class="form-control" id="nuevo_titulo_lista" maxlength="20" 
                                   pattern="[^<>]*" title="No se permiten los caracteres < y >" required>
                            <div class="form-text">Máximo 20 caracteres</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="edit_ListForm" class="btn btn-success">
                        <i class="bi bi-check-lg me-1"></i>Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>

    <main>
        <div class="main">
            <div class="main-content">
                <div class="board" id="board">


                </div>
            </div>
            <?php
            require_once("common/user.php");
            ?>

        </div>
    </main>
</body>

</html>