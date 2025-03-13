function init() {
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
                $("#precio").val(producto.precio);
                $("#unidades").val(producto.unidades);
                $("#modelo").val(producto.modelo);
                $("#marca").val(producto.marca);
                $("#detalles").val(producto.detalles);
                $("#imagen").val(producto.imagen);
                $("#productId").val(producto.id); // Guardar el ID del producto en un campo oculto

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

// Validar campos en tiempo real
$("#name, #precio, #unidades, #modelo, #marca, #detalles, #imagen").on("blur", function () {
    validarCampo($(this));
});

// Función para validar un campo
function validarCampo(campo) {
    const valor = campo.val().trim();
    const id = campo.attr("id");
    const status = $(`#${id}-status`);

    if (valor === "") {
        status.text("Este campo es obligatorio.").removeClass("text-success").addClass("text-danger");
        campo.addClass("is-invalid");
        return false;
    }

    // Validaciones específicas para cada campo
    switch (id) {
        case "precio":
            if (isNaN(valor) || parseFloat(valor) < 1) {
                status.text("El precio debe ser mayor o igual a 1.").removeClass("text-success").addClass("text-danger");
                campo.addClass("is-invalid");
                return false;
            }
            break;
        case "name":
            validarNombreAsincrono(valor, campo, status);
            return; // La validación asíncrona se maneja por separado
    }

    status.text("Datos válidos.").removeClass("text-danger").addClass("text-success");
    campo.removeClass("is-invalid");
    return true;
}

// Validar nombre asíncrono
function validarNombreAsincrono(nombre, campo, status) {
    if (nombre === "") {
        status.text("Este campo es obligatorio.").removeClass("text-success").addClass("text-danger");
        campo.addClass("is-invalid");
        return;
    }

    $.ajax({
        url: './backend/product-validate-name.php',
        type: 'GET',
        data: { nombre: nombre },
        dataType: 'json',
        success: function (respuesta) {
            if (respuesta.existe) {
                status.text("El nombre ya existe.").removeClass("text-success").addClass("text-danger");
                campo.addClass("is-invalid");
            } else {
                status.text("Datos válidos.").removeClass("text-danger").addClass("text-success");
                campo.removeClass("is-invalid");
            }
        },
        error: function (xhr, status, error) {
            console.error("Error en la validación del nombre:", error);
        }
    });
}

// Validar formulario antes de enviar
$("#product-form").on("submit", function (e) {
    e.preventDefault();

    let valido = true;
    $("#name, #precio, #unidades, #modelo, #marca, #detalles, #imagen").each(function () {
        if (!validarCampo($(this))) {
            valido = false;
        }
    });

    if (!valido) {
        alert("Por favor, corrige los errores en el formulario.");
        return;
    }

    const producto = {
        nombre: $("#name").val().trim(),
        precio: parseFloat($("#precio").val()),
        unidades: parseInt($("#unidades").val()),
        modelo: $("#modelo").val().trim(),
        marca: $("#marca").val().trim(),
        detalles: $("#detalles").val().trim(),
        imagen: $("#imagen").val().trim()
    };

    const id = $("#productId").val();
    const url = id ? './backend/product-update.php' : './backend/product-add.php';
    const method = id ? 'PUT' : 'POST';

    if (id) {
        producto.id = id;
    }

    $.ajax({
        url: url,
        type: method,
        contentType: 'application/json',
        data: JSON.stringify(producto),
        dataType: 'json',
        success: function (respuesta) {
            if (respuesta.status === "success") {
                alert(respuesta.message);
                listarProductos();
                limpiarFormulario();
            } else {
                alert("Error: " + respuesta.message);
            }
        },
        error: function (xhr, status, error) {
            alert("Error en la solicitud: " + error);
        }
    });
});

// Limpiar formulario
function limpiarFormulario() {
    $("#product-form")[0].reset();
    $("#productId").val("");
    $("#product-form button").text("Agregar Producto");
    $("#name-status, #precio-status, #unidades-status, #modelo-status, #marca-status, #detalles-status, #imagen-status").text("").removeClass("text-success text-danger");
    $("#name").removeClass("is-invalid");
}

// Inicializar la página
$(document).ready(init);
