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
        
        function hola(){
            event.preventDefault();
            xhr = new XMLHttpRequest();
            xhr.open("GET","./controlador/loginController.php?cargo=Secretaria de comercialización");
            xhr.send();
            xhr.onloadend = ()=>{
                document.getElementById("conteiner").innerHTML = xhr.response;
            }
        }
        const cargarLogin = () =>{    
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
            }

        }
    <?php require_once("./assets/js/login.js"); ?>
    </script>
</footer>

</html>