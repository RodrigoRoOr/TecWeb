<?php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   header('Content-Type: application/json');

    require_once 'start.php';

    use myapi\Create\Create;
    use myapi\Read\Read;

    $products = new Create('marketzone'); // Usa tu nombre de BD real
    $single = new Read('marketzone');

    $producto = file_get_contents('php://input');
    $response = [
        'status' => 'error',
        'message' => 'No se recibieron datos del producto'
    ];

    if(!empty($producto)) {
        $jsonOBJ = json_decode($producto);
        
        if(json_last_error() === JSON_ERROR_NONE) {
            // Verificar si el producto ya existe
            $single->singleByName($jsonOBJ->nombre);
            $existing = json_decode($products->getData(), true);
            
            if(empty($existing) || isset($existing['error'])) {
                // Agregar el producto
                $products->add($jsonOBJ);
                $result = json_decode($products->getData(), true);
                
                if(isset($result['success'])) {
                    $response = [
                        'status' => 'success',
                        'message' => 'Producto agregado correctamente'
                    ];
                } else {
                    $response['message'] = 'Error al agregar el producto: ' . 
                        (isset($result['error']) ? $result['error'] : 'Error desconocido');
                }
            } else {
                $response['message'] = 'Ya existe un producto con ese nombre';
            }
        } else {
            $response['message'] = 'JSON inválido';
        }
    }

    echo json_encode($response);
?>