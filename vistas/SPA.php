<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style type="text/css">
    <?php require_once('./assets/css/login.css');
    ?>
    </style>
</head>
<button onclick="hola()"></button>
<body onload="cargarLogin()">
    <div id="conteiner">

    </div>
</body>
<footer>
    <script>
        const login = `<?php require_once("./controlador/loginController.php"); ?>`;
        const plantilla = `<?php require_once("./controlador/ControladorEmpleado.php"); ?>`;
        
        function hola(){
            event.preventDefault();
            xhr = new XMLHttpRequest();
            xhr.open("GET","./controlador/ControladorEmpleado.php");
            xhr.send();
            xhr.onloadend = ()=>{
                document.getElementById("conteiner").innerHTML = plantilla;
            }
        }
        const cargarLogin = () =>{  
            document.getElementById("conteiner").innerHTML = login;  
            /*
            var cukie = () => {
                let name = "empleado" + "=";
                let decodedCookie = decodeURIComponent(document.cookie);
                let ca = decodedCookie.split(';');
                for(let i = 0; i <ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                    }
                }
                return "";
            }
            if (cukie() == ""){
                document.getElementById("conteiner").innerHTML = login;
                return;
            }*/

        }
    <?php require_once("./assets/js/login.js"); ?>
    </script>
</footer>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</html>