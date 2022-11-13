
<!--Main Navigation-->

<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        body {
            background-color: #fbfbfb;
        }

        @media (min-width: 991.98px) {
            main {
                padding-left: 240px;
            }
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding: 58px 0 0;
            /* Height of navbar */
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
            width: 240px;
            z-index: 600;
            background: rgb(113, 212, 232);
            background: linear-gradient(308deg, rgba(113, 212, 232, 0.2976540958180147) 18%, rgba(2, 0, 36, 0) 88%)
             !important;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                width: 100%;
            }
        }

        .sidebar .active {
            border-radius: 5px;
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: 0.5rem;
            overflow-x: hidden;
            overflow-y: auto;
            /* Scrollable contents if viewport is shorter than content. */
        }

        .list-group-item:hover {
            background-color: lightblue !important;
            color: black;
        }

        .btn:hover {
            background-color: lightblue !important;
            color: black;
        }
    </style>
</head>
<header>
    <!-- Sidebar -->
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-transparent">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4 ">
                <a href="#" class="list-group-item list-group-item-action py-2 ripple bg-transparent" aria-current="true">
                    <i class="material-icons" style="margin-top:5%;">house</i><span>Catalogo</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action py-2 ripple bg-transparent">
                <i class="material-icons"style="margin-top:5%;" >menu</i><span>Lista Propiedades</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action py-2 ripple bg-transparent">
                <i class="material-icons" style="margin-top:5%;">add</i><span><span>Nueva propiedad</span>
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

                
                <button type="button" class="btn" data-mdb-ripple-color="#ffffff">&nbsp;<i class="material-icons">calendar_month</i>&nbsp;Agenda</button>
                <button type="button" class="btn" data-mdb-ripple-color="#ffffff">&nbsp;<i class="material-icons">real_estate_agent</i>Propiedades&nbsp;</button>

            </form>

            <!-- Right links -->
            <ul class="navbar-nav ms-auto d-flex flex-row">
                <!-- Avatar -->
                <span style="margin-top:10%; margin-right:0%;">Agente Inmobiliario</span>
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center" href="#" id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                        <img src="https://cdn-icons-png.flaticon.com/512/69/69889.png" class="rounded-circle" height="60" alt="" loading="lazy" />
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