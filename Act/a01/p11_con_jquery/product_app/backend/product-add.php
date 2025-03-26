<?php
    /*include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');
    $data = array(
        'status'  => 'error',
        'message' => 'Ya existe un producto con ese nombre'
    );
    if(!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JASON A OBJETO
        $jsonOBJ = json_decode($producto);
        // SE ASUME QUE LOS DATOS YA FUERON VALIDADOS ANTES DE ENVIARSE
        $sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND eliminado = 0";
	    $result = $conexion->query($sql);
        
        if ($result->num_rows == 0) {
            $conexion->set_charset("utf8");
            $sql = "INSERT INTO productos VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
            if($conexion->query($sql)){
                $data['status'] =  "success";
                $data['message'] =  "Producto agregado";
            } else {
                $data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($conexion);
            }
        }

        $result->free();
        // Cierra la conexion
        $conexion->close();
    }

    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);*/
    // 1. Inclusión del archivo que contiene la clase Products
    header('Content-Type: application/json; charset=UTF-8');
    error_reporting(0);

    require_once __DIR__.'/myapi/Products.php';

    $products = new Products('marketzone'); // Usa tu nombre de BD real

    $producto = file_get_contents('php://input');
    $response = [
        'status' => 'error',
        'message' => 'No se recibieron datos del producto'
    ];

    if(!empty($producto)) {
        $jsonOBJ = json_decode($producto);
        
        if(json_last_error() === JSON_ERROR_NONE) {
            // Verificar si el producto ya existe
            $products->singleByName($jsonOBJ->nombre);
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