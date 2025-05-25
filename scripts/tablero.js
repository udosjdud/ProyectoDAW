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
        console.log("Respuesta del servidor: ", data);
    })
    
})