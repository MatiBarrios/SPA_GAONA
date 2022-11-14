const procesarJSON = (json) =>{
    try{
        json = JSON.parse(json);
        var vista = plantilla.replace("NOMBRE_EMPLEADO", json["nombre"]+" "+json["apellido"]);
        vista = vista.replace("CARGO_EMPLEADO", json["cargo"]);
        document.getElementById("conteiner").innerHTML = vista;
        return true;
    }catch{
        document.getElementById("conteiner").innerHTML = panel_login;
        return false;
    }
}

const iniciarSesion = () =>{
    event.preventDefault();
    var user = document.getElementById('user');
    var pass = document.getElementById('pass');
    var form = new FormData();
    var xhr = new XMLHttpRequest();
    form.append('user', user.value);
    form.append('pass', pass.value);
    xhr.open("POST","./controlador/loginController.php");
    xhr.send(form);
    xhr.onloadend = ()=>{
        if(!procesarJSON(xhr.response)){
            alert(xhr.response);
        }
    }
}