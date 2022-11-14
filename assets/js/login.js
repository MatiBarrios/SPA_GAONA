const iniciarSesion = () =>{
    event.preventDefault();
    var user = document.getElementById('user').value;
    var pass = document.getElementById('pass').value;
    var form = new FormData();
    form.append('user',user);
    form.append('pass',pass);
    xhr = new XMLHttpRequest();
    xhr.open("POST","./controlador/loginController.php");
    xhr.send(form);
    xhr.responseType = "json";
}