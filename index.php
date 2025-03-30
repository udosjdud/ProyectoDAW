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
                            placeholder="Pon tu correo, ¡Es gratis registrarse!">
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
                <h2 class="text-center mb-">Un epicentro de productividad</h2>
                <div>
                    <p class="fw-bold text-center mb-5">
                        Intuitivo, versátil y eficaz. Con tableros, listas y tarjetas, tendrás todo lo necesario para
                        visualizar claramente quién hace qué y cuáles son las tareas
                        por completar. Consulta nuestra guía de inicio para más detalles.
                    </p>
                    
                    <div class="row mt-4">
                        <div class="col-3 row gap-3">
                            <div class="tarjeta_presentacion card bg-transparent shadow-lg p-3" data-img="https://kinsta.com/es/wp-content/uploads/sites/8/2020/10/tipos-de-archivos-de-imagen.png">
                                <h3 class="card-title">Gestión de Tareas</h3>
                                <p class="card-text">Organiza tus tareas de manera eficiente con nuestro sistema de gestión. 
                                    Crea, asigna y da seguimiento a las tareas de tu equipo. Establece fechas límite y 
                                    prioridades para mantener todo bajo control.
                                </p>
                            </div>
                            <div class="tarjeta_presentacion card bg-transparent border-0 p-3" data-img="https://vilmanunez.com/wp-content/uploads/2016/05/listado-banco-de-imagenes-vectores-gratis.png">
                                <h3 class="card-title">Colaboración en Tiempo Real</h3>
                                <p class="card-text">Trabaja junto a tu equipo en tiempo real. Comenta en las tareas, 
                                    comparte archivos y mantén a todos actualizados sobre el progreso del proyecto. La 
                                    comunicación efectiva es clave para el éxito.
                                </p>
                            </div>
                            <div class="tarjeta_presentacion card bg-transparent border-0 p-3" data-img="https://wellaggio.com/wp-content/uploads/2015/10/como-conseguir-ima%CC%81genes-gratis-para-tu-web.jpg">
                                <h3 class="card-title">Seguimiento de Proyectos</h3>
                                <p class="card-text">Visualiza el progreso de tus proyectos con tableros personalizables. 
                                    Obtén informes detallados y métricas que te ayudarán a tomar mejores decisiones y 
                                    optimizar tu flujo de trabajo.
                                </p>
                            </div>
                        </div>

                        <div class="col-9 ps-5">
                            <h2 class="mb-4">Características Principales</h2>
                            <div class="caracteristicas">
                                <div class="contenedor_texto">

                                </div>
                                <div class="contenedor_imagen_presentacion mt-4">
                     
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>

    </footer>

    <script>
        // Funcion para rellenar el contenido
        function rellanarContenido(card) {
            var title = $(card).find(".card-title").text();
            var content = $(card).find(".card-text").text();
            var img = $(card).attr("data-img");

            $(".contenedor_texto").html(`
                <div class="p-4">
                    <h4 class="mb-3">${title}</h4>
                    <p class="fs-5">${content}</p>
                </div>
            `);

            $(".contenedor_imagen_presentacion").html(`
                <img src="${img}" class="img-fluid rounded shadow-sm imagen_presentacion""> 
            `);
        }

        // Cargar contenido al cargar la pagina
        $(document).ready(function() {
            var carta = $(".tarjeta_presentacion.shadow-lg");
            rellanarContenido(carta);
        });

        // Manejo de eventos de las tarjetas
        $(".tarjeta_presentacion").on("click", function (e) {
            Array.from($(".tarjeta_presentacion")).forEach(x => {
                if ($(x).hasClass("shadow-lg")) {
                    $(x).removeClass("shadow-lg")
                    $(x).addClass("border-0")
                }
            })

            var clickedCard = e.target.closest(".tarjeta_presentacion");
            console.log(clickedCard);
            clickedCard.classList.toggle("shadow-lg")
            clickedCard.classList.toggle("border-0")

            rellanarContenido(clickedCard);
        })
    </script>

</body>

</html>