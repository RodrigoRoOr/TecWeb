<?php
    /*include_once __DIR__ . '/database.php';

    header('Content-Type: application/json; charset=UTF-8');
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Obtener el ID desde la URL
    $id = $_GET['id'];

    // Obtener el cuerpo de la solicitud POST (JSON)
    $producto = file_get_contents('php://input');
    $data_mesage = array(
        'status' => 'error',
        'message' => 'Hubo un fallo en la modificación' //Mensaje de error predeterminado.
    );

    if (!empty($producto)) {
        // Decodificar el JSON como un array asociativo
        $data = json_decode($producto, true);
        if (json_last_error() === JSON_ERROR_NONE) { // Verifica que el JSON sea válido
            $nombre = $data['nombre'];
            $sql = "SELECT * FROM productos WHERE id = '$id';";
            $result = $conexion->query($sql);

            if ($result->num_rows > 0) {
                $conexion->set_charset("utf8");
                $sql = "UPDATE productos SET nombre='$nombre', marca='{$data['marca']}', modelo='{$data['modelo']}', precio={$data['precio']}, detalles='{$data['detalles']}', unidades={$data['unidades']}, imagen='{$data['imagen']}' WHERE id='$id';";
                if ($conexion->query($sql)) {
                    echo json_encode(["status" => "success", "message" => "Producto actualizado correctamente"]);
                    exit;
                } else {
                    $data_mesage['message'] = "ERROR: No se ejecutó el comando. " . $conexion->error; // Añadido el error de la conexion.
                }
            } else {
                $data_mesage['message'] = "No se encontró el producto";
            }
            $result->free();
        } else {
            $data_mesage['message'] = "Error: JSON inválido recibido.";
        }
    } else {
        $data_mesage['message'] = "No se recibieron datos.";
    }

    // Cierra la conexión
    $conexion->close();

    // Devuelve la respuesta en formato JSON
    echo json_encode($data_mesage, JSON_PRETTY_PRINT);*/
    // 1. Inclusión del archivo que contiene la clase Products
    require_once __DIR__.'/myapi/Products.php';

    // Configuración de headers y errores
    header('Content-Type: application/json; charset=UTF-8');
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // 2. Creación del objeto de la clase principal
    $products = new Products('marketzone'); // Reemplaza con el nombre real de tu BD

    // Respuesta por defecto
    $response = [
        'status' => 'error',
        'message' => 'Hubo un fallo en la modificación'
    ];

    // Verificar que se recibió el ID
    if (!isset($_GET['id'])) {
        $response['message'] = 'ID no proporcionado';
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }

    $id = $_GET['id'];

    // Obtener el cuerpo de la solicitud
    $producto = file_get_contents('php://input');

    if (!empty($producto)) {
        // Decodificar el JSON
        $data = json_decode($producto, true);
        
        if (json_last_error() === JSON_ERROR_NONE) {
            // 3. Invocación al método de la operación correspondiente (edit)
            $products->edit($id, $data);
            $result = json_decode($products->getData(), true);
            
            if (isset($result['success'])) {
                $response = [
                    'status' => 'success',
                    'message' => 'Producto actualizado correctamente'
                ];
            } else {
                $response['message'] = isset($result['error']) ? $result['error'] : 'Error al actualizar el producto';
            }
        } else {
            $response['message'] = 'Error: JSON inválido recibido';
        }
    } else {
        $response['message'] = 'No se recibieron datos';
    }

    // 4. Devolver la información solicitada en formato JSON
    echo json_encode($response, JSON_PRETTY_PRINT);
?>
