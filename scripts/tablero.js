const board = $("#board");

// Funcion para mostrar las listas en el tablero al cargar la página
$(document).ready(function () {
    cargarDatos();
})

async function cargarDatos() {
    try {
        const response = await fetch("../../server/tablero/mostrar_listas.php");
        const data = await response.json();
        const listas = data.data;

        listas.forEach(lista => {
            board.append(`
                <div class="list" data-id="${lista.id}" id="lista-${lista.id}">
                    <div class="list-header">
                        <h3>${lista.titulo}</h3>
                        <div class="list-actions">
                            <button class="edit-list-btn" title="Editar lista"><i class="bi bi-pencil"></i></button>
                            <button class="delete-list-btn" title="Eliminar lista"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                    <div class="card-container" id="card-container-${lista.id}"></div>
                    <button class="add-card btn btn-light" data-bs-toggle="modal" data-bs-target="#addTaskModal">+ Añadir tarjeta</button>
                </div>
            `);
        });

        const tareaPorLista = await Promise.all(
            listas.map(async lista => {
                const responseTareas = await fetch("../../server/tablero/mostrar_tarea.php", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: "id_lista=" + lista.id
                });
                const tareas = await responseTareas.json();
                return {
                    listaId: lista.id,
                    tareas: tareas.data
                }
            })
        )

        tareaPorLista.forEach(({ listaId, tareas }) => {
            const container = $("#card-container-" + listaId);
            tareas.forEach(tarea => {
                container.append(`
                    <div class="card" id="card-${tarea.id}" data-id="${tarea.id}">
                        <h4>${tarea.titulo}</h4>
                        <button class="delete-task-btn" title="Eliminar tarea"><i class="bi bi-trash"></i></button>
                    </div>
                `);

                // Aplicar color según fecha de vencimiento
                const cardElement = $("#card-" + tarea.id);
                aplicarColorFechaVencimiento(cardElement, tarea.fecha_vencimiento);
            });
        });

        activarDragAndDrop();

    } catch (error) {
        console.error('Error:', error);
        alert("Error de comunicación con el servidor: " + error.message);
    }
}

function activarDragAndDrop() {
    document.querySelectorAll('.card-container').forEach(container => {
        // Librería SortableJS para drag and drop
        new Sortable(container, {
            group: 'tarjetas',
            animation: 150,
            onEnd: function (e) {
                const nuevaListaId = e.to.id.replace("card-container-", ""); // Obtener el ID de la nueva lista
                // Actulizamos el orden de las tareas
                actualizarOrden(nuevaListaId);
            }
        });
    });
}

function actualizarOrden(listaId) {
    const cards = $(`#card-container-${listaId} .card`);    // Obtener todas las tarjetas de la lista
    const orden = [];   // Array para almacenar el orden de las tarjetas

    cards.each((index, card) => {
        const id = $(card).attr('id').replace('card-', '');
        orden.push({ id_tarea: id, posicion: index });  // Agregar el ID y la posición a la lista
    });

    fetch('../../server/tablero/actualizar_orden.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id_lista: listaId, tareas: orden })  // Enviar las posiciones en formato JSON
    })
        .then(res => res.json())
        .then(data => {
            if (data.tipo !== 'success') {
                console.error(data.mensaje);
                alert('Error al actualizar el orden');
            }
        });
}
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
            body: "titulo_lista=" + encodeURIComponent(tituloLista)
        })
            .then(response => response.json())
            .then(data => {
                if (data.tipo == 'success') {
                    board.append(`
                        <div class="list" data-id="${data.id_lista}" id="lista-${data.id_lista}">
                            <div class="list-header">
                                <h3>${tituloLista}</h3>
                                <div class="list-actions">
                                    <button class="edit-list-btn" title="Editar lista"><i class="bi bi-pencil"></i></button>
                                    <button class="delete-list-btn" title="Eliminar lista"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                            <div class="card-container" id="card-container-${data.id_lista}"></div>
                            <button class="add-card" data-bs-toggle="modal" data-bs-target="#addTaskModal">+ Añadir tarjeta</button>
                        </div>
                    `)
                } else {
                    alert("Error al crear la lista: " + data.mensaje);
                }

                $("#titulo_lista").val('');
                $('#addListModal').modal('hide');
            })

    } catch (error) {
        console.error('Error:', error);
        alert("Error de comunicación con el servidor: " + error.message);
    }

})

