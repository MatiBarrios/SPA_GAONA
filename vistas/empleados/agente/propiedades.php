<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        .card {
            margin: 5px;
        }

        .mostrar:hover {
            background-color: lightcyan !important;
        }

        .ocultar:hover {
            background-color: bisque !important;
        }
        .carousel-item{
            height: 400px;
        }
        .carousel-item.active{
            display: flex;
            align-items: center;
        }
    </style>
</head>
<?php ?>
<div style="display:flex; flex-wrap:wrap; justify-content:center;">
    <?php
    require_once('../../../modelo/conexion.php');
    require_once('../../../modelo/empleado/agente_inmobiliario.php');
    $agentes = new AgenteInmobiliario();
    $propiedades = $agentes->mostrar_propiedades_todas();
    foreach ($propiedades as $propiedad) {
    ?>
        <div class="card" style="width: 18rem;">
            <div class="card-title">
                <h5>
                    <?php
                    if (!empty($propiedad["precioAlquiler"])) {
                    ?>
                        Alquiler: $<?= $propiedad["precioAlquiler"] ?>
                    <?php
                    }
                    if (!empty($propiedad["precioVenta"])) {
                    ?>
                        &nbsp; Venta: $<?= $propiedad["precioVenta"] ?>
                    <?php
                    }
                    ?>
                </h5>
            </div>
            <div class="card-subtitle">
                <p class="card-text"><?= $propiedad["direccion"] ?>, <?= $propiedad["localidad"] ?>, <?= $propiedad["provincia"] ?></p>
            </div>
            <!-- aca comienza la imagen -->
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner"><!-- este es el conteiner -->
            <?php 
            $imgsPropiedad = $agentes->mostrar_imagenes_propiedad($propiedad["codPropiedad"]);
                foreach ($imgsPropiedad as $img){
                ?>
                    <div class="carousel-item active">
                        <img src="<?= $img['enlace'] ?>" class="d-block w-100" alt="...">
                    </div>
                <?php } ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden"></span>
                </button>
            </div>
            <!-- comentario de freddy 
            <img class="card-img-top" src="https://i.pinimg.com/736x/f7/7d/dc/f77ddc342e337d70a186f8ed202ad80a.jpg" alt="Card image cap" width="200px">
                -->
            <!-- aca termina la imagen -->
            <div class="card-body">
                <!-- <p class="card-text">Ubicación o Descripción de la Casa XD</p> -->
                <!-- Estado de la propiedad, pintado de azul o (info) en caso de disponibilidad, o de rojo (danger) en caso contrario -->
                <?php 
                if (!empty($propiedad["precioVenta"]) || !empty($propiedad["precioAlquiler"])) {
                ?>
                <h5 class="bg-info"> Disponible </h5>
                <?php }
                else { ?>
                <h5 class="bg-danger"> No disponible </h5>
                <?php } ?>
            </div>
            <button onclick="var tarjeta = event.target.parentElement, div = tarjeta.querySelector('.info-propiedad');

        if(div.style.display == 'none'){
            div.style.display = 'block';
            event.target.innerText = 'Ocultar';
            event.target.className = 'ocultar';
            tarjeta.style.marginBottom = '-'+div.clientHeight+'px';
        }
        else{
            div.style.display = 'none';
            event.target.innerText = 'Leer más';
            event.target.className = 'mostrar';
            tarjeta.style.marginBottom = '5px';
        }" style="border-style:none; background-color:white;" class="mostrar">Leer más</button>
            <div class="info-propiedad" style="display: none; z-index: 1; background-color:white;">
                <br>
                Tipo: <?= $propiedad["tipo"] ?>
                <br>
                <br>
                Baños: <?= $propiedad["numBanios"] ?> - Suites: <?= $propiedad["numSuites"] ?>
                <br>
                <br>
                Espacios: <?= $propiedad["espacios"] ?>
                <br>
                <br>
                Antiguedad: <?= $propiedad["antiguedad"]." años" ?>
                <br>
                <br>
                Artefactos: <?= $propiedad["artefactos"] ?>
                <br>
                <br>
                Servicios adheridos: <?= $propiedad["servicios"] ?>
            </div>
        </div>
    <?php } ?>
</div>