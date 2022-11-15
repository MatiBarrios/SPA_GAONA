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
            xhr2.open("GET","./controlador/ControladorEmpleado.php");
            xhr2.send();
            xhr2.onloadend = ()=>{

            }
            var vista = plantilla.replace("NOMBRE_EMPLEADO", json["nombre"]+" "+json["apellido"]);
            vista = vista.replace("CARGO_EMPLEADO", json["cargo"]);
            
            document.getElementById("conteiner").innerHTML = vista;
        }
    }
}