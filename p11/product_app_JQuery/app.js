// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

function init() {
    // Convierte el JSON a string para mostrarlo en el <textarea>
    var JsonString = JSON.stringify(baseJSON, null, 2);
    $("#description").val(JsonString);

    // Cargar lista de productos al iniciar
    listarProductos();
}

// Cargar lista de productos NO eliminados
function listarProductos() {
    $.ajax({
        url: './backend/product-list.php',
        type: 'GET',
        dataType: 'json',
        success: function (productos) {
            let template = '';
            productos.forEach(producto => {
                let descripcion = `
                    <li>precio: ${producto.precio}</li>
                    <li>unidades: ${producto.unidades}</li>
                    <li>modelo: ${producto.modelo}</li>
                    <li>marca: ${producto.marca}</li>
                    <li>detalles: ${producto.detalles}</li>`;
                
                template += `
                    <tr productId="${producto.id}">
                        <td>${producto.id}</td>
                        <td>${producto.nombre}</td>
                        <td><ul>${descripcion}</ul></td>
                        <td>
                            <button class="product-edit btn btn-warning">
                                Modificar
                            </button>
                            <button class="product-delete btn btn-danger">
                                Eliminar
                            </button>
                        </td>
                    </tr>`;
            });
            $("#products").html(template);
        }
    });
}

// Buscar productos según lo tecleado
$("#search").on("keyup", function () {
    const search = $(this).val();
    $.ajax({
        url: './backend/product-search.php',
        type: 'GET',
        data: { search: search },
        dataType: 'json',
        success: function (productos) {
            let template = '';
            let template_bar = '';
            productos.forEach(producto => {
                let descripcion = `
                    <li>precio: ${producto.precio}</li>
                    <li>unidades: ${producto.unidades}</li>
                    <li>modelo: ${producto.modelo}</li>
                    <li>marca: ${producto.marca}</li>
                    <li>detalles: ${producto.detalles}</li>`;
                
                template += `
                    <tr productId="${producto.id}">
                        <td>${producto.id}</td>
                        <td>${producto.nombre}</td>
                        <td><ul>${descripcion}</ul></td>
                        <td>
                            <button class="product-edit btn btn-warning">
                                Modificar
                            </button>
                            <button class="product-delete btn btn-danger">
                                Eliminar
                            </button>
                        </td>
                    </tr>`;
                template_bar += `<li>${producto.nombre}</li>`;
            });
            $("#products").html(template);
            $("#container").html(template_bar);
            $("#product-result").addClass("d-block");
        }
    });
});

// Cargar datos del producto en el formulario para modificar
$(document).on("click", ".product-edit", function () {
    const id = $(this).closest("tr").attr("productId");

    $.ajax({
        url: './backend/product-get.php',
        type: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function (respuesta) {
            if (respuesta.status === "success") {
                const producto = respuesta.data;

                // Llenar el formulario con los datos del producto
                $("#name").val(producto.nombre);
                $("#productId").val(producto.id); // Guardar el ID del producto en un campo oculto

                // Crear el JSON para el textarea
                const productoJSON = {
                    precio: producto.precio,
                    unidades: producto.unidades,
                    modelo: producto.modelo,
                    marca: producto.marca,
                    detalles: producto.detalles,
                    imagen: producto.imagen
                };
                $("#description").val(JSON.stringify(productoJSON, null, 2));

                // Cambiar el texto del botón a "Guardar Cambios"
                $("#product-form button").text("Guardar Cambios");
            } else {
                alert("Error: " + respuesta.message);
            }
        },
        error: function (xhr, status, error) {
            alert("Error al cargar el producto: " + error);
        }
    });
});

// Agregar o actualizar producto
$("#product-form").on("submit", function (e) {
    e.preventDefault();

    // Obtener los valores del formulario
    const nombre = $("#name").val();
    const productoJsonString = $("#description").val();
    const id = $("#productId").val(); // Obtener el ID del producto (si existe)

    // Validar que los campos no estén vacíos
    if (!nombre || !productoJsonString) {
        alert("Por favor, completa todos los campos.");
        return;
    }

    // Convertir el JSON del textarea a un objeto
    let finalJSON;
    try {
        finalJSON = JSON.parse(productoJsonString);
    } catch (error) {
        alert("El formato del JSON no es válido. Por favor, verifica la estructura.");
        return;
    }

    // Agregar el nombre al JSON
    finalJSON['nombre'] = nombre;

    // Determinar si es una actualización o una creación
    const url = id ? './backend/product-update.php' : './backend/product-add.php';
    const method = id ? 'PUT' : 'POST';

    // Agregar el ID al JSON si es una actualización
    if (id) {
        finalJSON['id'] = id;
    }

    // Enviar la solicitud al backend
    $.ajax({
        url: url,
        type: method,
        contentType: 'application/json',
        data: JSON.stringify(finalJSON),
        dataType: 'json',
        success: function (respuesta) {
            // Mostrar mensaje de éxito o error
            if (respuesta.status === "success") {
                alert(respuesta.message);
            } else {
                alert("Error: " + respuesta.message);
            }

            // Actualizar la lista de productos
            listarProductos();

            // Limpiar el formulario
            limpiarFormulario();
        },
        error: function (xhr, status, error) {
            alert("Error en la solicitud: " + error);
        }
    });
});

// Eliminar producto
$(document).on("click", ".product-delete", function () {
    if (confirm("¿De verdad deseas eliminar el Producto?")) {
        const id = $(this).closest("tr").attr("productId");
        $.ajax({
            url: './backend/product-delete.php',
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function (respuesta) {
                const template_bar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>`;
                $("#container").html(template_bar);
                $("#product-result").addClass("d-block");
                listarProductos();
            }
        });
    }
});

// Limpiar el formulario
function limpiarFormulario() {
    $("#name").val("");
    $("#description").val(JSON.stringify(baseJSON, null, 2)); // Restaurar el JSON base
    $("#productId").val(""); // Limpiar el ID del producto
    $("#product-form button").text("Agregar Producto"); // Restaurar el texto del botón
}

// Inicializar la página
$(document).ready(init);