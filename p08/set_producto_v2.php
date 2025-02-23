<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $marca = trim($_POST['marca']);
    $modelo = trim($_POST['modelo']);
    $precio = floatval($_POST['precio']);
    $detalles = trim($_POST['detalles']);
    $unidades = intval($_POST['unidades']);

    if (empty($nombre) || empty($marca) || empty($modelo) || $precio <= 0 || empty($detalles) || $unidades < 1) {
        die("<html><body><h3>Error: Todos los campos son obligatorios y deben contener valores válidos.</h3></body></html>");
    }

    $mysqli = new mysqli("localhost", "root", "password", "marketzone");

    if ($mysqli->connect_error) {
        die("<html><body><h3>Error de conexión: " . $mysqli->connect_error . "</h3></body></html>");
    }

    // Verificar si el producto ya existe
    $stmt_check = $mysqli->prepare("SELECT id FROM productos WHERE nombre = ? AND marca = ? AND modelo = ?");
    $stmt_check->bind_param("sss", $nombre, $marca, $modelo);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        die("<html><body><h3>Error: El producto ya existe en la base de datos.</h3></body></html>");
    }
    $stmt_check->close();

    // Insertar el producto si no existe 
    $stmt = $mysqli->prepare("INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, eliminado) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdsd", $nombre, $marca, $modelo, $precio, $detalles, $unidades);

    if ($stmt->execute()) {
        echo "<html><body><h3>Producto registrado con éxito.</h3>";
        echo "<p><strong>Nombre:</strong> $nombre</p>";
        echo "<p><strong>Marca:</strong> $marca</p>";
        echo "<p><strong>Modelo:</strong> $modelo</p>";
        echo "<p><strong>Precio:</strong> $precio</p>";
        echo "<p><strong>Detalles:</strong> $detalles</p>";
        echo "<p><strong>Unidades:</strong> $unidades</p>";
        echo "</body></html>";
    } else {
        echo "<html><body><h3>Error al registrar el producto: " . $stmt->error . "</h3></body></html>";
    }

    $stmt->close();
    $mysqli->close();
} else {
    echo "<html><body><h3>Acceso no permitido.</h3></body></html>";
}
?>
