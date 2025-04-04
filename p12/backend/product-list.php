<?php
    require_once 'start.php';
    use myapi\Read\Read;

    // 2. Creación del objeto de la clase principal
    $products = new Read('marketzone'); // Reemplaza con el nombre real de tu BD

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