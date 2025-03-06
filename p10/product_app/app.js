// JSON BASE A MOSTRAR EN FORMULARIO
const baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png",
    "eliminado": 0
};

// FUNCIÓN PARA BUSCAR POR ID
function buscarPorID(event) {
    event.preventDefault();
    const id = document.getElementById('search').value;

    fetchData('./backend/read.php', 'POST', `id=${id}`, mostrarProducto);
}

// FUNCIÓN PARA BUSCAR POR NOMBRE O PALABRA CLAVE
function buscarPorNombre(event) {
    event.preventDefault();
    const palabra = document.getElementById('searchPro').value;

    fetchData('./backend/read.php', 'POST', `id=${palabra}`, mostrarProductos);
}

// FUNCIÓN PARA AGREGAR PRODUCTO
function agregarProducto(event) {
    event.preventDefault();
    const nombre = document.getElementById('name').value;
    const productoJsonString = document.getElementById('description').value;
    const finalJSON = JSON.parse(productoJsonString);
    finalJSON['nombre'] = nombre;

    const errores = validarDatos(nombre, finalJSON);
    if (errores.length > 0) {
        alert(errores.join("\n"));
        return;
    }

    fetchData('./backend/create.php', 'POST', JSON.stringify(finalJSON), mostrarRespuesta);
}

// FUNCIÓN PARA VALIDAR DATOS
function validarDatos(nombre, finalJSON) {
    const errores = [];
    if (nombre.length > 100 || nombre === "") {
        errores.push("El nombre está vacío o es muy largo");
    }
    if (finalJSON.marca === "") {
        errores.push("La marca está vacía");
    }
    if (finalJSON.modelo === "" || finalJSON.modelo.length > 25) {
        errores.push("El modelo está vacío o es muy largo");
    }
    if (finalJSON.precio === "" || isNaN(finalJSON.precio) || parseFloat(finalJSON.precio) < 99.99) {
        errores.push("El precio está vacío, no es un número o es menor a 99.99");
    }
    if (finalJSON.detalles.length > 250) {
        errores.push("Los detalles son muy largos");
    }
    if (finalJSON.unidades === "" || isNaN(finalJSON.unidades) || parseInt(finalJSON.unidades) < 0) {
        errores.push("Las unidades están vacías, no es un número o es menor a 0");
    }
    if (finalJSON.imagen === "") {
        finalJSON.imagen = "img/default.jpg";
    }
    return errores;
}

// FUNCIÓN GENÉRICA PARA HACER PETICIONES FETCH
function fetchData(url, method, body, callback) {
    const xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            callback(xhr.responseText);
        }
    };
    xhr.send(body);
}

// FUNCIÓN PARA MOSTRAR UN PRODUCTO
function mostrarProducto(response) {
    const productos = JSON.parse(response);
    if (Object.keys(productos).length > 0) {
        const descripcion = `
            <li>precio: ${productos.precio}</li>
            <li>unidades: ${productos.unidades}</li>
            <li>modelo: ${productos.modelo}</li>
            <li>marca: ${productos.marca}</li>
            <li>detalles: ${productos.detalles}</li>
        `;
        const template = `
            <tr>
                <td>${productos.id}</td>
                <td>${productos.nombre}</td>
                <td><ul>${descripcion}</ul></td>
            </tr>
        `;
        document.getElementById("productos").innerHTML = template;
    }
}

// FUNCIÓN PARA MOSTRAR VARIOS PRODUCTOS
function mostrarProductos(response) {
    const productos = JSON.parse(response);
    if (productos && productos.length > 0) {
        let template = '';
        productos.forEach(producto => {
            const descripcion = `
                <li>precio: ${producto.precio}</li>
                <li>unidades: ${producto.unidades}</li>
                <li>modelo: ${producto.modelo}</li>
                <li>marca: ${producto.marca}</li>
                <li>detalles: ${producto.detalles}</li>
            `;
            template += `
                <tr>
                    <td>${producto.id}</td>
                    <td>${producto.nombre}</td>
                    <td><ul>${descripcion}</ul></td>
                </tr>
            `;
        });
        document.getElementById("productos").innerHTML = template;
    }
}

// FUNCIÓN PARA MOSTRAR RESPUESTA DEL SERVIDOR
function mostrarRespuesta(response) {
    try {
        const respuesta = JSON.parse(response);
        alert(respuesta.message);
    } catch (e) {
        alert("Error en la respuesta del servidor");
        console.error("Error al parsear JSON:", e);
    }
}

// INICIALIZACIÓN
function init() {
    document.getElementById("description").value = JSON.stringify(baseJSON, null, 2);
}