<?php
header("Content-Type: text/html; charset=utf-8");

$link = new mysqli('localhost', 'root', 'password', 'marketzone');

if ($link->connect_errno) {
    die('<p>Error de conexión: ' . htmlspecialchars($link->connect_error) . '</p>');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $precio = floatval($_POST['precio']);
    $unidades = intval($_POST['unidades']);
    $detalles = $_POST['detalles'];
    $imagen = isset($_POST['imagen']) && trim($_POST['imagen']) !== '' ? $_POST['imagen'] : 'img/imagen.png';

    $stmt = $link->prepare("UPDATE productos SET nombre=?, marca=?, modelo=?, precio=?, unidades=?, detalles=?, imagen=? WHERE id=?");
    $stmt->bind_param("sssdisii", $nombre, $marca, $modelo, $precio, $unidades, $detalles, $imagen, $id);
    
    if ($stmt->execute()) {
        echo "<h1>Cambios realizados</h1>";
        echo "<p><a href='./get_productos_xhtml_v2.php?tope=999'>Ir a get_productos_xhtml 1</a></p>";
        echo "<p><a href='./get_productos_vigentes_v2.php?tope=999'>Ir a get_productos_vigentes 2</a></p>";
    } else {
        echo "<p>Error al actualizar el producto.</p>";
    }
    $stmt->close();
    $link->close();
    exit;
}

if (!isset($_GET['id']) || !preg_match('/^\d+$/', $_GET['id'])) {
    die('<p>Error: ID de producto inválido.</p>');
}

$id = intval($_GET['id']);
$stmt = $link->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('<p>Error: Producto no encontrado.</p>');
}

$producto = $result->fetch_assoc();
$stmt->close();
$link->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
</head>
<body>
    <div class="container">
        <h3>Modificar Producto</h3>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($producto['id']); ?>" />
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required />
            </div>
            <div class="form-group">
                <label>Marca:</label>
                <input type="text" name="marca" class="form-control" value="<?php echo htmlspecialchars($producto['marca']); ?>" required />
            </div>
            <div class="form-group">
                <label>Modelo:</label>
                <input type="text" name="modelo" class="form-control" value="<?php echo htmlspecialchars($producto['modelo']); ?>" required />
            </div>
            <div class="form-group">
                <label>Precio:</label>
                <input type="number" step="0.01" name="precio" class="form-control" value="<?php echo htmlspecialchars($producto['precio']); ?>" required />
            </div>
            <div class="form-group">
                <label>Unidades:</label>
                <input type="number" name="unidades" class="form-control" value="<?php echo htmlspecialchars($producto['unidades']); ?>" required />
            </div>
            <div class="form-group">
                <label>Detalles:</label>
                <textarea name="detalles" class="form-control" required><?php echo htmlspecialchars($producto['detalles']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Imagen (URL):</label>
                <input type="text" name="imagen" class="form-control" value="<?php echo htmlspecialchars($producto['imagen'] ?: 'img/imagen.png'); ?>" required />
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="./get_productos_xhtml_v2.php?tope=999" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
