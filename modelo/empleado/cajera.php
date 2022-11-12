<?php
    require_once("../modelo/conexion.php");

    class Cajera extends Conexion{
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

        public function registrar_movimiento_cuenta(int $id_tipo, string $concepto, int $monto,
        int $cod_propiedad, int $cod_cliente){
            try{
                $consulta = $this->db_connect->prepare("INSERT INTO movimiento_cuenta (idTipoCaja, concepto,
                monto, fecha, codPropiedad, codCliente) VALUES (:id_tipo, :concepto, :monto, NOW(),
                :cod_propiedad, :cod_cliente)");
                $consulta->execute(array(":id_tipo"=>$id_tipo, ":concepto"=>$concepto, ":monto"=>$monto,
                ":cod_propiedad"=>$cod_propiedad, ":cod_cliente"=>$cod_cliente));
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function crear_cierre_caja(){
            try{
                $this->db_connect->query("CALL crear_cierre_caja()");
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function registrar_pago_alquiler(int $cod_cliente, int $cod_propiedad, int $forma_pago, int $mes,
        int $anio, float $interes, int $expensas, int $precio){
            try{
                $consulta = $this->db_connect->prepare("CALL registrar_pago_alquiler(:cod_cliente,
                :cod_propiedad, :forma_pago, :mes, :anio, :interes, :expensas, :precio)");
                $consulta->execute(array(":cod_cliente"=>$cod_cliente, ":cod_propiedad"=>$cod_propiedad,
                ":forma_pago"=>$forma_pago, ":mes"=>$mes, ":anio"=>$anio, ":interes"=>$interes,
                ":expensas"=>$expensas, ":precio"=>$precio));
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function registrar_pago_venta(int $cod_cliente, int $cod_propiedad, int $forma_pago,
        bool $es_financiada, float $comision, int $precio, string $moneda){
            try{
                $consulta = $this->db_connect->prepare("CALL registrar_pago_venta(:cod_cliente,
                :cod_propiedad, :forma_pago, :es_financiada, :comision, :precio, :moneda)");
                $consulta->execute(array(":cod_cliente"=>$cod_cliente, ":cod_propiedad"=>$cod_propiedad,
                ":forma_pago"=>$forma_pago, ":es_financiada"=>$es_financiada, ":comision"=>$comision,
                ":precio"=>$precio, ":moneda"=>$moneda));
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function mostrar_pagos(){
            try{
                return $this->db_connect->query("CALL leer_pagos()")->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }
    }
?>