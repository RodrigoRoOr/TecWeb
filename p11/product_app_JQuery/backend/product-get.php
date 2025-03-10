<?php
include_once __DIR__ . '/database.php';

// CABECERA PARA DEVOLVER JSON
header('Content-Type: application/json');

// SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
$data = array(
    'status'  => 'error',
    'message' => 'No se encontró el producto'
);

// SE VERIFICA HABER RECIBIDO EL ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
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

// SE HACE LA CONVERSIÓN DE ARRAY A JSON
echo json_encode($data, JSON_PRETTY_PRINT);
?>