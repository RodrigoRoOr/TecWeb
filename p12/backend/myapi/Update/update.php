<?php namespace myapi\Update;
    
    use myapi\DataBase;

    /**
     * Clase para manejar operaciones de productos en la base de datos
     */
    class Update extends DataBase {

        public function __construct($db, $user = 'root', $pass = 'password') {
            parent::__construct($db, $user, $pass);
            $this->data = [];
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
    
    }
?>