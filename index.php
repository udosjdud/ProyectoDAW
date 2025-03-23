<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="estilos/main.css">
</head>

<body>

    <head>
        <nav class="navbar navbar-expand-lg navbar-light bg-warning">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="#">MyProyecto</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Iniciar Sesion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Registrar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </head>

    <main>

        <div class="mt-4 container">
            <div class="portada row">
                <div class="texto col-12 col-md-6 column d-flex flex-column justify-content-center">
                    <h1 class="text-white custom-fs">Planifica tus tareas</h1>
                    <p class="text-white fw-bold fs-4">Con "MyProyecto" crea listas de tareas personalizadas, asigna
                        prioridades y nunca más olvides lo importante.</p>
                    <div class="d-flex gap-2">
                        <input type="mail" class="form-control w-50"
                            placeholder="Pon tu correo, !Es gratis registrarse¡">
                        <button class="btn btn-info">Registrar</button>
                    </div>
                </div>
                <div class="imagen img-fluid col-12 col-md-6">
                    <img
                        src="https://cdni.iconscout.com/illustration/premium/thumb/project-planning-illustration-download-in-svg-png-gif-file-formats--management-plan-business-discussion-teamwork-pack-illustrations-6666400.png?f=webp">
                </div>
            </div>
        </div>

        <div class="container-fluid mt-5 presentacion">
            <div class="container pt-5">
                <h2 class=""> Un epicentro de productividad </h2>
                <div>
                    <p class="fw-bold">
                        Intuitivo, versátil y eficaz. Con tableros, listas y tarjetas, tendrás todo lo necesario para
                        visualizar claramente quién hace qué y cuáles son las tareas
                        por completar. Consulta nuestra guía de inicio para más detalles.
                    </p>
                    <div class="row mt-4">
                        <div class="col-3 row gap-3">
                            <div class="tarjeta_presentacion card bg-transparent shadow-lg p-3">
                                <h3 class="card-title">Título</h3>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe
                                    debitis minima assumenda dolor illo, quisquam consequatur nesciunt sint
                                    ullam asperiores perspiciatis voluptates dolores iure atque voluptatum, earum dolore
                                    quasi vero.
                                </p>
                            </div>
                            <div class="tarjeta_presentacion card bg-transparent border-0 p-3">
                                <h3 class="card-title">Título</h3>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe
                                    debitis minima assumenda dolor illo, quisquam consequatur nesciunt sint
                                    ullam asperiores perspiciatis voluptates dolores iure atque voluptatum, earum dolore
                                    quasi vero.
                                </p>
                            </div>
                            <div class="tarjeta_presentacion card bg-transparent border-0 p-3">
                                <h3 class="card-title">Título</h3>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe
                                    debitis minima assumenda dolor illo, quisquam consequatur nesciunt sint
                                    ullam asperiores perspiciatis voluptates dolores iure atque voluptatum, earum dolore
                                    quasi vero.
                                </p>
                            </div>
                        </div>

                        <div class="col-9">
                            <h2>Titulo</h2>
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>

    </footer>

    <script>

        $(".tarjeta_presentacion").on("click", function (e) {

            Array.from($(".tarjeta_presentacion")).forEach(x => {

                if ($(x).hasClass("shadow-lg")) {
                    $(x).removeClass("shadow-lg")
                    $(x).addClass("border-0")
                }

            })

            e.target.closest("div").classList.toggle("shadow-lg")
            e.target.closest("div").classList.toggle("border-0")

        })

    </script>

</body>

</html>