<?php
include_once __DIR__ . '/database.php';

header('Content-Type: application/json');

$data = array(
    'existe' => false
);

if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];

    $sql = "SELECT * FROM productos WHERE nombre = '$nombre' AND eliminado = 0";
    if ($result = $conexion->query($sql)) {
        if ($result->num_rows > 0) {
            $data['existe'] = true;
        }
        $result->free();
    } else {
        die('Query Error: ' . mysqli_error($conexion));
    }
    $conexion->close();
}

echo json_encode($data, JSON_PRETTY_PRINT);
?>