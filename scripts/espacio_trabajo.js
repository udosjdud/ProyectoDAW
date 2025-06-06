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
                        <div class='tabla' data-espacio-id="${tablesData[i].id}" data-tabla-titulo="${tablesData[i].titulo}">
                            <div class="tabla-content">
                                <h4>${tablesData[i].titulo}</h4>
                                <p>Fecha de creación: ${fechaFormateado}</p>
                            </div>
                            <div class="tabla-actions">
                                <button class="tabla-action-btn edit-btn" title="Editar tablero" data-id="${tablesData[i].id}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="tabla-action-btn delete-btn" title="Eliminar tablero" data-id="${tablesData[i].id}">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </div>
                    `)
                }

            } else if (data.tipo == "null") {
                // Para cuando no hay tablas
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

// Función para mandar por POST las variables importantes del tablero
$(document).on("click", ".tabla", function (e) {
    // Prevenir la navegación si se hizo click en un botón de acción
    if ($(e.target).closest('.tabla-action-btn').length > 0) {
        e.stopPropagation();
        return;
    }

    var id_espacio = $(this).data("espacio-id");
    var titulo_tabla = $(this).data("tabla-titulo");

    const form = document.createElement("form");
    form.method = "POST";
    form.action = "tablero.php";

    const campoID = document.createElement("input");
    campoID.type = "hidden";
    campoID.name = "id_espacio";
    campoID.value = id_espacio;

    const campoTitulo = document.createElement("input");
    campoTitulo.type = "hidden";
    campoTitulo.name = "titulo_tabla";
    campoTitulo.value = titulo_tabla;

    form.appendChild(campoID);
    form.appendChild(campoTitulo);

    document.body.appendChild(form);
    form.submit();

});

// Eventos para los botones de acción (prevenir propagación del click)
$(document).on("click", ".tabla-action-btn", function (e) {
    e.stopPropagation();
    e.preventDefault();
});

// Función para abrir el modal de edición
$(document).on("click", ".edit-btn", function (e) {
    e.stopPropagation();
    const tableId = $(this).data('id');
    const currentTitle = $(this).closest('.tabla').find('h4').text();
    
    // Establecer los valores en el modal
    $("#edit_tabla_id").val(tableId);
    $("#nuevo_titulo_tabla").val(currentTitle);
    
    // Mostrar el modal
    $("#editTableModal").modal('show');
});

// Manejo del formulario de edición de tabla
$("#edit_tabla_form").on("submit", function (e) {
    e.preventDefault(); // Evitar que el formulario recargue la página

    // Recoger datos del formulario
    var nuevoTitulo = $("#nuevo_titulo_tabla").val();
    var tablaId = $("#edit_tabla_id").val();

    fetch('../../server/espacio_trabajo/acciones_tabla.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: "id_tabla=" + tablaId + "&accion=editar&titulo=" + encodeURIComponent(nuevoTitulo)
    })
        .then(response => response.json())
        .then(data => {
            console.log("Respuesta del servidor: ", data.mensaje);
            if (data.tipo == "success") {
                pintarTodasTablas(); // Refrescar la lista de tablas
                $("#editTableModal").modal('hide'); // Cerrar el modal
                $("#nuevo_titulo_tabla").val(""); // Limpiar el campo
            } else {
                alert("Error al editar la tabla: " + data.mensaje);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Error de comunicación con el servidor: " + error.message);
        });
});

$(document).on("click", ".delete-btn", function (e) {
    e.stopPropagation();
    const tableId = $(this).data('id');
    fetch("../../server/espacio_trabajo/acciones_tabla.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id_tabla=' + tableId + '&accion=eliminar'
    })
        .then(response => response.json())
        .then(data => {
            console.log("Respuesta del servidor: ", data.mensaje);
            if (data.tipo == "success") {
                pintarTodasTablas();
            } else {
                alert("Error al eliminar la tabla: " + data.mensaje);
            }
        })
});

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
                    <div class='tabla' data-espacio-id="${data.id}" data-tabla-titulo="${tituloTabla}">
                        <div class="tabla-content">
                            <h4>${tituloTabla}</h4>
                            <p>Fecha de creación: ${fechaFormateado}</p>
                        </div>
                        <div class="tabla-actions">
                            <button class="tabla-action-btn edit-btn" title="Editar tablero" data-id="${data.id}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="tabla-action-btn delete-btn" title="Eliminar tablero" data-id="${data.id}">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                    </div>
                    `);
                $("#addTableModal").modal('hide'); // Cerrar el modal
                $("#titulo_tabla").val(""); // Limpiar el campo de entrada
            } else {
                alert("Error al crear la tabla: " + data.mensaje);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Error de comunicación con el servidor: " + error.message);
        });
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