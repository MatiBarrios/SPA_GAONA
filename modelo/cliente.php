<?php
    require_once("modelo/conexion.php");

    class Cliente extends Conexion{
        public function __construct()
        {
            parent::conectar_root();
        }

        public function solicitar_cita(int $cod_cliente, int $fecha_y_hora, int $cod_propiedad){
            try{
                $consulta = $this->db_connect->prerare("INSERT INTO cita (codCliente, fechaYHoraCita,
                fechaYHoraRegistro, codPropiedad) VALUES (:cod_cliente, :fecha_y_hora, NOW(), :cod_propiedad)");
                $consulta->execute(array(":cod_cliente"=>$cod_cliente, ":fecha_y_hora"=>$fecha_y_hora,
                ":cod_propiedad"=>$cod_propiedad));
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function mostrar_citas(int $cod_cliente){
            try{
                $consulta = $this->db_connect->prerare("SELECT fechaYHoraCita AS fechaYHora, aceptada, nomTipo
                AS tipo, superficie, pais, provincia, localidad, barrio, direccion FROM cita INNER JOIN
                propiedad ON propiedad.codPropiedad = cita.codPropiedad INNER JOIN tipo_propiedad ON
                propiedad.idTipo = tipo_propiedad.id WHERE codCliente = :cod_cliente");
                return $consulta->execute(array(":cod_cliente"=>$cod_cliente));
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function mostrar_propiedades(){
            try{
                return $this->db_connect->query("CALL leer_propiedades_habilitadas()")->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }
    }
?>