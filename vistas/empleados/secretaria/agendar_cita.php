<!--Main Navigation-->

<head>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <!--
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    -->
</head>

<div class="row" style="text-align:center; display: flex; justify-content: center;">
  <!--
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Cliente nuevo</h5>
        <p class="card-text"> <img src="https://cdn-icons-png.flaticon.com/512/3126/3126647.png" alt="" width="100px">
        </p>
        <a href="#" class="btn btn-primary">Nuevo</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Cliente de la empresa</h5>
        <p class="card-text"><img src="https://cdn-icons-png.flaticon.com/512/993/993891.png" alt="" width="100px"></p>
        <a href="#" class="btn btn-primary">Nuevo</a>
      </div>
    </div>
  </div>
  -->
  <!--Main Navigation-->
  <?php
  require_once('../../../modelo/conexion.php');
  require_once('../../../modelo/empleado/secretaria_de_comercializacion.php');
  $secretaria = new SecretariaDeComercializacion();
  $agentes = $secretaria->mostrar_agentes();
  $citas = $secretaria->mostrar_citas_no_agendadas();
  ?>
  <form onsubmit="
  event.preventDefault();
  var idCita = document.getElementById('citas').value.split('/')[0];
  var fechayHoraCita = document.getElementById('CitaTime').value.replace('T',' ');
  var agente = document.getElementById('agentes').value;
  formsito = new FormData();
  formsito.append('idCita',idCita);
  formsito.append('fechayHoraCita',fechayHoraCita);
  formsito.append('agente',agente);
  var xhr = new XMLHttpRequest();
  xhr.open('POST','./controlador/ControladorSecretaria.php?agendar_cita');
  xhr.send(formsito);
  xhr.onloadend = ()=>{
    alert(xhr.response);
    document.querySelector('.Agenda').click();
    document.querySelector('.Agendar.cita').click();
  }
  " action="">
    <h3>Cita nuevo cliente</h3>
    <br>
    <h5>1.Seleccione Citas</h5>
    <select onchange="
    var spliit = this.value.split('/')[1];
    spliit = spliit.substring(0,16);
    document.getElementById('CitaTime').value = spliit;
    " id="citas" class="form-select form-control" required>
      <!--Seleccionar Cita-->
      <option disabled selected> -- seleccione cita -- </option>
      <?php
      foreach ($citas as $cita) {
      ?>
        <option value="<?= $cita['id'] ?>/<?= $cita['fechaYHoraCita'] ?>"><?= $cita['nombreCliente'] . ' ' . $cita['apellidoCliente'] ?></option>
      <?php
      }
      ?>
    </select>
    <br>
    <h5>2.Seleccione un dia y horario para la cita</h5>
    <label for="CitaTime"></label>
    <input type="datetime-local" id="CitaTime" name="CitaTime" class="form-control" required>
    <br>
    <h5>3.Seleccione el agente inmobiliario</h5>
    <select class="form-select form-control" id="agentes" required>
      <option disabled selected> -- seleccione agente -- </option>
      <?php
      foreach ($agentes as $agente) {
      ?>
        <option value="<?= $agente['id'] ?>"><?= $agente['nombre'] . ' ' . $agente['apellido'] ?></option>
      <?php
      }
      ?>
    </select>
    <br>
    <input type="submit" value="agendar cita">
  </form>
</div>