// Variable global para almacenar el ID de la lista que se está editando
var listaEditandoId;

// Función para abrir el modal de editar lista
$(document).on("click", ".edit-list-btn", function () {
    const listaElement = $(this).closest(".list");
    listaEditandoId = listaElement.data("id");
    const tituloActual = listaElement.find("h3").text();
    
    // Rellenar el modal con el título actual
    $("#nuevo_titulo_lista").val(tituloActual);
    $("#editListModal").modal('show');
});

// Función para guardar los cambios del nombre de la lista
$("#edit_ListForm").on("submit", function (e) {
    e.preventDefault();
    
    const nuevoTitulo = $("#nuevo_titulo_lista").val().trim();
    
    if (!nuevoTitulo) {
        alert("El título no puede estar vacío");
        return;
    }
    
    fetch("../../server/tablero/cambiar_titulo_lista.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: "id_lista=" + listaEditandoId + "&titulo_lista=" + encodeURIComponent(nuevoTitulo)
    })
        .then(response => response.json())
        .then(data => {
            if (data.tipo === 'success') {
                // Actualizar el título en la interfaz
                $("#lista-" + listaEditandoId + " h3").text(nuevoTitulo);
                $("#editListModal").modal('hide');
                $("#nuevo_titulo_lista").val('');
            } else {
                alert("Error al actualizar la lista: " + data.mensaje);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Error de comunicación con el servidor: " + error.message);
        });
});

// Función para eliminar una lista
$(document).on("click", ".delete-list-btn", function () {
    if (!confirm("¿Estás seguro de que deseas eliminar esta lista?")) {
        return;
    }

    const listaElement = $(this).closest(".list");
    const listaId = listaElement.data("id");

    if (!listaId) {
        alert("Error: No se pudo identificar la lista, recarge la página por favor.");
        return;
    }

    fetch("../../server/tablero/eliminar_lista.php", {
        method: 'POST',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
        },
        body: "id_lista=" + listaId
    })
        .then(response => response.json())
        .then(data => {
            if (data.tipo == 'success') {
                $("#lista-" + listaId).remove()
            } else {
                alert("Error al eliminar la lista: " + data.mensaje);
            }
        })

});

// Funciones para que funcione la insercción de tareas
var listaId;
$(document).on("click", ".add-card", function () {
    // Obtener el ID de la lista a la que se va a añadir la tarea
    listaId = $(this).closest(".list").data("id");
})

// Funcion para añadir una tarea
$("#add_TaskForm").on("submit", function (e) {
    e.preventDefault();
    const titulo = $("#titulo_tarea").val();

    fetch("../../server/tablero/crear_tarea.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: "id_lista=" + listaId + "&titulo_tarea=" + titulo
    })
        .then(response => response.json())
        .then(data => {
            if (data.tipo == 'success') {
                $("#card-container-" + listaId).append(`
                    <div class="card" id="card-${data.id}" data-id="${data.id}">
                        <h4>${titulo}</h4>
                        <button class="delete-task-btn" title="Eliminar tarea"><i class="bi bi-trash"></i></button>
                    </div>
                `)
            } else {
                alert("Error al crear la tarea: " + data.mensaje);
            }
            $("#addTaskModal").modal('hide');
            $("#titulo_tarea").val('');
        })
    activarDragAndDrop();
})

// Funcion para eliminar una tarea
$(document).on("click", ".delete-task-btn", function (e) {
    e.preventDefault(); // Prevenir comportamiento por defecto

    const confirmacion = confirm("¿Estás seguro de que deseas eliminar esta tarea?");
    if (!confirmacion) {
        return; // Si no confirma, no hacer nada
    }

    const id_tarea = $(this).closest(".card").data('id');

    fetch("../../server/tablero/eliminar_tarea.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: "id_tarea=" + id_tarea
    })
        .then(response => response.json())
        .then(data => {
            if (data.tipo == 'success') {
                $("#card-" + id_tarea).remove();
            } else {
                alert("Error al eliminar la tarea: " + data.mensaje);
            }
        })
        .catch(error => {
            console.error("Error al eliminar la tarea:", error);
            alert("Error de comunicación con el servidor: " + error.message);
        });
})

