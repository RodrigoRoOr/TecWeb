<?php namespace myapi\Create;
    
    use myapi\DataBase;

    /**
     * Clase para manejar operaciones de productos en la base de datos
     */
    class Create extends DataBase {

        public function __construct($db, $user = 'root', $pass = 'password') {
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
    }
?>