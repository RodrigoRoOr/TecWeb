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
    if (!isset($jsonOBJ->id, $jsonOBJ->nombre, $jsonOBJ->marca, $jsonOBJ->modelo, $jsonOBJ->precio, $jsonOBJ->detalles, $jsonOBJ->unidades, $jsonOBJ->imagen)) {
        $data['message'] = 'Faltan campos obligatorios';
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit;
    }

    // SANITIZACIÓN DE LOS DATOS
    $id = intval($jsonOBJ->id);
    $nombre = mysqli_real_escape_string($conexion, $jsonOBJ->nombre);
    $marca = mysqli_real_escape_string($conexion, $jsonOBJ->marca);
    $modelo = mysqli_real_escape_string($conexion, $jsonOBJ->modelo);
    $precio = floatval($jsonOBJ->precio);
    $detalles = mysqli_real_escape_string($conexion, $jsonOBJ->detalles);
    $unidades = intval($jsonOBJ->unidades);
    $imagen = mysqli_real_escape_string($conexion, $jsonOBJ->imagen);

    // CONSULTA PARA ACTUALIZAR EL PRODUCTO
    $sql = "UPDATE productos SET 
            nombre = '$nombre', 
            marca = '$marca', 
            modelo = '$modelo', 
            precio = $precio, 
            detalles = '$detalles', 
            unidades = $unidades, 
            imagen = '$imagen' 
            WHERE id = $id";

    if ($conexion->query($sql)) {
        $data['status'] = "success";
        $data['message'] = "Producto actualizado exitosamente";
    } else {
        $data['message'] = "Error en la actualización: " . $conexion->error;
    }

    $conexion->close();
} else {
    $data['message'] = 'No se recibieron datos';
}

echo json_encode($data, JSON_PRETTY_PRINT);
?>