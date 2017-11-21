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
    {{-- #Color tipo de servicio --}}
    .Descarga, .descarga{
        background:#c2185b  !important;
        color:#fff !important;
    }
    .Carga, .carga{
        background:#7b1fa2 !important;
        color:#fff !important;
    }
    .Trasbordo, .trasbordo{
        background:#512da8  !important;
        color:#fff !important;
    }
    .Otros-servicios, .otros-servicios{
        background:#303f9f   !important;
        color:#fff !important;
    }

    {{-- #Color status maniobra  --}}
    .para-asignar, .PARA-ASIGNAR{
        background: #9e9e9e  !important;
        color: #fff !important;
    }
    .asignado, .ASIGNADO{
        background: #009688  !important;
        color: #fff !important;
    }
    .en-proceso, .EN-PROSESO{
        background: #ff8f00  !important;
        color: #fff !important;
    }
    .en-pausa, .EN-PAUSA{
        background: #8d6e63 !important;
        color: #fff !important;
    }
    .finalizado, .FINALIZADO{
        background: #64dd17 !important;
        color: #fff !important;
    }
    .cancelado, .CANCELADO{
        background: #f44336 !important;
        color: #fff !important;
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
     <div class="wrapper ">
        <div class="sidebar" data-active-color="light-blue-darken-3" data-background-color="black" data-image="/img/sidebar-3.jpg">
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
                          <img src="{{Storage::url(auth()->user()->url_avatar)}}" />
                        @else
                          {{-- <img src="{{asset('img/user-default.jpg')}}" alt="..."> --}}
                          <img src="{{asset('img/'.str_replace(" ","-",auth()->user()->perfil->perfil).'.png')}}" alt="..." class="img img-responsive img-circle z-depth-3" onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
                        @endif
                    </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseProfile" class="collapsed">
                            <p class="text-uppercase">{{auth()->user()->user}}
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse {{ Request::is('perfil*')  ? 'in' : ''}}" id="collapseProfile" >
                          <form id="salir"  action="{{route('logout')}}" method="post">
                            <ul class="nav">
                                <li {{ Request::is('perfil/*') ? ' class=active' : ''}}>
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
        <div class="main-panel">
            <!-- NAVEGACION -->
            
            {{--  <nav class="navbar navbar-transparent navbar-absolute">  --}}
            <nav class="navbar grey lighten-3 navbar-absolute ">
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
                        
                        <a class="navbar-brand" href="#"> 
                           @yield('title')
                        </a>
                        
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
                                <a href="/perfil/{{auth()->user()->id}}" title="Mi perfil">
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

            <nav class="nav grey lighten-3 " style="margin-top:71px;border-top:1px solid #e0e0e0;">
                <div class="container-fluid">
                    <div class="col-sm-6">
                        @yield('breadcrump')
                    </div>
                    <div class="col-sm-6 text-right hidden-xs" style="padding:8px 12px; ">
                        <i class="fa fa-calendar" aria-hidden="true"></i> {{  ucfirst( Date::instance(Carbon\Carbon::now())->format('l j \\d\\e F \\d\\e Y') ) }}
                    </div>
                </div>
            </nav>

            
            {{-- CONTENIDO --}}
                        
            <div class="content" style="padding-top:0;">
                <div class="container-fluid">
                    
                    
                    @yield('content')

                </div>
            </div><!-- ./content -->
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
