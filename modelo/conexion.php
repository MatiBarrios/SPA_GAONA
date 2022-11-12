<?php
    abstract class Conexion{
        protected $db_connect;

        public function conectar_usuario(string $usuario){
            try{
                $this->db_connect = new PDO("mysql:host=localhost; dbname=gaona", $usuario, "1234");
                $this->db_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(Exception $e){
                echo $e;
            }
        }

        public function conectar_root(){
            try{
                $this->db_connect = new PDO("mysql:host=localhost; dbname=gaona", "root", "");
                $this->db_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(Exception $e){
                echo $e;
            }
        }
    }
?>