<?php
namespace Myapi\Read;
use Myapi\DataBase;
class Read extends DataBase{
    public function __construct($db,$user='root',$pass='password'){
        $this->data = array();
        parent::__construct($db,$user,$pass);   
    }

    public function list () {
        if ($result = $this->conexion->query("SELECT * FROM productos WHERE eliminado = 0")) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if(!is_null($rows)){
                foreach ($rows as $num => $row) {
                    foreach ($row as $key => $value) {
                        $this->data[$num][$key] = $value;
                    }
                }
            }
        }
        $result->free();
        $this->conexion->close();
    }

    public function search($parametro) {
        $search = $this->conexion->real_escape_string($parametro);    
        $sql = "SELECT * FROM productos 
                WHERE (
                    id = '{$search}' 
                    OR nombre LIKE '%{$search}%' 
                    OR marca LIKE '%{$search}%' 
                    OR detalles LIKE '%{$search}%'
                ) AND eliminado = '0'"; 
        if ($result = $this->conexion->query($sql)) {
            $this->data = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
        } else {
            $this->data = array();
        }
        $this->conexion->close();
    }

    public function single($id) {
        $this->data = array(); 
        
        if ($id) {
            $sql = "SELECT * FROM productos WHERE id = '{$id}'";
            
            if ($result = $this->conexion->query($sql)) {
                $row = $result->fetch_assoc();
                if ($row) {
                    $this->data = $row;
                }
                $result->free();
            }
            $this->conexion->close();
        }
    }

    public function singleByName($name){
        if( $name ) {
    
            $sql = "SELECT * FROM productos WHERE nombre = '{$name}'";
    
            if ( $result = $this -> conexion->query($sql) ) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);
    
                if(!is_null($rows)) {
                    foreach($rows as $num => $row) {
                        foreach($row as $key => $value) {
                            $this -> data[$num][$key] = $value;
                        }
                    }
                } 
                $result->free();
            }
            else {
                die('Query Error: '.mysqli_error($this -> conexion));
            }
            $this -> conexion->close();
        }
    }
}
?>