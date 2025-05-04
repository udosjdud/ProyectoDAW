$("#todas-tablas").click(function () {
    // Function for "Todas mis tablas"
    $(".content-area").html("<h3>Todas mis tablas</h3><p>Aquí se mostrarán todas tus tablas</p>");
});

$("#mis-tablas").click(function () {
    // Function for "Mis tablas"
    $(".content-area").html("<h3>Mis tablas</h3><p>Aquí se mostrarán las tablas creadas por ti</p>");
});

$("#compartidos").click(function () {
    // Function for "Compartidos conmigo"
    $(".content-area").html("<h3>Compartidos conmigo</h3><p>Aquí se mostrarán las tablas compartidas contigo</p>");
});

// Funciones para agregar una nueva tabla

function pintarTabla(tituloTabla){

}

$("#add_tabla_form").on("submit", function (e) {
    e.preventDefault(); // Evitar que el formulario recargue la página
    
    // Recoger datos de la tabla
    var tituloTabla = $("#titulo_tabla").val();

    fetch('../../server/crear_tabla.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: "titulo_tabla=" + tituloTabla
    })
    .then(response => response.json())
    .then(data => {
        console.log("Respuesta del servidor: ",data.mensaje);
        if (data){
            $(".content-area").append(`<div class="tablero">${tituloTabla}</div>`);
            $("#addTableModal").modal('hide'); // Cerrar el modal
            $("#titulo_tabla").val(""); // Limpiar el campo de entrada
        }else{
            alert("Error al crear la tabla: " + data.error);
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