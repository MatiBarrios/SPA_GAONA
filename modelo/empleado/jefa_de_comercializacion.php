<?php
    require_once("../modelo/conexion.php");

    class JefaDeComercializacion extends Conexion{
        public function __construct()
        {
            parent::conectar_root();
        }

        public function mostrar_clientes(){
            try{
                return $this->db_connect->query("SELECT cliente.codCliente, dni, cuil, cuit, nombre, apellido,
                fechaNacimiento, razonSocial, direccionAdministracion, fechaRegistrado, telefono, correo
                FROM cliente LEFT JOIN cliente_particular ON cliente.codCliente = cliente_particular.codCliente
                LEFT JOIN cliente_corporativo ON cliente.codCliente = cliente_corporativo.codCliente")->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function mostrar_agenda(){
            try{
                $this->db_connect->query("CALL leer_agenda_todo()")->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function mostrar_propiedades(){
            try{
                return $this->db_connect->query("CALL leer_propiedades_todas()")->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function mostrar_propiedades_habilitadas(){
            try{
                return $this->db_connect->query("CALL leer_propiedades_habilitadas()")->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function mostrar_propiedades_inhabilitadas(){
            try{
                return $this->db_connect->query("CALL leer_propiedades_inhabilitadas()")->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function generar_reportes(DateTime $fecha_inicio, DateTime $fecha_fin, string $tipo){
            try{
                $consulta = $this->db_connect->prepare("CALL generar_reportes(:inicio, :fin, :tipo)");
                $consulta->execute(array(":inicio"=>$fecha_inicio, ":fin"=>$fecha_fin, ":tipo"=>$tipo));
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function mostrar_reportes_alquiler(){
            try{
                return $this->db_connect->query("CALL leer_reportes_alquiler()")->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function mostrar_reportes_venta(){
            try{
                return $this->db_connect->query("CALL leer_reportes_venta()")->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function mostrar_reportes_clientes(){
            try{
                return $this->db_connect->query("CALL leer_reportes_clientes()")->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function mostrar_reportes_propiedades(){
            try{
                return $this->db_connect->query("CALL leer_reportes_propiedades()")->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }
    }
?>