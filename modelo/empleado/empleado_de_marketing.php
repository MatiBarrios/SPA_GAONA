<?php
    require_once("../modelo/conexion.php");

    class EmpleadoDeMarketing extends Conexion{
        public function __construct()
        {
            parent::conectar_root();
        }

        public function mostrar_propiedades(){
            try{
                return $this->db_connect->query("CALL leer_propiedades_todas()")->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function mostrar_imagenes_propiedad(int $cod_propiedad){
            try{
                $consulta = $this->db_connect->prepare("SELECT * FROM imagen_propiedad WHERE
                codPropiedad = :cod_propiedad")->fetchAll();
                $consulta->execute(array(":cod_propiedad"=>$cod_propiedad));
                return $consulta->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function borrar_imagen_propiedad(int $id_imagen){
            try{
                $consulta = $this->db_connect->prepare("DELETE FROM imagen_propiedad WHERE
                id = :id_imagen");
                $consulta->execute(array(":id_imagen"=>$id_imagen));
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function agregar_imagen_propiedad(int $cod_propiedad, string $enlace){
            try{
                $consulta = $this->db_connect->prepare("INSERT INTO imagen_propiedad (codPropiedad, enlace)
                VALUES (:cod_propiedad, :enlace)");
                $consulta->execute(array(":cod_propiedad"=>$cod_propiedad, ":enlace"=>$enlace));
            }
            catch(Exception $e){
                echo $e;
            }
        }
    }
?>