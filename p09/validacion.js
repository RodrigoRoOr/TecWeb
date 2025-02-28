document.getElementById("formularioProductos").addEventListener("submit", function(event) {
    let nombre = document.getElementById("nombre").value.trim();
    let marca = document.getElementById("marca").value;
    let modelo = document.getElementById("modelo").value.trim();
    let precio = parseFloat(document.getElementById("precio").value);
    let detalles = document.getElementById("detalles").value.trim();
    let unidades = parseInt(document.getElementById("unidades").value, 10);
    let imagen = document.getElementById("imagen").value.trim();

    if (!nombre || nombre.length > 100) {
        alert("El nombre es obligatorio y debe tener 100 caracteres o menos.");
        event.preventDefault();
        return;
    }

    if (!marca) {
        alert("Debe seleccionar una marca.");
        event.preventDefault();
        return;
    }

    if (!modelo || modelo.length > 25 || !/^[a-zA-Z0-9]+$/.test(modelo)) {
        alert("El modelo es obligatorio, alfanumérico y de máximo 25 caracteres.");
        event.preventDefault();
        return;
    }

    if (isNaN(precio) || precio <= 0.99) {
        alert("El precio es obligatorio y debe ser mayor a 99.99.");
        event.preventDefault();
        return;
    }

    if (detalles.length > 250) {
        alert("Los detalles deben tener 250 caracteres o menos.");
        event.preventDefault();
        return;
    }

    if (isNaN(unidades) || unidades < 1) {
        alert("Las unidades deben ser un número mayor a 0.");
        event.preventDefault();
        return;
    }

    if (!imagen) {
        document.getElementById("imagen").value = "imagenes/default.png";
    }
});
