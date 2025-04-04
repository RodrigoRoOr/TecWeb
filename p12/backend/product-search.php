<?php
    require_once 'start.php';

    use myapi\Read\Read;

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Verificar si la clase Read existe
    if (!class_exists('myapi\Read\Read')) {
        echo json_encode(['error' => 'Clase Read no encontrada']);
        exit;
    }

    // 2. Creación del objeto de la clase principal
    $products = new Read('marketzone'); // Reemplaza con el nombre real de tu BD

    // SE VERIFICA HABER RECIBIDO EL TÉRMINO DE BÚSQUEDA
    if(isset($_GET['search'])) {
        $search = $_GET['search'];
        
        // 3. Invocación al método de la operación correspondiente (search)
        $products->search($search);
        $productData = json_decode($products->getData(), true);

        // Procesamos los datos para asegurar codificación UTF-8
        if (!empty($productData) && !isset($productData['error'])) {
            $data = array_map(function($row) {
                return array_map(fn($item) => mb_convert_encoding($item, 'UTF-8', 'auto'), $row);
            }, $productData);
        } else {
            $data = ['error' => isset($productData['error']) ? $productData['error'] : 'No se encontraron resultados'];
        }
    } else {
        $data = ['error' => 'Término de búsqueda no proporcionado'];
    }

    // 4. Devolver la información solicitada en formato JSON
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($data, JSON_PRETTY_PRINT);
?>