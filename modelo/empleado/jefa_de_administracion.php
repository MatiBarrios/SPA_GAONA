<?php
    require_once("../modelo/conexion.php");

    class JefaDeAdministracion extends Conexion{
        public function __construct()
        {
            parent::conectar_root();
        }

        public function mostrar_movimientos_cuenta(){
            try{
                return $this->db_connect->query("CALL leer_movimientos_cuenta()")->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
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

        public function generar_reporte_transacciones(DateTime $fecha_inicio, DateTime $fecha_fin){
            try{
                $consulta = $this->db_connect->prerare("CALL generar_reporte_transacciones(:inicio, :fin)");
                $consulta->execute(array(":inicio"=>$fecha_inicio, ":fin"=>$fecha_fin));
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