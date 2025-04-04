<?php namespace myapi\Delete;
    
    use myapi\DataBase;

    /**
     * Clase para manejar operaciones de productos en la base de datos
     */
    class Delete extends DataBase {

        public function __construct($db, $user = 'root', $pass = 'password') {
            parent::__construct($db, $user, $pass);
            $this->data = [];
        }

        public function delete($id) {
            $query = "UPDATE productos SET eliminado=1 WHERE id = '$id'";
            $result = $this->conexion->query($query);
            $this->data = $result ? ['success' => true] : ['error' => $this->conexion->error];
        }
    }
?>