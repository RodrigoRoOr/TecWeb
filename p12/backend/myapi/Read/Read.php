<?php 
    namespace myapi\Read;
    
    use myapi\DataBase;

    /**
     * Clase para manejar operaciones de productos en la base de datos
     */
    class Read extends DataBase {

        public function __construct($db, $user = 'root', $pass = 'password') {
            parent::__construct($db, $user, $pass);
            $this->data = [];
        }

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
    }
?>