// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

let edit = false;

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
    fetchProducts();
}

//Funcion de busqueda de productos
$(document).ready(function(){
    $('#product-result').hide();

    $('#search').keyup(function(e) {
        if($('#search').val()){
            let search = $('#search').val();
            $.ajax({
                url: 'backend/product-search.php?search='+search,
                type: 'GET',
                dataType: 'json', // Asegura que jQuery parseé la respuesta como JSON
                success: function(response) {
                    // response ya es un objeto JavaScript, no necesitas parsearlo
                    let template = '';
                    let tmeplate_dec = '';
                    
                    // Verifica si response es un array
                    if(Array.isArray(response)) {
                        response.forEach(product => {
                    let descripcion = '';
                    descripcion += '<li>precio: '+product.precio+'</li>';
                    descripcion += '<li>unidades: '+product.unidades+'</li>';
                    descripcion += '<li>modelo: '+product.modelo+'</li>';
                    descripcion += '<li>marca: '+product.marca+'</li>';
                    descripcion += '<li>detalles: '+product.detalles+'</li>';

                    tmeplate_dec += `
                        <tr productId="${product.id}">
                            <td>${product.id}</td>
                            <td>${product.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger" onclick="eliminarProducto()">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;

                    template += `<li>${product.nombre}</li>`
                });
            } else {
                console.error("La respuesta no es un array:", response);
            }
            
            $('#container').html(template);
            $('#products').html(tmeplate_dec);
            $('#product-result').show();
        },
        error: function(xhr, status, error) {
            console.error("Error en la búsqueda:", error);
        }
    });
}
else {
    fetchProducts();
    $('#product-result').hide();
}
});

    $('#product-form').submit(function(e) {
        e.preventDefault();
        let id = $('#productId').val()
        let productoJsonString = $('#description').val();
        let finalJSON;

        try {
            finalJSON = JSON.parse(productoJsonString);
            finalJSON['nombre'] = $('#name').val();
            productoJsonString = JSON.stringify(finalJSON, null, 2);
            // ******************************************************
            // AQUÍ AGREGAS LAS VALIDACIONES DE LOS DATOS EN EL JSON
            // ******************************************************
            let errores = [];

            if (!finalJSON.nombre) {
                errores.push("No hay nombre producto");
            }
            if(!finalJSON.nombre.length > 100){
                errores.push("El nombre del producto no puede ser mayor a 100 caracteres");
            }
            if (!finalJSON.marca) {
                errores.push("No hay marca de producto");
            }
            if(!finalJSON.modelo){
                errores.push("No hay modelo de producto");
            }
            if(!finalJSON.modelo.length > 25){
                errores.push("El modelo no puede ser mayor a 25 caracteres");
            }
            if(!finalJSON.precio){
                errores.push("No hay precio de producto");
            }
            if(!finalJSON.precio > 99.99){
                errores.push("El precio no puede ser menor a 99.99");
            }
            if(finalJSON.detalles.length > 250){
                errores.push("Los detalles no pueden ser mayor a 250 caracteres");
            }
            if(!finalJSON.unidades){
                errores.push("No hay unidades de producto");
            }
            if(!finalJSON.unidades > 0){
                errores.push("Las unidades no pueden ser menores a 0");
            }
            if(isNaN(finalJSON.precio)){
                errores.push("El precio no es un número");
            }
            if(finalJSON.imagen == ""){
                finalJSON.imagen = "img/default.jpg";
            }

            // ******************************************************
            // --> EN CASO DE NO HABER ERRORES, SE ENVÍA EL PRODUCTO A AGREGAR
            // ******************************************************

            if (errores.length > 0) {
                // Mostrar todos los errores en una alerta
                alert("Errores en el formulario:\n\n" + errores.join("\n"));
                return; // Detiene el envío si hay errores
            }

            // ******************************************************
            // --> EN CASO DE NO HABER ERRORES, SE ENVÍA EL PRODUCTO A AGREGAR
            // ******************************************************


            // Envío con POST y JSON en el cuerpo
            let url = edit === false ? 'product-add.php' : 'product-update.php';
            $.ajax({
                url: 'backend/' + url + '?id=' + id,
                type: 'POST', // Usamos POST
                contentType: 'application/json; charset=UTF-8', // Indicamos que enviamos JSON
                data: productoJsonString, // Enviamos el JSON como cadena en el cuerpo
                success: function(response) {
                    console.log(response);
                    // Ya no es necesario hacer JSON.parse(response), ya que la respuesta es un objeto
                    let respuesta = response; // El servidor debe devolver un objeto
                    let template_bar = `
                        <li style="list-style: none;">status: ${respuesta.status}</li>
                        <li style="list-style: none;">message: ${respuesta.message}</li>
                    `;
                    $("#product-result").addClass("card my-4 d-block");
                    $("#container").html(template_bar);
                    fetchProducts();
                    edit = false;
                },
                error: function(status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                }
            });
    
        } 
        catch (error) {
            console.error("Error al analizar el JSON:", error);
        }
    });
});

function fetchProducts() {
    $.ajax({
        url: 'backend/product-list.php',
        type: 'GET',
        dataType: 'json', // Asegura que jQuery parseé la respuesta como JSON
        success: function(response) {
            // response ya es un objeto/array JavaScript
            let template = '';
            
            if(Array.isArray(response)) {
                response.forEach(product => {
            let descripcion = `
                <li>precio: ${product.precio}</li>
                <li>unidades: ${product.unidades}</li>
                <li>modelo: ${product.modelo}</li>
                <li>marca: ${product.marca}</li>
                <li>detalles: ${product.detalles}</li>
            `;
            template += `
                <tr productId="${product.id}">
                    <td>${product.id}</td>
                    <td>
                        <a href="#" class="product-item">${product.nombre}</a>
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
    } else {
        console.error("La respuesta no es un array:", response);
    }
    
    $('#products').html(template);
},
error: function(xhr, status, error) {
    console.error("Error al obtener productos:", error);
}
});
    $(document).on('click','.product-delete',function(){
        if(confirm('Quieres eliminarlo?')){
            let element = $(this)[0].parentElement.parentElement;
            let id = $(element).attr('productId')
            $.get('backend/product-delete.php',{id:id},function(response){
                fetchProducts();
            })
        }
    })

    $(document).on('click', '.product-item', function () { 
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('productId');
    
        $.post('backend/product-get.php', { id }, function (response) {
            edit = true;
    
            console.log("Respuesta del servidor:", response); // Verifica el formato de la respuesta
    
            const product = response; // ✅ No necesitamos JSON.parse() si la respuesta ya es un objeto
    
            $('#name').val(product.nombre);
    
            var baseJSON = {
                "precio": product.precio,
                "unidades": product.unidades,
                "modelo": product.modelo,
                "marca": product.marca,
                "detalles": product.detalles,
                "imagen": product.imagen
            };
    
            $('#productId').val(product.id);
            var JsonString = JSON.stringify(baseJSON, null, 2);
            document.getElementById("description").value = JsonString;
        });
    });

}