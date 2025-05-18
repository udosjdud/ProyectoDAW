function pintarTodasTablas() {
    // Function for "Todas mis tablas"
    fetch("../../server/espacio_trabajo/mostrar_tablas.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'mostrar=todas'
    })
        .then(response => response.json())
        .then(data => {
            console.log(data)
            if (data.tipo == "success") {
                var contentTables = $(".content-tables");
                var tablesData = data.data;

                contentTables.html(""); // Limpiar el contenido anterior

                for (var i = 0; i < tablesData.length; i++) {
                    const fecha = new Date(tablesData[i].fecha_creacion);
                    // Recoger la fecha en formato YYYY-MM-DD
                    const fechaFormateado = fecha.toISOString().split('T')[0];

                    contentTables.append(`
                        <div class='tabla' data-id='${tablesData[i].id}'>
                            <h4>${tablesData[i].titulo}</h4>
                            <p>Fecha de creación: ${fechaFormateado}</p>
                        </div>
                    `)
                }

            } else if (data.tipo == "null") {

            } else {
                alert("Error al mostrar las tablas: " + data.mensaje);
            }
        })
}

$(document).ready(function () {
    // Pintar todas las tablas al cargar la página
    pintarTodasTablas();
})

$("#todas-tablas").click(pintarTodasTablas);

$("#mis-tablas").click(function () {
    // Function for "Mis tablas"
    $(".content-tables").html("<h3>Mis tablas</h3><p>Aquí se mostrarán las tablas creadas por ti</p>");
});

$("#compartidos").click(function () {
    // Function for "Compartidos conmigo"
    $(".content-tables").html("<h3>Compartidos conmigo</h3><p>Aquí se mostrarán las tablas compartidas contigo</p>");
});

// Función para mostrar la vista del tablero seleccionado
$(document).on("click", ".tabla", function () {
    var id_tabla = $(this).data("id");
    console.log("ID de la tabla seleccionada: " + id_tabla);
    window.location.href = "tablero.php?id_tabla=" + id_tabla;
});

// Funciones para agregar una nueva tabla

function pintarTabla(tituloTabla) {

}

$("#add_tabla_form").on("submit", function (e) {
    e.preventDefault(); // Evitar que el formulario recargue la página

    // Recoger datos de la tabla
    var tituloTabla = $("#titulo_tabla").val();

    fetch('../../server/espacio_trabajo/crear_tabla.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: "titulo_tabla=" + tituloTabla
    })
        .then(response => response.json())
        .then(data => {
            console.log("Respuesta del servidor: ", data.mensaje);
            if (data.tipo == "success") {
                const fecha = new Date(data.fecha_creacion);
                const fechaFormateado = fecha.toISOString().split('T')[0];
                $(".content-tables").append(`
                    <div class='tabla'>
                        <h4>${tituloTabla}</h4>
                        <p>Fecha de creación: ${fechaFormateado}</p> 
                    </div>
                    `);
                $("#addTableModal").modal('hide'); // Cerrar el modal
                $("#titulo_tabla").val(""); // Limpiar el campo de entrada
            } else {
                alert("Error al crear la tabla: " + data.mensaje);
            }
        })
        .catch(error => console.error('Error:', error));
});



// Funcion para abrir el menú lateral en pantallas pequeñas
if (window.innerWidth < 768) {
    $(".list-group-item").click(function () {
        $("#sidebar").toggleClass("hide");
        $('#sidebar').toggleClass('show');
    });

    // Close sidebar when clicking outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#sidebar').length &&
            !$(e.target).closest('[data-bs-toggle="collapse"]').length &&
            $('#sidebar').hasClass('show')) {
            $('#sidebar').toggleClass('hide');
            $('#sidebar').toggleClass('show');
        }
    });

    $(".btn-ham").on("click", function () {
        $("#sidebar").removeClass("hide");
        $("#sidebar").toggleClass("show");
    });
}

// Función para abrir el menú de usuario
$(".content-user").on("click", function (e) {
    e.stopPropagation();
    $(".setting-area").toggleClass("show-settings");
});

// Función para cerrar el menú de usuario cuando se hace click fuera de él
$(document).on('click', function (e) {
    if (!$(e.target).closest('.content-user').length &&
        !$(e.target).closest('.setting-area').length) {
        $(".setting-area").removeClass("show-settings");
    }
});

// Función para cerrar sesión
$("#btn-cerrar-sesion").on("click", function () {
    fetch('../../server/sesiones.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'cerrar_sesion=true'
    })
        .then(response => response.text())
        .then(data => {
            window.location.href = data;
            //console.log(data);
        });
});