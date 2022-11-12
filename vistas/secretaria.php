<!--Main Navigation-->

<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <style><?php require_once('../assets/css/secretaria.css'); ?></style>
</head>
<header>
    <!-- Sidebar -->
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-transparent">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4 ">
                <a href="#" class="list-group-item list-group-item-action py-2 ripple bg-transparent" aria-current="true">
                    <i class="material-icons" style="margin-top:5%;">history</i><span>Actualizar datos</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action py-2 ripple bg-transparent">
                <i class="material-icons"style="margin-top:5%;" >person_add</i><span>Nuevo cliente</span>
                </a>
               
            </div>
        </div>
    </nav>
    <!-- Sidebar -->

    <!-- Navbar -->
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top" style="background: rgb(113,212,232);
background: linear-gradient(308deg, rgba(113,212,232,0.5049370089832808) 18%, rgba(2,0,36,0) 88%) !important;">
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Toggle button -->
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Brand -->
            <a class="navbar-brand" href="#">
                <img src="https://domus-inmobiliaria.com/wp-content/uploads/2020/03/DOMUS-_logo_perfil_270.png" height="65" width="" alt="" loading="lazy" />
            </a>
            <!-- Botones -->
            <form class="d-none d-md-flex input-group w-auto my-auto">

                <button type="button" class="btn" data-mdb-ripple-color="#ffffff">&nbsp;<i class="material-icons">person</i>&nbsp;Clientes</button>
                <button type="button" class="btn" data-mdb-ripple-color="#ffffff">&nbsp;<i class="material-icons">calendar_month</i>&nbsp;Agenda</button>
                <button type="button" class="btn" data-mdb-ripple-color="#ffffff">&nbsp;<i class="material-icons">help</i>Solicitudes&nbsp;</button>

            </form>

            <!-- Right links -->
            <ul class="navbar-nav ms-auto d-flex flex-row">
                <!-- Avatar -->
                <span style="margin-top:15%; margin-right:5%;">Secretaria</span>
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center" href="#" id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                        <img src="https://e7.pngegg.com/pngimages/964/1014/png-clipart-company-secretary-computer-icons-grupo-intactta-others-miscellaneous-company.png" class="rounded-circle" height="60" alt="" loading="lazy" />
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Mi perfil</a></li>
                        <li><a class="dropdown-item" href="#">Configuración</a></li>
                        <li><a class="dropdown-item" href="#">Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
</header>
<!--Main Navigation-->

<!--Main layout-->
<main style="margin-top: 58px">
    <div class="container pt-4">

    </div>
</main>
<!--Main layout-->