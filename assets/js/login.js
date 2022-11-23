//Aqui se procesa el json, basicamente se compara si el servidor retorna algo que pueda ser tomado como json
//en caso de que no se entiende que fallo el inicio de sesion que es para lo que esta hecho y redibuja el jo
const procesarJSON = (json) =>{
    try{
        json = JSON.parse(json);
        return json;
    }catch{
        document.getElementById("conteiner").innerHTML = login;
        return false;
    }
}

const sesion = procesarJSON(login);
var vista_ver1 = plantilla;

const iniciarSesion = (usuario, contrasenia) =>{
    event.preventDefault();
    var form = new FormData();
    var xhr = new XMLHttpRequest();
    form.append('user', usuario);
    form.append('pass', contrasenia);
    xhr.open("POST","./controlador/loginController.php");
    xhr.send(form);
    xhr.onloadend = ()=>{
        var json = procesarJSON(xhr.response);
        
        if(json == false){
            alert(xhr.response);
        }
        else{
            var xhr2 = new XMLHttpRequest();
            xhr2.open("GET","./controlador/ControladorEmpleado.php?cargo="+json["cargo"]);
            xhr2.responseType = "json";
            xhr2.send();
            xhr2.onloadend = ()=>{
                var partes_vista = plantilla.split("<!-- Boton navbar -->");
                vista_ver1 = partes_vista[0];
                navbar = Object.keys(xhr2.response);

                for(var x=0; x<navbar.length; x++){
                    vista_ver1 += partes_vista[1].replace("BOTON_NAVBAR", navbar[x]).
                    replace("CODIGO_BOTON", "procesasVista("+JSON.stringify(xhr2.response)+", "+x+", 0)");
                }

                vista_ver1 += partes_vista[2];
                vista_ver1 = vista_ver1.replace("NOMBRE_EMPLEADO", json["nombre"]+" "+json["apellido"]);
                vista_ver1 = vista_ver1.replace("CARGO_EMPLEADO", json["cargo"]);
                document.getElementById("conteiner").innerHTML = vista_ver1;
                procesasVista(xhr2.response, 0, 0);
            }
        }
    }
}

const procesasVista = (botones, btn_navbar, btn_sidebar) =>{
    var partes_vista = vista_ver1.split("<!-- Boton sidebar -->");
    var vista = partes_vista[0];
    navbar = Object.keys(botones);
    sidebar = Object.keys(botones[navbar[btn_navbar]]);

    for(var x=0; x<sidebar.length; x++){
        vista += partes_vista[1].replace("BOTON_SIDEBAR", sidebar[x]).
        replace("LOGO", botones[navbar[btn_navbar]][sidebar[x]][1]).
        replace("CODIGO_BOTON", "procesasVista("+JSON.stringify(botones)+", "+btn_navbar+", "+x+")");
    }

    vista += partes_vista[2];
    document.getElementById("conteiner").innerHTML = vista;
    var xhr = new XMLHttpRequest();
    xhr.open("GET",botones[navbar[btn_navbar]][sidebar[btn_sidebar]][0]);
    xhr.send();
    xhr.onloadend = ()=>{
        document.getElementById("subcontainer").innerHTML = xhr.response;
    }
}