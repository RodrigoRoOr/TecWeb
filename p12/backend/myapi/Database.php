<?php namespace myapi;
/**
 * Clase abstracta para manejar la conexión a la base de datos
 */
abstract class DataBase {
    protected $conexion;
    protected $data = [];

    public function __construct($db, $user = 'root', $pass = 'password') {
        $this->conexion = new \mysqli('localhost', $user, $pass, $db);
        
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }
    public function getData() {
        return json_encode($this->data);
    }
}
?>