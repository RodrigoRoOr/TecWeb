<?php
include_once __DIR__ . '/database.php';

header('Content-Type: application/json');

$data = array(
    'status'  => 'error',
    'message' => 'No se encontró el producto'
);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM productos WHERE id = {$id} AND eliminado = 0";
    if ($result = $conexion->query($sql)) {
        if ($result->num_rows > 0) {
            $data['status'] = "success";
            $data['message'] = "Producto encontrado";
            $data['data'] = $result->fetch_assoc();
        }
        $result->free();
    } else {
        $data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($conexion);
    }
    $conexion->close();
}

echo json_encode($data, JSON_PRETTY_PRINT);
?>