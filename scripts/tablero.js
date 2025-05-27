const board = $("#board");

// Funcion para mostrar las listas en el tablero al cargar la página
$(document).ready(function () {
    
    fetch("../../server/tablero/mostrar_listas.php")
        .then(response => response.json())
        .then(data => {
            data.data.forEach(lista => {
                board.append(`
                    <div class="list">
                        <h3>${lista.titulo}</h3>
                        <div class="card-container"></div>
                        <div class="add-card">+ Añadir tarjeta</div>
                    </div>
                `)
            });
        })
})

// Funcion para añadir una lista
$("#add_ListForm").on("submit", function (e) {

    e.preventDefault();

    var tituloLista = $("#titulo_lista").val();

    try {
        fetch("../../server/tablero/crear_lista.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: "titulo_lista=" + tituloLista
        })
            .then(response => response.json())
            .then(data => {
                if (data.tipo == 'success') {
                    board.append(`
                        <div class="list">
                            <h3>${tituloLista}</h3>
                            <div class="card-container"></div>
                            <div class="add-card">+ Añadir tarjeta</div>
                        </div>
                    `)
                } else {
                    alert("Error al crear la lista: " + data.mensaje);
                }

                $('#addListModal').modal('hide');
            })

    } catch (error) {
        console.error('Error:', error);
        alert("Error de comunicación con el servidor: " + error.message);
    }

})

// Funcion para arrastrar entre listas
var isDown = false;
var startX;
var scrollLeft;

board.on("mousedown", function (e) {
    isDown = true;
    startX = e.pageX - board.offset().left;
    scrollLeft = board.scrollLeft();
});

board.on("mouseleave", function () {
    isDown = false;
});

board.on("mouseup", function () {
    isDown = false;
});

board.on("mousemove", function (e) {
    if (!isDown) return;
    e.preventDefault();
    var x = e.pageX - board.offset().left;
    var walk = (x - startX);
    board.scrollLeft(scrollLeft - walk);
})