<?php
    //require_once("../modelo/conexion.php");

    class AgenteInmobiliario extends Conexion{
        public function __construct()
        {
            parent::conectar_root();
        }

        public function mostrar_propiedades_todas(){
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

        public function mostrar_imagenes_propiedad(int $cod_propiedad){
            try{
                $consulta = $this->db_connect->prepare("SELECT * FROM imagen_propiedad WHERE
                codPropiedad = :cod_propiedad");
                $consulta->execute(array(":cod_propiedad"=>$cod_propiedad));
                return $consulta->fetchAll();
                $consulta->closeCursor();
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function registrar_propiedad(int $cod_duenio, int $cod_inquilino, string $tipo, int $superficie,
        string $pais, string $provincia, string $localidad, string $barrio, string $direccion, int $cod_postal,
        int $num_banios, int $num_suites, DateTime $fecha_construccion, string $espacios, string $artefactos,
        string $servicios, int $precio_alquiler, int $precio_venta){
            try{
                $consulta = $this->db_connect->prepare("INSERT INTO propiedad (codDuenio, codInquilino, tipo,
                superficie, pais, provincia, localidad, barrio, direccion, codpostal, numBanios, numSuites,
                fechaConstruccion, espacios, artefactos, servicios, precioAlquiler, precioVenta,
                fechaRegistrada) VALUES (:cod_duenio, :cod_inquilino, :tipo, :superficie, :pais, :provincia,
                :localidad, :barrio, :direccion, :cod_postal, :num_banios, :num_suites, :fecha_construccion,
                :espacios, :artefactos, :servicios, :precio_alquiler, :precio_venta, NOW())");
                $consulta->execute(array(":cod_duenio"=>$cod_duenio, ":cod_inquilino"=>$cod_inquilino,
                ":tipo"=>$tipo, ":superficie"=>$superficie, ":pais"=>$pais, ":provincia"=>$provincia,
                ":localidad"=>$localidad, ":barrio"=>$barrio, ":direccion"=>$direccion,
                ":cod_postal"=>$cod_postal, ":num_banios"=>$num_banios, ":num_suites"=>$num_suites,
                ":fecha_construccion"=>$fecha_construccion->format("Y-m-d H:i:s"), ":espacios"=>$espacios,
                ":artefactos"=>$artefactos, ":servicios"=>$servicios, ":precio_alquiler"=>$precio_alquiler,
                ":precio_venta"=>$precio_venta));
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function editar_propiedad(int $cod_propiedad, int $cod_duenio, int $cod_inquilino,
        int $superficie, int $num_banios, int $num_suites, string $espacios, string $artefactos,
        string $servicios, int $precio_alquiler, int $precio_venta){
            try{
                $consulta = $this->db_connect->prepare("UPDATE propiedad SET codDuenio = :cod_duenio,
                codInquilino = :cod_inquilino, superficie = :superficie, numBanios = :num_banios,
                numSuites = :num_suites, espacios = :espacios, artefactos = :artefactos, servicios = :servicios,
                precioAlquiler = :precio_alquiler, precioVenta = :precio_venta
                WHERE codPropiedad = :cod_propiedad");
                $consulta->execute(array(":cod_duenio"=>$cod_duenio, ":cod_inquilino"=>$cod_inquilino,
                ":superficie"=>$superficie, ":num_banios"=>$num_banios, ":num_suites"=>$num_suites,
                ":espacios"=>$espacios, ":artefactos"=>$artefactos, ":servicios"=>$servicios,
                ":precio_alquiler"=>$precio_alquiler, ":precio_venta"=>$precio_venta,
                ":cod_propiedad"=>$cod_propiedad));
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function mostrar_agenda(int $id_agente){
            try{
                $consulta = $this->db_connect->prepare("CALL leer_agenda_agente(:id_agente)");
                $consulta->execute(array(":id_agente"=>$id_agente));
                return $consulta->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function actualizar_agenda(int $id_actividad, string $estado){
            try{
                $consulta = $this->db_connect->prepare("UPDATE agenda SET estado = :estado WHERE id = :id");
                $consulta->execute(array(":id"=>$id_actividad, ":estado"=>$estado));
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function mostrar_clientes_a_cargo(int $id_agente){
            try{
                $consulta = $this->db_connect->prepare("SELECT cliente.codCliente, razonSocial, propietarios,
                cuit, direccionAdministracion, dni, cuil, telefono, correo FROM cliente_corporativo
                INNER JOIN cliente ON cliente.codCliente = cliente_corporativo.codCliente
                WHERE idAgenteACargo = :id_agente");
                $consulta->execute(array(":id_agente"=>$id_agente));
                return $consulta->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }
    }
?>