<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>MERCOSUR app - @yield('title')</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mercosur.css') }}">

</head>

<body>
<div id="app">
    <div class="wrapper">
        <div class="sidebar" data-active-color="blue" data-background-color="black" >
            <div class="logo">
                <a href="/" class="simple-text">
                    MERCOSUR <sub>app</sub>
                </a>
            </div>
            <div class="logo logo-mini">
                <a href="/" class="simple-text">
                    MS
                </a>
            </div>
            <div class="sidebar-wrapper">
                <!-- usuario -->
                <div class="user">
                    <div class="photo">
                        <img src="/img/default-avatar.png" />
                    </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                            Nombre de usuario
                            <b class="caret"></b>
                        </a>
                        <div class="collapse" id="collapseExample" >
                            <ul class="nav">
                                <li>
                                    <a href="#">Mi Perfil</a>
                                </li>
                                <li>
                                    <a href="#">Configuración</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div><!-- ./user -->
                <!-- Navegación -->
                <!-- 'layouts.navs.{perfil}' -->
                @includeif('layouts.navs.admin')

            </div>
        </div><!-- ./sidebar -->
        <!-- SECCION DE CONTENIDO PRINCIPAL -->
        <div class="main-panel">
            <!-- NAVEGACION -->
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                            <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                            <i class="material-icons visible-on-sidebar-mini">view_list</i>
                        </button>
                    </div>
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"> @yield('title') </a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="/" class="dropdown-toggle" data-toggle="dropdown" >
                                    <i class="material-icons">dashboard</i>
                                    <p class="hidden-lg hidden-md">Inicio</p>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                                    <i class="material-icons">notifications</i>
                                    <span class="notification">5</span>
                                    <p class="hidden-lg hidden-md">
                                        Notifications
                                        <b class="caret"></b>
                                    </p>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#">Mike John responded to your email</a>
                                    </li>
                                    <li>
                                        <a href="#">You have 5 new tasks</a>
                                    </li>
                                    <li>
                                        <a href="#">You're now friend with Andrew</a>
                                    </li>
                                    <li>
                                        <a href="#">Another Notification</a>
                                    </li>
                                    <li>
                                        <a href="#">Another One</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown" rel="tooltip" data-placement="bottom" title="Mi perfil">
                                    <i class="material-icons">person</i>
                                    <p class="hidden-lg hidden-md">Profile</p>
                                </a>
                            </li>
                            <li class="separator hidden-lg hidden-md"></li>
                        </ul>
                        @yield('nav-top')

                    </div>
                </div>
            </nav>
            <!-- CONTENIDO -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div><!-- ./content -->
            <!-- pie de pagina -->
            @include('layouts.partials.footer')
        </div>
    </div>
</div>
</body>
    <script src="/js/app.js"></script>
    <script src="/js/scripts.js"></script>
    
    
    @stack('scripts')
</html>