// Funcion para cargar los datos de la tarea (manejar clic en tarjeta manualmente)
$(document).on("click", ".card", function (e) {
    const taskTitle = $(this).find('h4').text();
    $('#tareaModalLabel').text(taskTitle);
    const id_tarea = $(this).data('id');
    $('#tareaModal').data('id', id_tarea);

    $("#btnGuardar_descripcion").addClass('d-none');

    fetch("../../server/tablero/modal_tarea.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: "id_tarea=" + id_tarea + "&accion=cargarDatos"
    })
        .then(response => response.json())
        .then(data => {
            if (data.tipo == 'success') {
                console.log(data);
                $("#descripcion_tarea").val(data.data.tarea.descripcion);
                $("#fecha_vencimiento").val("");
                $("#fecha_vencimiento_info").text("Opcional: establece una fecha de vencimiento");
                // Si la tarea tiene fecha de vencimiento, se muestra en el input y se calcula la diferencia de días
                if (data.data.tarea.fecha_vencimiento != null) {
                    $("#fecha_vencimiento").val(data.data.tarea.fecha_vencimiento);
                    const hoy = new Date();
                    const hoy_formateado = hoy.toISOString().split('T')[0];
                    const diferencia = dateDiffInDays(new Date(hoy_formateado), new Date(data.data.tarea.fecha_vencimiento));

                    if (diferencia > 0) {
                        $("#fecha_vencimiento_info").text("Te quedan " + diferencia + " día/s para completar la tarea");
                    } else if (diferencia == 0) {
                        $("#fecha_vencimiento_info").text("La tarea vence mañana");
                    } else {
                        $("#fecha_vencimiento_info").text("La tarea ya está vencida");
                    }
                }

                $("#subtareas-list").empty();
                for (subtarea of data.data.subtareas) {
                    $("#subtareas-list").append(`
                    <div class="subtarea-item" id="subtarea-${subtarea.id}">
                        <div class="d-flex align-items-center flex-grow-1">
                            <input class="task-check-input me-3" type="checkbox" id="subtarea-${subtarea.id}" ${subtarea.completado == 1 ? 'checked' : ''}>
                            <label class="task-check-label flex-grow-1" for="subtarea-${subtarea.id}">
                                ${subtarea.titulo}
                            </label>
                        </div>
                        <button class="btn btn-sm btn-outline-danger delete-subtarea">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                `)
                }

                // Abrir el modal manualmente
                $('#tareaModal').modal('show');
            } else {
                alert("Error al cargar los datos de la tarea: " + data.mensaje);
            }
        })

});

// Funciones para descripcion de la tarea
$(document).on("click", "#btnGuardar_descripcion", function () {
    const descripcion_tarea = $("#descripcion_tarea").val();
    const id_tarea = $("#tareaModal").data("id");

    fetch("../../server/tablero/modal_tarea.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: "descripcion_tarea=" + descripcion_tarea + "&id_tarea=" + id_tarea + "&accion=descripcion"
    })
        .then(response => response.json())
        .then(data => {
            if (data.tipo == 'success') {
                $("#btnGuardar_descripcion").addClass('d-none');
            } else {
                alert("Error al actualizar la descripción: " + data.mensaje);
            }
        })
})

$("#descripcion_tarea").on("input", function () {
    $("#btnGuardar_descripcion").removeClass('d-none');
});

// Funcion para añadir una subtarea
$(document).on("click", "#btnAñadir_subtarea", function (e) {
    e.preventDefault();
    const titulo_subtarea = $("#titulo_subtarea").val();
    const id_tarea = $("#tareaModal").data("id");

    fetch("../../server/tablero/modal_tarea.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: "titulo_subtarea=" + titulo_subtarea + "&id_tarea=" + id_tarea + "&accion=subtarea"
    })
        .then(response => response.json())
        .then(data => {
            if (data.tipo == 'success') {
                $("#subtareas-list").append(`
                    <div class="subtarea-item" id="subtarea-${data.id_subTarea}">
                        <div class="d-flex align-items-center flex-grow-1">
                            <input class="task-check-input me-3" type="checkbox" id="subtarea-${data.id_subTarea}">
                            <label class="task-check-label flex-grow-1" for="subtarea-${data.id_subTarea}">
                                ${titulo_subtarea}
                            </label>
                        </div>
                        <button class="btn btn-sm btn-outline-danger delete-subtarea">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                `)
            }

            $("#titulo_subtarea").val('');
            $("#addSubtaskModal").modal('hide');
            $("#tareaModal").modal('show');
        })
})

