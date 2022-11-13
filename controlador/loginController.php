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
    if ($_GET['cargo'] == "Secretaria de comercialización") require_once("../vistas/empleados/secretaria.html");
    else if ($_GET['cargo'] == "Agente inmobiliario") require_once("../vistas/empleados/agente.html");
    else if ($_GET['cargo'] == "Empleado de marketing") require_once("../vistas/empleados/marketing.html");
    else if ($_GET['cargo'] == "Cajera") require_once("../vistas/empleados/cajera.html");
    else if ($_GET['cargo'] == "Jefa de administración") require_once("../vistas/empleados/jefa_administracion.html");
    else if ($_GET['cargo'] == "Jefa de comercialización") require_once("../vistas/empleados/jefa_comercializacion.html");
    else if ($_GET['cargo'] == "Administrador") require_once("../vistas/empleados/administrador.html");
    else if ($_GET['cargo'] == "Gerente general") require_once("../vistas/empleados/gerente.html");
}
else require_once("./vistas/login.php");
?>