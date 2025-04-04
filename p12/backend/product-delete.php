<?php
    require_once 'start.php';

    use myapi\Delete\Delete;

    // 2. Creación del objeto de la clase principal
    $products = new Delete('marketzone'); // Reemplaza con el nombre real de tu BD

    // SE VERIFICA HABER RECIBIDO EL ID
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        
        // 3. Invocación al método de la operación correspondiente (delete)
        $products->delete($id);
        
        // Verificamos el resultado de la operación
        $result = json_decode($products->getData(), true);
        
        if(isset($result['success'])) {
            $products->data = [
                'status' => 'success',
                'message' => 'Producto eliminado'
            ];
        } else {
            $products->data = [
                'status' => 'error',
                'message' => isset($result['error']) ? $result['error'] : 'La consulta falló'
            ];
        }
    } else {
        $products->data = [
            'status' => 'error',
            'message' => 'No se recibió el ID del producto'
        ];
    }

    // 4. Devolver la información solicitada en formato JSON
    header('Content-Type: application/json');
    echo $products->getData();
?>