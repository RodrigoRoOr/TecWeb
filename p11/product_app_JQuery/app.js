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

// Agregar producto
$("#product-form").on("submit", function (e) {
    e.preventDefault();

    // Obtener los valores del formulario
    const nombre = $("#name").val();
    const productoJsonString = $("#description").val();

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

    // Enviar la solicitud al backend
    $.ajax({
        url: './backend/product-add.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(finalJSON),
        dataType: 'json',
        success: function (respuesta) {
            // Mostrar mensaje de éxito o error
            if (respuesta.status === "success") {
                alert("Producto agregado exitosamente.");
            } else if (respuesta.message === "El producto ya existe.") {
                alert("El producto ya existe.");
            } else {
                alert("Error al agregar el producto: " + respuesta.message);
            }

            // Actualizar la lista de productos
            listarProductos();
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

// Inicializar la página
$(document).ready(init);
