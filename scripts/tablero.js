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
                    <div class="card" id="card-${tarea.id}" data-bs-toggle="modal" data-bs-target="#tareaModal" data-id="${tarea.id}">
                        <h4>${tarea.titulo}</h4>
                        <button class="delete-task-btn" title="Eliminar tarea"><i class="bi bi-trash"></i></button>
                    </div>
                `);
            });
        });

        activarDragAndDrop();

        function activarDragAndDrop() {
            document.querySelectorAll('.card-container').forEach(container => {
                // Librería SortableJS para drag and drop
                new Sortable(container, {
                    group: 'tarjetas',
                    animation: 150,
                    onEnd: function (e) {
                        const idTarea = e.item.id.replace("card-", ""); // Obtener el ID de la tarea
                        const nuevaListaId = e.to.id.replace("card-container-", ""); // Obtener el ID de la nueva lista

                        fetch("../../server/tablero/mover_tarea.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                            body: `id_tarea=${idTarea}&id_lista=${nuevaListaId}`
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.tipo !== 'success') {
                                    alert("Error al mover la tarea: " + data.mensaje);
                                }
                            })
                            .catch(err => {
                                console.error("Error al mover la tarea:", err);
                            });

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

    } catch (error) {
        console.error('Error:', error);
        alert("Error de comunicación con el servidor: " + error.message);
    }
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
            body: "titulo_lista=" + tituloLista
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

                $('#addListModal').modal('hide');
            })

    } catch (error) {
        console.error('Error:', error);
        alert("Error de comunicación con el servidor: " + error.message);
    }

})

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
            console.log(data);
            $("#lista-" + listaId).remove()
        })

});

// Funciones para que funcione la insercción de tareas
var listaId;
$(document).on("click", ".add-card", function () {
    // Obtener el ID de la lista a la que se va a añadir la tarea
    listaId = $(this).closest(".list").data("id");
})

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
            console.log("card-container-" + listaId);
            $("#card-container-" + listaId).append(`
                <div class="card" id="card-${data.id}" data-bs-toggle="modal" data-bs-target="#tareaModal" data-id="${data.id}">
                    <h4>${titulo}</h4>
                    <button class="delete-task-btn" title="Eliminar tarea"><i class="bi bi-trash"></i></button>
                </div>
                `)
        })
})


/* TODAS LAS FUNCIONES PARA EL MODAL DE LAS TAREAS */

$(document).on("click", ".card", function () {
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
                $("#descripcion_tarea").val(data.data.tarea.descripcion);
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
})

$("#descripcion_tarea").on("input", function () {
    $("#btnGuardar_descripcion").removeClass('d-none');
});

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
