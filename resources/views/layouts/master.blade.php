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
    
    <!-- Bootstrap core CSS     -->
    <link href="/css/bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="/css/material-dashboard.css" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="/css/mercosur.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/font-roboto.css" />
    <link href="/css/font-material-icons.css" rel="stylesheet">
</head>

<body>
    <div id="app" class="wrapper">
      <!-- SECCION SIDEBAR -->
        <div class="sidebar" data-active-color="blue" data-background-color="black" >
            <!--
        Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
        Tip 2: you can also add an image using data-image tag
        Tip 3: you can change the color of the sidebar with data-background-color="white | black"
    -->
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
                                <a href="/" class="dropdown-toggle" data-toggle="dropdown" rel="tooltip" data-placement="bottom" title="Inicio">
                                    <i class="material-icons">dashboard</i>
                                    <p class="hidden-lg hidden-md">Inicio</p>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" rel="tooltip" data-placement="bottom" title="Notificaciones">
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
    
</body>
<!--   Core JS Files   -->
<!--<script src="/js/app.js" type="text/javascript"></script>-->
<script src="/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/js/material.min.js" type="text/javascript"></script>
<script src="/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="/js/jquery.validate.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="/js/moment.min.js"></script>
<!--  Charts Plugin -->
<script src="/js/chartist.min.js"></script>
<!--  Plugin for the Wizard -->
<script src="/js/jquery.bootstrap-wizard.js"></script>
<!--  Notifications Plugin    -->
<script src="/js/bootstrap-notify.js"></script>
<!--   Sharrre Library    -->
<script src="/js/jquery.sharrre.js"></script>
<!-- DateTimePicker Plugin -->
<script src="/js/bootstrap-datetimepicker.js"></script>
<!-- Vector Map plugin -->
<script src="/js/jquery-jvectormap.js"></script>
<!-- Sliders Plugin -->
<script src="/js/nouislider.min.js"></script>
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js"></script>
<!-- Select Plugin -->
<script src="/js/jquery.select-bootstrap.js"></script>
<!--  DataTables.net Plugin    -->
<script src="/js/jquery.datatables.js"></script>
<!-- Sweet Alert 2 plugin -->
<script src="/js/sweetalert2.js"></script>
<!--	Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="/js/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin    -->
<script src="/js/fullcalendar.min.js"></script>
<!-- TagsInput Plugin -->
<script src="/js/jquery.tagsinput.js"></script>
<!-- Material Dashboard javascript methods -->
<script src="/js/material-dashboard.js"></script>
<script src="/js/typeahead.min.js"></script>
<!-- Axios -->
<script src="/js/vue.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>


<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="/js/demo.js"></script>
@stack('scripts')
</html>
