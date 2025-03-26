<?php
/**
 * Clase abstracta para manejar la conexión a la base de datos
 */
abstract class DataBase {
    protected $conexion;

    public function __construct($db, $user = 'root', $pass = '7*Vl*zwyPeGlNLTm') {
        $this->conexion = new mysqli('localhost', $user, $pass, $db);
        
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }
}
?>