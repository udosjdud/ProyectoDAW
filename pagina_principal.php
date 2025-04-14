<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #212529; /* Fondo oscuro */
            color: #f8f9fa; /* Texto claro */
        }
        .sidebar {
            background-color: #343a40;
            height: 100vh;
            padding: 20px;
        }
        .sidebar h5 {
            color: #f8f9fa;
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
        }
        .sidebar a:hover {
            color: #f8f9fa;
        }
        .tablero {
            background-color: #495057;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            color: #f8f9fa;
        }
        .tablero h5 {
            font-weight: bold;
        }
        .tarjeta {
            background-color: #6c757d;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            color: #f8f9fa;
        }
        .tarjeta:hover {
            background-color: #5a6268;
        }
        .add-card {
            color: #17a2b8;
            cursor: pointer;
        }
        .add-card:hover {
            text-decoration: underline;
        }
        .header {
            padding: 10px 20px;
            color: #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header bg-primary">
        <h4>Gestor de Tableros</h4>
        <button class="btn btn-warning">Crear Tablero</button>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-3 sidebar">
                <h5>Menú</h5>
                <a href="#">Tableros</a>
                <a href="#">Plantillas</a>
                <a href="#">Inicio</a>
                <hr>
                <h5>Espacios de Trabajo</h5>
                <a href="#">Proyecto 1</a>
                <a href="#">Proyecto 2</a>
                <a href="#">Crear nuevo espacio</a>
            </div>

            <!-- Main Content -->
            <div class="col-9">
                <h2 class="mt-4">Tus Tableros</h2>
                <div class="row">
                    <!-- Tablero 1 -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="tablero">
                            <h5>Tablero 1</h5>
                            <div class="tarjeta">Tarea 1</div>
                            <div class="tarjeta">Tarea 2</div>
                            <div class="tarjeta">Tarea 3</div>
                            <div class="add-card">+ Añadir tarjeta</div>
                        </div>
                    </div>
                    <!-- Tablero 2 -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="tablero">
                            <h5>Tablero 2</h5>
                            <div class="tarjeta">Tarea A</div>
                            <div class="tarjeta">Tarea B</div>
                            <div class="add-card">+ Añadir tarjeta</div>
                        </div>
                    </div>
                    <!-- Tablero 3 -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="tablero">
                            <h5>Tablero 3</h5>
                            <div class="tarjeta">Tarea X</div>
                            <div class="tarjeta">Tarea Y</div>
                            <div class="tarjeta">Tarea Z</div>
                            <div class="add-card">+ Añadir tarjeta</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>