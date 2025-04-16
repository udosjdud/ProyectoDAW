// Funcion para rellenar el contenido
function rellanarContenido(card) {
    var title = $(card).find(".card-title").text();
    var content = $(card).find(".card-text").text();
    var img = $(card).attr("data-img");
    var anchoPantalla = $(window).width();
    
    $(".contenedor_texto").html(`
        <div class="p-4">
            <h4 class="mb-3">${title}</h4>
            <p class="fs-5">${content}</p>
        </div>
    `);

    const imageClasses = anchoPantalla > 992 ? 'img-fluid rounded shadow-sm imagen_presentacion' : 'img-fluid rounded imagen_presentacion';
    
    // Añadir la clase fade-out a la imagen actual
    $(".imagen_presentacion").addClass('fade-out').removeClass('fade-in');
    
    // Dar un tiempo para que se complete la animación antes de cambiar la imagen
    setTimeout(() => {
        $(".contenedor_imagen_presentacion").html(`
            <img src="${img}" class="${imageClasses}"> 
        `);

        // Dar un tiempo para añadir la clase fade-in a la nueva imagen
        setTimeout(() => {
            $(".imagen_presentacion").addClass('fade-in');
        }, 50);
    }, 200);
}

// Cargar contenido al cargar la pagina
$(document).ready(function () {
    var carta = $(".tarjeta_presentacion.shadow-lg");
    rellanarContenido(carta);
});

// Manejo de eventos de las tarjetas
$(".tarjeta_presentacion").on("click", function (e) {

    var anchoPantalla = $(window).width();
    console.log(anchoPantalla); // Imprime el ancho de la pantalla en consol

    if (anchoPantalla > 992)  {
        Array.from($(".tarjeta_presentacion")).forEach(x => {
            if ($(x).hasClass("shadow-lg")) {
                $(x).removeClass("shadow-lg")
                $(x).addClass("border-0")
            }
        })
    
        var clickedCard = e.target.closest(".tarjeta_presentacion");
        clickedCard.classList.toggle("shadow-lg")
        clickedCard.classList.toggle("border-0")
    
        rellanarContenido(clickedCard);
    }
})

// Eventos del carrusel
$('#carouselTarjetas').on('slide.bs.carousel', function (e) {
    var activeCard = $(e.relatedTarget).find('.tarjeta_presentacion');
    rellanarContenido(activeCard);
});