$(document).on("change", ".task-check-input", function () {
    const id_subtarea = $(this).attr("id").replace("subtarea-", "");
    const completado = $(this).prop("checked");

    fetch("../../server/tablero/modal_tarea.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: "id_subtarea=" + id_subtarea + "&completado=" + (completado ? 1 : 0) + "&accion=subTareaCompletado"
    })
})

// Funcion para actualizar la fecha de vencimiento de la tarea
$(document).on("input", "#fecha_vencimiento", function () {
    const fecha_vencimiento = $(this).val();
    const id_tarea = $("#tareaModal").data("id");

    fetch("../../server/tablero/modal_tarea.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: "fecha_vencimiento=" + fecha_vencimiento + "&id_tarea=" + id_tarea + "&accion=fechaVencimiento"
    })
        .then(response => response.json())
        .then(data => {
            if (data.tipo == 'success') {
                const hoy = new Date();
                const hoy_formateado = hoy.toISOString().split('T')[0];
                const diferencia = dateDiffInDays(new Date(hoy_formateado), new Date(fecha_vencimiento));
                if (diferencia > 0) {
                    $("#fecha_vencimiento_info").text("Te quedan " + diferencia + " día/s para completar la tarea");
                } else if (diferencia == 0) {
                    $("#fecha_vencimiento_info").text("La tarea vence mañana");
                } else {
                    $("#fecha_vencimiento_info").text("La tarea ya está vencida");
                }

                // Actualizar el color de la tarjeta en el tablero
                const cardElement = $("#card-" + id_tarea);
                aplicarColorFechaVencimiento(cardElement, fecha_vencimiento);
            } else {
                alert("Error al actualizar la fecha de vencimiento: " + data.mensaje);
            }
        })
})

function dateDiffInDays(a, b) {
    const milis_por_dia = 1000 * 60 * 60 * 24;
    // Discard the time and time-zone information.
    const utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
    const utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate());

    return Math.floor((utc2 - utc1) / milis_por_dia);
}

$(document).on("click", ".delete-subtarea", function () {
    const id_subtarea = $(this).closest(".subtarea-item").attr("id").replace("subtarea-", "");

    fetch("../../server/tablero/modal_tarea.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: "id_subtarea=" + id_subtarea + "&accion=eliminarSubtarea"
    })
        .then(response => response.json())
        .then(data => {
            if (data.tipo == 'success') {
                $("#subtarea-" + id_subtarea).remove();
            } else {
                alert("Error al eliminar la subtarea: " + data.mensaje);
            }
        })

})

// Función para aplicar colores a las tarjetas según su fecha de vencimiento
function aplicarColorFechaVencimiento(cardElement, fechaVencimiento) {
    if (!fechaVencimiento) return;

    const hoy = new Date();
    const hoy_formateado = hoy.toISOString().split('T')[0];
    const diferencia = dateDiffInDays(new Date(hoy_formateado), new Date(fechaVencimiento));

    // Remover clases previas
    cardElement.removeClass('vence-pronto vencida');

    if (diferencia == 0) {
        // Vence mañana (diferencia == 0)
        cardElement.addClass('vence-pronto');
    } else if (diferencia < 0) {
        // Ya vencida (diferencia < 0)
        cardElement.addClass('vencida');
    }
}

// Función para actualizar los colores de todas las tarjetas
async function actualizarColoresTarjetas() {
    const tarjetas = $('.card');

    for (let tarjeta of tarjetas) {
        const id_tarea = $(tarjeta).data('id');
        try {
            const response = await fetch("../../server/tablero/modal_tarea.php", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: "id_tarea=" + id_tarea + "&accion=cargarDatos"
            });
            const data = await response.json();

            if (data.tipo == 'success' && data.data.tarea.fecha_vencimiento) {
                const cardElement = $("#card-" + id_tarea);
                aplicarColorFechaVencimiento(cardElement, data.data.tarea.fecha_vencimiento);
            }
        } catch (error) {
            console.error('Error al actualizar color de tarjeta:', error);
        }
    }
}

// Actualizar colores cada 30 minutos (1800000 ms)
setInterval(actualizarColoresTarjetas, 1800000);

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
