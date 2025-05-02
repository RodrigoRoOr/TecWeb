<?php
    namespace Myapi;
    abstract class DataBase{
        protected $conexion;
        protected $data;

        public function __construct($db,$user,$pass){
            $this->conexion = new \mysqli('localhost',$user,$pass,$db,3306);
        }

        public function getData() {
            return json_encode($this->data);
        }
    }
?>