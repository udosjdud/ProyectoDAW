$("#add_ListForm").on("submit", function (e) {

    e.preventDefault();

    var tituloLista = $("#titulo_lista").val();

    fetch("../../server/tablero/crear_lista.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: "titulo_lista=" + tituloLista
    })
    .then(response => response.json())
    .then(data => {
        
    })
    
})

// Funcion para arrastrar entre listas
const board = $("#board");
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