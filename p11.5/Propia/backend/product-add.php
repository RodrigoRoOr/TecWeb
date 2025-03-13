<?php
include_once __DIR__ . '/database.php';

// CABECERA PARA DEVOLVER JSON
header('Content-Type: application/json');

// SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
$producto = file_get_contents('php://input');
$data = array(
    'status'  => 'error',
    'message' => 'Ocurrió un error desconocido'
);

if (!empty($producto)) {
    // SE TRANSFORMA EL STRING DEL JSON A OBJETO
    $jsonOBJ = json_decode($producto);

    // VALIDACIÓN DE LA ENTRADA
    if (json_last_error() !== JSON_ERROR_NONE) {
        $data['message'] = 'Error en el formato JSON: ' . json_last_error_msg();
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit;
    }

    // COMPROBAR CAMPOS NECESARIOS
    if (!isset($jsonOBJ->nombre, $jsonOBJ->marca, $jsonOBJ->modelo, $jsonOBJ->precio, $jsonOBJ->detalles, $jsonOBJ->unidades, $jsonOBJ->imagen)) {
        $data['message'] = 'Faltan campos obligatorios';
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit;
    }

    // SANITIZACIÓN DE LOS DATOS
    $nombre = mysqli_real_escape_string($conexion, $jsonOBJ->nombre);
    $marca = mysqli_real_escape_string($conexion, $jsonOBJ->marca);
    $modelo = mysqli_real_escape_string($conexion, $jsonOBJ->modelo);
    $precio = floatval($jsonOBJ->precio);
    $detalles = mysqli_real_escape_string($conexion, $jsonOBJ->detalles);
    $unidades = intval($jsonOBJ->unidades);
    $imagen = mysqli_real_escape_string($conexion, $jsonOBJ->imagen);

    // CONSULTA PARA VERIFICAR SI YA EXISTE EL PRODUCTO
    $sql = "SELECT * FROM productos WHERE nombre = '$nombre' AND eliminado = 0";
    $result = $conexion->query($sql);

    if ($result->num_rows == 0) {
        $conexion->set_charset("utf8");
        $sql = "INSERT INTO productos VALUES (null, '$nombre', '$marca', '$modelo', $precio, '$detalles', $unidades, '$imagen', 0)";
        
        if ($conexion->query($sql)) {
            $data['status'] = "success";
            $data['message'] = "Producto agregado exitosamente";
        } else {
            $data['message'] = "Error en la inserción: " . $conexion->error;
        }
    } else {
        $data['message'] = "El producto ya existe.";
    }

    $result->free();
    $conexion->close();
} else {
    $data['message'] = 'No se recibieron datos';
}

echo json_encode($data, JSON_PRETTY_PRINT);
?>