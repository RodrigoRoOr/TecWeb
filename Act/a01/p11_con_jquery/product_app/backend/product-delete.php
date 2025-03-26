<?php
    /*include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array(
        'status'  => 'error',
        'message' => 'La consulta falló'
    );
    // SE VERIFICA HABER RECIBIDO EL ID
    if( isset($_GET['id']) ) {
        $id = $_GET['id'];
        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id}";
        if ( $conexion->query($sql) ) {
            $data['status'] =  "success";
            $data['message'] =  "Producto eliminado";
		} else {
            $data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($conexion);
        }
		$conexion->close();
    } 
    
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);*/
    // 1. Inclusión del archivo que contiene la clase Products
    require_once __DIR__.'/myapi/Products.php';

    // 2. Creación del objeto de la clase principal
    $products = new Products('marketzone'); // Reemplaza con el nombre real de tu BD

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