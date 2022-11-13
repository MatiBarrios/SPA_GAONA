<?php
if (isset($_POST['user'])){
    require_once("../modelo/empleado/iniciar_sesion.php");
    $sesion = new IniciarSesion();
    $datos = $sesion->iniciar_sesion($_POST['user'], $_POST['pass']);
    if ($datos != false){
        setcookie("empleado","{\"user\":\"".$_POST["user"]."\", \"contrasenia\":\"".$_POST["pass"]."\"}");
        print_r("{\"vista\":\"asdasd\"}");
    }else{
        print_r("fallo al iniciar sesion");
    }

}
else require_once("./vistas/login.html");
?>