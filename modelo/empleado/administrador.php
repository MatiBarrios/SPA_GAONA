<?php
    require_once("../modelo/conexion.php");

    class Administrador extends Conexion{
        public function __construct()
        {
            parent::conectar_root();
        }

        public function borrar_usuario(string $usuario){
            try{
                $consulta = $this->db_connect->prepare("DELETE FROM empleado WHERE usuario = :usuario");
                $consulta->execute(array(":usuario"=>$usuario));
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function nuevo_usuario(string $nombre, string $apellido, int $dni, string $cargo,
        string $correo, string $usuario, string $contrasenia, int $tel1, int $tel2 = null){
            try{
                $consulta = $this->db_connect->prepare("CALL nuevo_empleado(:nombre, :apellido, :dni, :cargo,
                :correo, :usuario, :contrasenia, :tel1, :tel2)");
                $consulta->execute(array(":nombre"=>$nombre, ":apellido"=>$apellido, ":dni"=>$dni,
                ":cargo"=>$cargo, ":correo"=>$correo, ":usuario"=>$usuario, ":contrasenia"=>$contrasenia,
                ":tel1"=>$tel1, ":tel2"=>$tel2));
                return $consulta->fetch()[0];
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public function mostrar_usuarios(){
            try{
                return $this->db_connect->query("SELECT nombre, apellido, dni, usuario, correo, cargo,
                telefono, telefonoAlternativo FROM empleado")->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }
    }
?>