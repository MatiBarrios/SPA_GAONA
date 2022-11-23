<?php
    require_once("../modelo/conexion.php");
    require_once("../modelo/empleado/secretaria_de_comercializacion.php");

    if(isset($_GET["agendar_cita"])){
        $fecha = new DateTime($_POST["fechayHoraCita"]);
        $secretaria = new SecretariaDeComercializacion();
        $secretaria->asignar_cita_agente($_POST["idCita"], $_POST["agente"], $fecha);
        echo "Cita agendada con éxito";
    }
?>
