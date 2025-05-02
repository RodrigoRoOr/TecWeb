let edit = false;

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    document.getElementById("price").value = 0.0;
    document.getElementById("units").value = 0;
    document.getElementById("model").value = "NA";
    document.getElementById("brand").value = "NA";
    document.getElementById("image").value = "img/default.png";
    fetchProducts();
}

$(document).ready(function(){
    $('#product-result').hide();

    // Validar el campo de nombre al escribir
    $('#name').keyup(function (e) {
        if ($('#name').val()) {
            let name = $('#name').val();
            $.ajax({
                url: 'http://localhost/tecweb/Practica1/Act/a03/product_app/Backend/product/checkname/' + encodeURIComponent(name),
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (response.existe) {
                        $('#name-error').text("Este nombre de producto ya existe.").show();
                    } else {
                        $('#name-error').text("").hide();
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                    $('#name-error').text("Error al verificar el nombre").show();
                }
            });
        } else {
            $('#name-error').text("").hide();
        }
    });
    
    //Busqueda de productos) **
    $('#search').keyup(function(e) {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: 'http://localhost/tecweb/Practica1/Act/a03/product_app/Backend/products/' + encodeURIComponent(search),
                type: 'GET',
                dataType: 'json',
                success: function(products) {
                    let template = '';
                    let template_dec = '';
                    
                    products.forEach(product => {
                        // Lista de nombres en el cuadro blanco
                        template += `<li>${product.nombre}</li>`;
                        
                        // Filas de la tabla
                        let descripcion = `
                            <li>Precio: ${product.precio}</li>
                            <li>Unidades: ${product.unidades}</li>
                            <li>Modelo: ${product.modelo}</li>
                            <li>Marca: ${product.marca}</li>
                            <li>Detalles: ${product.detalles}</li>
                        `;
    
                        template_dec += `
                            <tr productId="${product.id}">
                                <td>${product.id}</td>
                                <td>${product.nombre}</td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    
                    $('#container').html(template);
                    $('#products').html(template_dec);
                    $('#product-result').show();
                },
                error: function(xhr, status, error) {
                    console.error("Error en la búsqueda:", error);
                    $('#container').html('<li>Error en la búsqueda</li>');
                    $('#products').html('<tr><td colspan="4">No se encontraron resultados</td></tr>');
                }
            });
        } else {
            // Si el campo está vacío, recargar todos los productos
            fetchProducts();
            $('#product-result').hide();
        }
    });

    // Envío del formulario
    $('#product-form').submit(function (e) {
        e.preventDefault();
    
        // Obtener el ID del producto (si está en modo edición)
        let id = $('#productId').val();
    
        // Crear el objeto JSON con los valores de los campos
        let baseJSON = {
            "precio": parseFloat($('#price').val()),
            "unidades": parseInt($('#units').val()),
            "modelo": $('#model').val(),
            "marca": $('#brand').val(),
            "detalles": $('#details').val() || "NA",
            "imagen": $('#image').val()
        };
    
        // Agregar el nombre al JSON
        baseJSON['nombre'] = $('#name').val();
    
        // Añadir ID al JSON si está en modo edición
        if (edit) {
            baseJSON['id'] = id;
        }
    
        // Reduccion de lineas
        let errores = [];
        if (!baseJSON.nombre) errores.push("No hay nombre de producto");
        if (baseJSON.nombre.length > 100) errores.push("El nombre del producto no puede ser mayor a 100 caracteres");
        if (!baseJSON.marca) errores.push("No hay marca de producto");
        if (!baseJSON.modelo) errores.push("No hay modelo de producto");
        if (baseJSON.modelo.length > 25) errores.push("El modelo no puede ser mayor a 25 caracteres");
        if (!baseJSON.precio) errores.push("No hay precio de producto");
        if (baseJSON.precio <= 99.99) errores.push("El precio no puede ser menor a 99.99");
        if (baseJSON.detalles.length > 250) errores.push("Los detalles no pueden ser mayor a 250 caracteres");
        if (!baseJSON.unidades) errores.push("No hay unidades de producto");
        if (baseJSON.unidades < 0) errores.push("Las unidades no pueden ser menores a 0");
        if (isNaN(baseJSON.precio)) errores.push("El precio no es un número");
        if (baseJSON.imagen == "") baseJSON.imagen = "img/default.jpg";
    
        if (errores.length > 0) {
            alert("Errores en el formulario:\n\n" + errores.join("\n"));
            return;
        }
    
        $('button.btn-primary').text(edit ? "Modificar Producto" : "Agregar Producto");
    
        let method = edit ? 'PUT' : 'POST';
        let url = 'http://localhost/tecweb/Practica1/Act/a03/product_app/Backend/product';
    
        $.ajax({
            url: url,
            type: method,
            contentType: 'application/json',
            data: JSON.stringify(baseJSON),
            dataType: 'json',
            success: function (response) {
                console.log("Respuesta del servidor:", response);
                
                let template_bar = `
                    <li style="list-style: none;">status: ${response.status}</li>
                    <li style="list-style: none;">message: ${response.message}</li>
                `;
                $("#product-result").addClass("card my-4 d-block");
                $("#container").html(template_bar);
                fetchProducts();
                edit = false;
                $('#product-form')[0].reset();
            },
            error: function (xhr, status, error) {
                console.error("Error en la solicitud AJAX:", status, error);
                alert("Error al procesar la solicitud. Ver consola para detalles.");
            }
        });
    });
});

//listar productos **
function fetchProducts() {
    $.get("http://localhost/tecweb/Practica1/Act/a03/product_app/Backend/products", function(data) {
        console.log("Tipo de dato recibido:", typeof data);
        console.log("Respuesta del servidor:", data);
        
        try {
            // Verifica si ya es un objeto (depende de la configuración de jQuery)
            let productos = typeof data === 'string' ? JSON.parse(data) : data;
            
            let template = "";
            
            // Corregido: products -> productos (consistencia en el nombre)
            productos.forEach(producto => {
                let descripcion = `
                    <li>Precio: ${producto.precio}</li>
                    <li>Unidades: ${producto.unidades}</li>
                    <li>Modelo: ${producto.modelo}</li>
                    <li>Marca: ${producto.marca}</li>
                    <li>Detalles: ${producto.detalles}</li>
                `;
                
                template += `
                    <tr productId="${producto.id}">
                        <td>${producto.id}</td>
                        <td>
                            <a href="#" class="product-item">${producto.nombre}</a>
                        </td>
                        <td><ul>${descripcion}</ul></td>
                        <td>
                            <button class="product-delete btn btn-danger">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                `;
            });
            
            $("#products").html(template);
        } catch (error) {
            console.error("Error al procesar los productos:", error);
            $("#products").html('<tr><td colspan="4">Error al cargar los productos</td></tr>');
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
        $("#products").html('<tr><td colspan="4">No se pudieron cargar los productos</td></tr>');
    });

    //se elimina el producto **
    $(document).on('click', '.product-delete', function() {
        if (confirm('¿Quieres eliminarlo?')) {
            let element = $(this).closest('tr');
            let id = $(element).attr('productId');
    
            $.ajax({
                url: 'http://localhost/tecweb/Practica1/Act/a03/product_app/Backend/product',
                type: 'DELETE',
                data: { id: id },
                dataType: 'json',
                success: function(response) {
                    if (response && response.status === 'success') {
                        fetchProducts(); // Recarga la lista
                        alert('Producto eliminado correctamente');
                    } else {
                        alert('Error al eliminar: ' + (response?.message || 'Respuesta inválida'));
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error en la conexión: ' + error);
                    console.error("Detalles:", xhr.responseText);
                }
            });
        }
    });

    

    // Obtener el producto para editar **
    $(document).on('click', '.product-item', function() {
        let element = $(this).closest('tr');
        let id = $(element).attr('productId');
        $('button.btn-primary').text("Modificar Producto");
        
        $.ajax({
            url: 'http://localhost/tecweb/Practica1/Act/a03/product_app/Backend/product/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(product) {
                if (product && Object.keys(product).length > 0) {
                    $('#name').val(product.nombre);
                    $('#price').val(product.precio);
                    $('#units').val(product.unidades);
                    $('#model').val(product.modelo);
                    $('#brand').val(product.marca);
                    $('#details').val(product.detalles);
                    $('#image').val(product.imagenes);
                    $('#productId').val(product.id);
                    edit = true;
                } else {
                    alert("Producto no encontrado");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al obtener el producto:", error);
                alert("Ocurrió un error al cargar el producto");
            }
        });
    });

    $("#name").on("blur", validateName);
    $("#price").on("blur", validatePrice);
    $("#units").on("blur", validateUnits);
    $("#model").on("blur", validateModel);
    $("#brand").on("blur", validateBrand);
    $("#details").on("blur",validateDetail)

    function validateName() {
        const name = $("#name").val();
        const errorElement = $("#name-error");
        if (!name) {
            errorElement.text("No hay nombre producto").show();
            return false;
        } else if (name.length > 100) {
            errorElement.text("El nombre no puede tener más de 100 caracteres.").show();
            return false;
        } else {
            errorElement.text("").hide();
            return true;
        }
    }

    function validatePrice() {
        const price = parseFloat($("#price").val());
        const errorElement = $("#price-error");
        if (isNaN(price)) {
            errorElement.text("El precio debe ser un número.").show();
            return false;
        } else if (price <= 99.99) {
            errorElement.text("El precio no puede ser menor a 99.99.").show();
            return false;
        } else if(!price){
            errorElement.text("No hay precio de producto").show();
        } else {
            errorElement.text("").hide();
            return true;
        }
    }

    function validateUnits() {
        const units = parseInt($("#units").val());
        const errorElement = $("#units-error");
        if (isNaN(units)) {
            errorElement.text("Las unidades deben ser un número.").show();
            return false;
        } else if (units < 0) {
            errorElement.text("Las unidades no pueden ser menores a 0.").show();
            return false;
        } else {
            errorElement.text("").hide();
            return true;
        }
    }

    function validateModel(){
        const model = $("#model").val();
        const errorElement = $("#model-error");
        if(!model){
            errorElement.text("No hay modelo de producto").show();
            return false;
        } else if (model.length > 25 ){
            errorElement.text("El modelo no puede ser mayor a 25 caracteres").show();
            return false;
        } else {
            errorElement.text("").hide();
            return true;
        }
    }

    function validateBrand(){
        const brand = $("#brand").val();
        const errorElement = $("#brand-error");
        if(!brand){
            errorElement.text("No hay marca del producto").show();
            return false;
        } else if (brand.length > 25 ){
            errorElement.text("El modelo no puede ser mayor a 25 caracteres").show();
            return false;
        } else {
            errorElement.text("").hide();
            return true;
        }
    }

    function validateDetail(){
        const details = $("#details").val();
        const errorElement = $("#details-error");
        if(details.length > 250){
            errorElement.text("Los detalles no pueden ser mayor a 250 caracteres").show();
            return false;
        } else {
            errorElement.text("").hide();
            return true;
        }
    }
}
