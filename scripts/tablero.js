$(document).ready(function () {
    // Buscar los parámetros de la URL
    const params = new URLSearchParams(window.location.search);
    const id_tabla = params.get('id_tabla');
    fetch("../../server/espacio_trabajo/mostrar_tablero.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "id_tabla=" + id_tabla
    })
    .then(res => res.json())
    .then(respuesta => {
        console.log(respuesta);
        $("#vista-tablero").html(`<h3>Vista del tablero ${respuesta.data.titulo}</h3><p>Aquí se mostrará el tablero seleccionado</p>`); 
    });
});