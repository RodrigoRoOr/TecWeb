<?php
header("Content-Type: application/xhtml+xml; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
    <title>Productos Disponibles</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
</head>
<body>
    <h3>Lista de Productos</h3>
    <br/>
    <?php
    if (!isset($_GET['tope']) || !preg_match('/^\d+$/', $_GET['tope'])) {
        echo '<p>Error: Parámetro "tope" inválido o no detectado.</p>';
    } else {
        $tope = intval($_GET['tope']);
        $link = new mysqli('localhost', 'root', 'password', 'marketzone');

        if ($link->connect_errno) {
            echo '<p>Error de conexión: ' . htmlspecialchars($link->connect_error) . '</p>';
        } else {
            $stmt = $link->prepare("SELECT * FROM productos WHERE unidades <= ? AND eliminado = 0");
            $stmt->bind_param("i", $tope);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                echo '<table class="table">';
                echo '<thead class="thead-dark">';
                echo '<tr><th>#</th><th>Nombre</th><th>Marca</th><th>Modelo</th><th>Precio</th><th>Unidades</th><th>Detalles</th><th>Imagen</th></tr>';
                echo '</thead><tbody>';
                
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['nombre']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['marca']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['modelo']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['precio']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['unidades']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['detalles']) . '</td>';
                    echo '<td><img src="' . htmlspecialchars($row['imagen']) . '" alt="Imagen del producto" width="100" /></td>';
                    echo '</tr>';
                }
                
                echo '</tbody></table>';
            } else {
                echo '<p>No hay productos con unidades menores o iguales a ' . htmlspecialchars($tope) . ' y que no estén eliminados.</p>';
            }
            
            $stmt->close();
        }
        $link->close(); 
    }
    ?>
</body>
</html>

