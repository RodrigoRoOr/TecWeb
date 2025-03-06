<?php
include_once __DIR__.'/database.php';

header('Content-Type: application/json');

$producto = file_get_contents('php://input');
if (!empty($producto)) {
    $jsonOBJ = json_decode($producto);

    $insert = "INSERT INTO productos VALUES (NULL, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', '{$jsonOBJ->precio}', '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', {$jsonOBJ->eliminado})";

    $sql = $conexion->query("SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND marca = '{$jsonOBJ->marca}'");

    if ($sql->num_rows > 0) {
        $sql = $conexion->query("SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND marca = '{$jsonOBJ->marca}' AND eliminado = 1");

        if ($sql->num_rows > 0) {
            if ($jsonOBJ->eliminado == 0) {
                if ($conexion->query($insert)) {
                    $response = ['status' => 'success', 'message' => 'Producto reinsertado correctamente'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Error al reinsertar el producto'];
                }
            } else {
                $response = ['status' => 'error', 'message' => 'El producto ya existe'];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'El producto ya existe'];
        }
    } else {
        if ($conexion->query($insert)) {
            $response = ['status' => 'success', 'message' => 'Producto insertado correctamente'];
        } else {
            $response = ['status' => 'error', 'message' => 'Error al insertar el producto'];
        }
    }
    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos vacíos recibidos']);
}
?>