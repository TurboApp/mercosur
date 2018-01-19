<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="../../favicon.ico">

    <title>Pagina no Encontrada</title>

    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/error/error.css') }}">
    <script>
          window.Laravel = {"csrfToken" : "{{csrf_token()}}" }
    </script>

  </head>

  <body>

    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">APP MERCOSUR</h3>
              <nav>
                <ul class="nav masthead-nav">
                  <li class="active"><a href="/">Inicio</a></li>
                  <li><a href="{{ url()->previous() }}">Regresar</a></li>
                  <li>
                    <form id="salir"  action="{{route('logout')}}" method="post">
                      {{ csrf_field() }}
                      <a id="logout" href="#">Salir</a>
                    </form>
                  </li>
                </ul>
              </nav>
            </div>
          </div>

          <div class="inner cover">
            <h1 class="display-1">Upsss!!!</h1>
            <p class="display-4">Lo sentimos, pero la pagina que estas buscando no existe.</p>
            <p class="lead">
            </p>
          </div>

        </div>

      </div>

    </div>
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
