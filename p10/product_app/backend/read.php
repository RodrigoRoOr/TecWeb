<?php
include_once __DIR__.'/database.php';

$data = array();

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    if (is_numeric($id)) {
        $query = "SELECT * FROM productos WHERE id = '{$id}'";
    } else {
        $word = $id;
        $query = "SELECT * FROM productos WHERE nombre LIKE '%{$word}%' OR marca LIKE '%{$word}%' OR modelo LIKE '%{$word}%' OR detalles LIKE '%{$word}%'";
    }

    if ($result = $conexion->query($query)) {
        if (is_numeric($id)) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if (!is_null($row)) {
                $data = $row;
            }
        } else {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $data[] = $row;
            }
        }
        $result->free();
    } else {
        die('Query Error: ' . mysqli_error($conexion));
    }
    $conexion->close();
}

echo json_encode($data, JSON_PRETTY_PRINT);
?>