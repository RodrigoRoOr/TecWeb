<?php
    /*header('Content-Type: application/json; charset=UTF-8');
    error_reporting(0); // 🔍 Oculta warnings
    ini_set('display_errors', 0);

    include_once __DIR__.'/database.php'; // Conexión a la BD

    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $query = "SELECT * FROM productos WHERE id = $id AND eliminado = 0";
        $result = mysqli_query($conexion, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);

            // 🔍 Verificación para evitar errores de clave indefinida
            $product = [
                "nombre" => $row["nombre"],
                "unidades" => $row["unidades"],
                "precio" => $row["precio"],
                "modelo" => $row["modelo"],
                "marca" => $row["marca"],
                "detalles" => $row["detalles"],
                "imagen" => isset($row["imagenes"]) ? $row["imagenes"] : "img/default.jpg", // Evita el error
                "id" => $row["id"]
            ];

            echo json_encode($product, JSON_UNESCAPED_UNICODE); // ✅ Respuesta JSON válida
        } else {
            echo json_encode(["error" => "No se encontró el producto"]);
        }
    } else {
        echo json_encode(["error" => "ID no proporcionado"]);
    }*/
    header('Content-Type: application/json; charset=UTF-8');
    error_reporting(0); // 🔍 Oculta warnings
    ini_set('display_errors', 0);
    
    // 1. Inclusión del archivo que contiene la clase Products
    require_once __DIR__.'/myapi/Products.php';
    
    // 2. Creación del objeto de la clase principal
    $products = new Products('marketzone'); // Reemplaza con el nombre real de tu BD
    
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);
        
        // 3. Invocación al método de la operación correspondiente (single)
        $products->single($id);
        $productData = json_decode($products->getData(), true);
    
        if (!isset($productData['error']) && !empty($productData)) {
            // 🔍 Formateamos los datos del producto
            $product = [
                "nombre" => $productData["nombre"],
                "unidades" => $productData["unidades"],
                "precio" => $productData["precio"],
                "modelo" => $productData["modelo"],
                "marca" => $productData["marca"],
                "detalles" => $productData["detalles"],
                "imagen" => isset($productData["imagen"]) ? $productData["imagen"] : "img/default.jpg",
                "id" => $productData["id"]
            ];
    
            echo json_encode($product, JSON_UNESCAPED_UNICODE); // ✅ Respuesta JSON válida
        } else {
            echo json_encode(["error" => "No se encontró el producto"]);
        }
    } else {
        echo json_encode(["error" => "ID no proporcionado"]);
    }
?>