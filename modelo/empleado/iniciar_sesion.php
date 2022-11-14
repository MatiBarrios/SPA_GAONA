<?php
    require_once("../modelo/conexion.php");

    class IniciarSesion extends Conexion{
        public function __construct()
        {
            parent::conectar_root();
        }

        public function iniciar_sesion($usuario, $contrasenia){
            try{
                $consulta = $this->db_connect->prepare("SELECT nombre,apellido,cargo.nombreCargo FROM empleado INNER JOIN cargo on empleado.idCargo= cargo.id WHERE usuario = :usuario
                AND contrasenia = MD5(:contrasenia)");
                $consulta->execute(array(":usuario"=>$usuario, ":contrasenia"=>$contrasenia));
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

                if(count($resultado) == 0){
                    return false;
                }
                else return $resultado;
            }
            catch(Exception $e){
                echo $e;
            }
        }
    }
?>