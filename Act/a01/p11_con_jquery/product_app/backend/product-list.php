<?php
    /*include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array();

    // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
    if ( $result = $conexion->query("SELECT * FROM productos WHERE eliminado = 0") ) {
        // SE OBTIENEN LOS RESULTADOS
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        if(!is_null($rows)) {
            // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
            foreach($rows as $num => $row) {
                foreach($row as $key => $value) {
                    $data[$num][$key] = utf8_encode($value);
                }
            }
        }
        $result->free();
    } else {
        die('Query Error: '.mysqli_error($conexion));
    }
    $conexion->close();
    
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);*/
    // 1. Inclusión del archivo que contiene la clase Products
    require_once __DIR__.'/myapi/Products.php';

    // 2. Creación del objeto de la clase principal
    $products = new Products('marketzone'); // Reemplaza con el nombre real de tu BD

    // 3. Invocación al método de la operación correspondiente (list)
    $products->list();
    $productData = json_decode($products->getData(), true);

    // Procesamos los datos para asegurar codificación UTF-8
    if (!empty($productData) && !isset($productData['error'])) {
        $data = array_map(function($row) {
            return array_map('utf8_encode', $row);
        }, $productData);
    } else {
        $data = ['error' => isset($productData['error']) ? $productData['error'] : 'No se encontraron productos'];
    }

    // 4. Devolver la información solicitada en formato JSON
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($data, JSON_PRETTY_PRINT);
?>