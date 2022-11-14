<?php
if (isset($_POST['user'])){
    require_once("../modelo/empleado/iniciar_sesion.php");
    $sesion = new IniciarSesion();
    $datos = $sesion->iniciar_sesion($_POST['user'], $_POST['pass']);

    if ($datos != false){
        $opciones = [
            "expires" => time()+3600,
            "path" => substr($_SERVER["PHP_SELF"],0,-32),
            "samesite" => "none"
        ];
        $datos[0]["usuario"] = $_POST['user'];
        $datos[0]["contrasenia"] = $_POST['pass'];
        setcookie("empleado", json_encode($datos[0]), $opciones);
        echo json_encode($datos[0]);
    }else{
        echo "Nombre de usuario y/o contraseña incorrectos";
    }

}
else if (isset($_COOKIE["empleado"])){
    echo $_COOKIE["empleado"];
}
?>