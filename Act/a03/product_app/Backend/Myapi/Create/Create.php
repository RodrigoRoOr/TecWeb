<?php
namespace Myapi\Create;
use Myapi\DataBase;
class Create extends DataBase{
    public function __construct($db,$user='root',$pass='password'){
        $this->data = array();
        parent::__construct($db,$user,$pass);   
    }
    
    public function add($object) {
        $this->data = ['status' => 'error', 'message' => 'Error desconocido'];
                
        if (empty($object)) {
            $this->data['message'] = "Datos vacíos";
            return;
        }
                
        $jsonOBJ = json_decode($object);
        if ($jsonOBJ === null) {
            $this->data['message'] = "JSON inválido";
            return;
        }
                
        // Sanitizar inputs
        $nombre = $this->conexion->real_escape_string($jsonOBJ->nombre);
        $marca = $this->conexion->real_escape_string($jsonOBJ->marca);
        $modelo = $this->conexion->real_escape_string($jsonOBJ->modelo);
        $detalles = $this->conexion->real_escape_string($jsonOBJ->detalles);
        $imagen = $this->conexion->real_escape_string($jsonOBJ->imagen);
                
        // Validar campos numéricos
        if (!is_numeric($jsonOBJ->precio) || !is_numeric($jsonOBJ->unidades)) {
            $this->data['message'] = "Valores numéricos inválidos";
            return;
        }
            
        $sqlCheck = "SELECT id FROM productos WHERE nombre = '$nombre' AND eliminado = 0";
        if ($result = $this->conexion->query($sqlCheck)) {
            if ($result->num_rows > 0) {
                $this->data['message'] = "El producto ya existe";
                $result->free();
                return;
            }
                    
            $sqlInsert = "INSERT INTO productos VALUES (
                null, 
                '$nombre', 
                '$marca', 
                '$modelo', 
                {$jsonOBJ->precio}, 
                '$detalles', 
                {$jsonOBJ->unidades}, 
                '$imagen', 
                0
            )";
                    
            if ($this->conexion->query($sqlInsert)) {
                $this->data['status'] = "success";
                $this->data['message'] = "Producto agregado";
                $this->data['id'] = $this->conexion->insert_id;
            } else {
                $this->data['message'] = "Error al insertar: " . $this->conexion->error;
            }
        } else {
            $this->data['message'] = "Error en verificación: " . $this->conexion->error;
        }
            
        $this->conexion->close();
    }
}
?>