<?php
require_once 'DataBase.php';

/**
 * Clase para manejar operaciones de productos en la base de datos
 */
class Products extends DataBase {
    protected $data = [];

    public function __construct($db, $user = 'root', $pass = '7*Vl*zwyPeGlNLTm') {
        parent::__construct($db, $user, $pass);
        $this->data = [];
    }

    public function add($product) {
        // Sanitizar los datos
        $nombre = $this->conexion->real_escape_string($product->nombre);
        $marca = $this->conexion->real_escape_string($product->marca);
        $modelo = $this->conexion->real_escape_string($product->modelo);
        $precio = floatval($product->precio);
        $detalles = $this->conexion->real_escape_string($product->detalles);
        $unidades = intval($product->unidades);
        $imagen = isset($product->imagen) ? $this->conexion->real_escape_string($product->imagen) : 'img/default.jpg';
    
        $query = "INSERT INTO productos VALUES (
            null, 
            '$nombre', 
            '$marca', 
            '$modelo', 
            $precio, 
            '$detalles', 
            $unidades, 
            '$imagen', 
            0
        )";
    
        $result = $this->conexion->query($query);
        $this->data = $result ? ['success' => true] : ['error' => $this->conexion->error];
    }

    public function delete($id) {
        $query = "UPDATE productos SET eliminado=1 WHERE id = '$id'";
        $result = $this->conexion->query($query);
        $this->data = $result ? ['success' => true] : ['error' => $this->conexion->error];
    }

    public function edit($id, $productData) {
        // Sanitizar los datos
        $id = $this->conexion->real_escape_string($id);
        $nombre = $this->conexion->real_escape_string($productData['nombre']);
        $marca = $this->conexion->real_escape_string($productData['marca']);
        $modelo = $this->conexion->real_escape_string($productData['modelo']);
        $precio = floatval($productData['precio']);
        $detalles = $this->conexion->real_escape_string($productData['detalles']);
        $unidades = intval($productData['unidades']);
        $imagen = $this->conexion->real_escape_string($productData['imagen']);
    
        // Verificar si el producto existe
        $this->single($id);
        if (empty($this->data) || isset($this->data['error'])) {
            $this->data = ['error' => 'No se encontró el producto'];
            return;
        }
    
        // Actualizar el producto
        $query = "UPDATE productos SET 
                  nombre='$nombre', 
                  marca='$marca', 
                  modelo='$modelo', 
                  precio=$precio, 
                  detalles='$detalles', 
                  unidades=$unidades, 
                  imagen='$imagen' 
                  WHERE id='$id'";
        
        $result = $this->conexion->query($query);
        $this->data = $result ? ['success' => true] : ['error' => $this->conexion->error];
    }

    /**
     * Lista todos los productos
     */
    public function list() {
        $query = "SELECT * FROM productos WHERE eliminado = 0";
        $result = $this->conexion->query($query);
        
        if ($result) {
            $this->data = [];
            while ($row = $result->fetch_assoc()) {
                $this->data[] = $row;
            }
            
            if (empty($this->data)) {
                $this->data = ['error' => 'No se encontraron productos'];
            }
        } else {
            $this->data = ['error' => $this->conexion->error];
        }
    }

    public function search($criteria) {
        $search = $this->conexion->real_escape_string($criteria);
        $query = "SELECT * FROM productos WHERE 
                  (id = '$search' OR 
                   nombre LIKE '%$search%' OR 
                   marca LIKE '%$search%' OR 
                   detalles LIKE '%$search%') 
                  AND eliminado = 0";
        
        $result = $this->conexion->query($query);
        
        if ($result) {
            $this->data = [];
            while ($row = $result->fetch_assoc()) {
                $this->data[] = $row;
            }
            
            if (empty($this->data)) {
                $this->data = ['error' => 'No se encontraron resultados'];
            }
        } else {
            $this->data = ['error' => $this->conexion->error];
        }
    }

    public function single($id) {
        $query = "SELECT * FROM productos WHERE id = '$id' AND eliminado = 0";
        $result = $this->conexion->query($query);
        
        if ($result) {
            $this->data = $result->fetch_assoc();
            if (!$this->data) {
                $this->data = ['error' => 'No se encontró el producto'];
            }
        } else {
            $this->data = ['error' => $this->conexion->error];
        }
    }

    public function singleByName($name) {
        $query = "SELECT * FROM productos WHERE nombre = '$name'";
        $result = $this->conexion->query($query);
        
        if ($result) {
            $this->data = $result->fetch_assoc();
        } else {
            $this->data = ['error' => $this->conexion->error];
        }
    }

    public function getData() {
        return json_encode($this->data);
    }
}
?>