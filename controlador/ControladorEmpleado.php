<?php
if (isset($_GET['cargo'])){
    //Recomendación: usar el formato JSON para traer la información de los botones
    if ($_GET['cargo'] == "Secretaria de comercialización"){
        //require_once("../vistas/empleados/secretaria.html");
    }
    else if ($_GET['cargo'] == "Agente inmobiliario"){
        //require_once("../vistas/empleados/agente.html");
    }
    else if ($_GET['cargo'] == "Empleado de marketing"){
        //require_once("../vistas/empleados/marketing.html");
    }
    else if ($_GET['cargo'] == "Cajera"){
        //require_once("../vistas/empleados/cajera.html");
    }
    else if ($_GET['cargo'] == "Jefa de administración"){
        //require_once("../vistas/empleados/jefa_administracion.html");
    }
    else if ($_GET['cargo'] == "Jefa de comercialización"){
        //require_once("../vistas/empleados/jefa_comercializacion.html");
    }
    else if ($_GET['cargo'] == "Administrador"){
        //require_once("../vistas/empleados/administrador.html");
    }
    else if ($_GET['cargo'] == "Gerente general"){
        //require_once("../vistas/empleados/gerente.html");
    }
}
else if(isset($_GET['cerrar_sesion'])){
    $opciones = [
        "expires" => -1,
        "path" => substr($_SERVER["PHP_SELF"],0,-36),
        "samesite" => "none"
    ];
    setcookie("empleado", "", $opciones);
}
else require_once("./vistas/plantilla_empleado.html");
?>