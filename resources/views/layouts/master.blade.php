<!doctype html>
<html lang="es">

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

    <script>
          window.Laravel = {"csrfToken" : "{{csrf_token()}}" }
    </script>
    <style>

    .Descarga, .descarga{
        background:#f44336 !important;
        color:#fff !important;
    }
    .Carga, .carga{
        background:#e91e63 !important;
        color:#fff !important;
    }
    .Trasbordo, .trasbordo{
        background:#9c27b0  !important;
        color:#fff !important;
    }

    </style>
</head>
<body>
<div class="loader" >
    <svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
        <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
    </svg>
</div>
<div id="app">

    <div class="wrapper  grey lighten-2">
        <div class="sidebar" data-active-color="light-blue-darken-3" data-background-color="black" data-image="/img/sidebar-1.jpg">
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
                        @if (auth()->user()->url_avatar)
                          <img src="{{url(auth()->user()->url_avatar)}}" />
                        @else
                          <img src="{{asset('img/user-default.jpg')}}" alt="...">
                        @endif
                    </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                             <span class="text-uppercase">{{auth()->user()->user}}</span>
                            <b class="caret"></b>
                        </a>
                        <div class="collapse" id="collapseExample" >
                          <form id="salir"  action="{{route('logout')}}" method="post">
                            <ul class="nav">
                                <li>
                                    <a href="/perfil/{{auth()->user()->id}}">Mi Perfil</a>
                                </li>
                                <li>
                                    {{ csrf_field() }}
                                    <a id="logout" href="#">Salir</a>
                                </li>
                            </ul>
                          </form>
                        </div>
                    </div>
                </div><!-- ./user -->
                <!-- Navegación -->

                @includeif('layouts.navs.'.auth()->user()->perfil->perfil)

            </div>
        </div><!-- ./sidebar -->
        <!-- SECCION DE CONTENIDO PRINCIPAL -->
        {{--  <div class="main-panel">  --}}
        <div class="main-panel ">
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
                                <a href="{{ url()->previous() }}" class="dropdown-toggle" title="Atras">
                                    <i class="material-icons">arrow_back</i>
                                    <p class="hidden-lg hidden-md">Atras</p>
                                </a>
                            </li>
                            <li>
                                <a href="/" class="dropdown-toggle" title="Dashboard" >
                                    <i class="material-icons">dashboard</i>
                                    <p class="hidden-lg hidden-md">Inicio</p>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Notificaciones">
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
                                <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown" title="Mi perfil">
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


    <script src="/js/app.js"></script>
    <script src="/js/scripts.js"></script>
    <!-- datepicker en español -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/es.js"></script>
    @stack('scripts')
    <script >
        $(window).on("load",function() {
            $(".loader").fadeOut("slow");
        })
    </script>
    <script>
        (function(){
            document.getElementById("logout").onclick=function()
            {
                document.getElementById("salir").submit();
            }
        }());
    </script>
</body>
</html>
