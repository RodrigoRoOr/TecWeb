<?php
namespace Myapi\Delete;
use Myapi\DataBase;
class Delete extends DataBase{
    public function __construct($db,$user='root',$pass='password'){
        $this->data = array();
        parent::__construct($db,$user,$pass);   
    }

    public function delete($id) {
        $this->data = [
            'status'  => 'error',
            'message' => 'ID no proporcionado'
        ];
        if ($id) {
            $sql = "UPDATE productos SET eliminado = 1 WHERE id = {$id}";
            if ($this->conexion->query($sql)) {
                $this->data = [
                    'status'  => 'success',
                    'message' => 'Producto eliminado'
                ];
            } else {
                $this->data = [
                    'status'  => 'error',
                    'message' => 'Error al ejecutar la consulta: ' . mysqli_error($this->conexion)
                ];
            }
            $this->conexion->close();
        }        
        return $this;
    }
}
?>