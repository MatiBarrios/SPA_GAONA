<?php
    require_once("../modelo/conexion.php");

    class GerenteGeneral extends Conexion{
        public function __construct()
        {
            parent::conectar_root();
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

        public function mostrar_reportes_transacciones(){
            try{
                $this->db_connect->query("SELECT tipo_caja.nomTipo AS tipoCaja, concepto, monto, fecha,
                codPropiedad, codCliente, idReporte FROM movimiento_cuenta INNER JOIN relacion_reporte_cuenta
                ON movimiento_cuenta.id = idMovimientoCuenta INNER JOIN reporte ON reporte.id = idReporte
                INNER JOIN tipo_caja ON tipo_caja.id = idTipoCaja ORDER BY idReporte")->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }
    }
?>