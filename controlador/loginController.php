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
else if (isset($_GET['cargo'])){
    if ($_GET['cargo'] == "Secretaria de comercialización") require_once("../vistas/secretaria.php");
    else if ($_GET['cargo'] == "Agente inmobiliario") require_once("./vistas/login.php");
    else if ($_GET['cargo'] == "Empleado de marketing") require_once("./vistas/login.php");
    else if ($_GET['cargo'] == "Cajera") require_once("./vistas/login.php");
    else if ($_GET['cargo'] == "Jefa de administración") require_once("./vistas/login.php");
    else if ($_GET['cargo'] == "Jefa de comercialización") require_once("./vistas/login.php");
    else if ($_GET['cargo'] == "Administrador") require_once("./vistas/login.php");
    else if ($_GET['cargo'] == "Gerente general") require_once("./vistas/login.php");
}
else require_once("./vistas/login.php");
?>