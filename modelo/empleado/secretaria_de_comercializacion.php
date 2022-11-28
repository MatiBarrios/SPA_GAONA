<?php
    //require_once("../modelo/conexion.php");

    class SecretariaDeComercializacion extends Conexion{
        public function __construct()
        {
            parent::conectar_root();
        }

        function registrar_cliente_particular(int $dni, int $cuil, int $telefono, string $correo,
        string $nombre, string $apellido, DateTime $fecha_nacimiento){
            try{
                $consulta = $this->db_connect->prepare("CALL registrar_cliente_particular(:dni, :cuil,
                :telefono, :correo, :nombre, :apellido, :fecha_nacimiento)");
                $consulta->execute(array(":dni"=>$dni, ":cuil"=>$cuil, ":telefono"=>$telefono,
                ":correo"=>$correo, ":nombre"=>$nombre, ":apellido"=>$apellido,
                ":fecha_nacimiento"=>$fecha_nacimiento));
                return $consulta->fetch()[0];
            }
            catch(Exception $e){
                echo $e;
            }
        }

        function registrar_cliente_corporativo(int $dni, int $cuit, int $telefono, string $correo,
        string $razon_social, string $propietarios, string $dir_administracion, int $id_agente){
            try{
                $consulta = $this->db_connect->prepare("CALL registrar_cliente_corporativo(:dni, :cuit,
                :telefono, :correo, :razon_social, :propietarios, :dir_administracion, :id_agente)");
                $consulta->execute(array(":dni"=>$dni, ":cuit"=>$cuit, ":telefono"=>$telefono,
                ":correo"=>$correo, ":razon_social"=>$razon_social, ":propietarios"=>$propietarios,
                ":dir_administracion"=>$dir_administracion, ":id_agente"=>$id_agente));
                return $consulta->fetch()[0];
            }
            catch(Exception $e){
                echo $e;
            }
        }

        function editar_cliente_particular(int $cod_cliente, int $cuil, int $telefono, string $correo){
            try{
                $consulta = $this->db_connect->prepare("CALL registrar_cliente_particular(:cod_cliente, :cuil,
                :telefono, :correo)");
                $consulta->execute(array(":cod_cliente"=>$cod_cliente, ":cuil"=>$cuil,
                ":telefono"=>$telefono, ":correo"=>$correo));
            }
            catch(Exception $e){
                echo $e;
            }
        }

        function editar_cliente_corporativo(int $cod_cliente, int $cuit, int $telefono, string $correo,
        string $razon_social, string $propietarios, string $dir_administracion, int $id_agente){
            try{
                $consulta = $this->db_connect->prepare("CALL editar_cliente_corporativo(:cod_cliente, :cuit,
                :telefono, :correo, :razon_social, :propietarios, :dir_administracion, :id_agente)");
                $consulta->execute(array(":cod_cliente"=>$cod_cliente, ":cuit"=>$cuit,
                ":telefono"=>$telefono, ":correo"=>$correo, ":razon_social"=>$razon_social,
                ":propietarios"=>$propietarios, ":dir_administracion"=>$dir_administracion,
                ":id_agente"=>$id_agente));
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function mostrar_agenda(){
            try{
                return $this->db_connect->query("CALL leer_agenda_todo()")->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function mostrar_citas(){
            try{
                return $this->db_connect->query("CALL leer_citas()")->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function mostrar_citas_no_agendadas(){
            try{
                return $this->db_connect->query("CALL leer_citas_no_agendadas()")->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }
        
        public function mostrar_agentes(){
            try{
                return $this->db_connect->query("select id,nombre,apellido from empleado where
                cargo='Agente inmobiliario'")->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function editar_cita(DateTime $fecha_y_hora, int $id_agente, int $id_cita){
            try{
                $consulta = $this->db_connect->prepare("UPDATE cita idAgente = :id_agente,
                fechaYHoraCita = :fecha_y_hora WHERE id = :id_cita");
                $consulta->execute(array(":id_agente"=>$id_agente, ":fecha_y_hora"=>$fecha_y_hora,
                ":id_cita"=>$id_cita));
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function cancelar_cita(int $id_cita){
            try{
                $consulta = $this->db_connect->prepare("UPDATE cita aceptada = FALSE WHERE id = :id_cita");
                $consulta->execute(array(":id_cita"=>$id_cita));
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function asignar_cita_agente(int $id_cita, int $id_agente, DateTime $fecha_y_hora){
            try{
                $consulta = $this->db_connect->prepare("CALL asignar_cita_agente(:id_cita, :id_agente,
                :fecha_y_hora)");
                $consulta->execute(array(":id_cita"=>$id_cita, ":id_agente"=>$id_agente,
                ":fecha_y_hora"=>$fecha_y_hora->format("Y-m-d H:i")));
            }
            catch(Exception $e){
                echo $e;
            }
        }
    }
?>