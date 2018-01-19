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

    <title>Acceso Denegado</title>

    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/error/error.css') }}">

    <script>
          window.Laravel = {"csrfToken" : "{{csrf_token()}}" }
    </script>

    <style>
      body{
        /*background: #f44336 !important;*/
        background: #f85032 !important; /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #e73827, #f85032) !important;  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #e73827, #f85032) !important; /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

      }
    </style>

  </head>

  <body>

    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">


          <div class="inner cover">
            <img src="{{ asset('img/warning.png') }}" alt="">
            <p class="display-4">No está autorizado a acceder a esta página.</p>
            <div class="">
              <p class="display-1" id="CuentaAtras"></p>
              <p class="lead">Usted sera redireccionado en unos momentos</p>
            </div>
            <p>Si no es redireccionado a la página haga click <a href="/">aquí</a></p>
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
    <script language="JavaScript">
      var totalTiempo=5;
      var url="/";

      function updateReloj()
      {
          document.getElementById('CuentaAtras').innerHTML = totalTiempo;

          if(totalTiempo==0)
          {
              window.location=url;
          }else{
              totalTiempo-=1;
              setTimeout("updateReloj()",1000);
          }
      }

      window.onload=updateReloj;

    </script>
  </body>
</html>
