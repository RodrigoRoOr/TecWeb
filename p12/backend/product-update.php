<?php
    require_once 'start.php';

    use myapi\Update\Update;

    // Configuración de headers y errores
    header('Content-Type: application/json; charset=UTF-8');
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // 2. Creación del objeto de la clase principal
    $products = new Update('marketzone'); // Reemplaza con el nombre real de tu BD

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