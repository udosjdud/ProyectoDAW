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
})