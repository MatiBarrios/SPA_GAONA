<?php
if (isset($_COOKIE["empleado"])){
    print_r("<h1>".$_COOKIE["empleado"]."</h1>");
}
else if (isset($_POST['user'])){
    require_once("../modelo/empleado/iniciar_sesion.php");
    $sesion = new IniciarSesion();
    $datos = $sesion->iniciar_sesion($_POST['user'], $_POST['pass']);
    if ($datos != false){
        
        setcookie("empleado","{\"user\":\"".$_POST["user"]."\", \"contrasenia\":\"".$_POST["pass"]."\"}",time()+3600,substr($_SERVER["PHP_SELF"],0,-9));
        //print_r("{\"vista\":\"$datos\"}");
        $cargo = $datos[0];
        print_r(json_encode($cargo));
        //print_r("{\"vista\":\"".$cargo['nombreCargo']."\"}");
    }else{
        print_r("Nombre de usuario y contraseñas errados pete");
    }

}
else require_once("./vistas/login.html");
?>