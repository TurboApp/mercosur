<ul class="nav">
    @if (auth()->check()) <!--Verifica si el usuario esta autenticado-->
      <!-- DASHBOARD -->
      <li  {{ Request::is('/') ? ' class=active' : ''}}>
          <a href="/">
              <i class="material-icons">dashboard</i>
              <p>Inicio</p>
          </a>
      </li>

    {{-- TRAFICO --}}
    <li {{ Request::is('trafico*') ? ' class=active' : ''}}>
        <a  href="#menuTrafico" data-toggle="collapse">
            <i class="material-icons">traffic</i>
            <p>Trafico
                <b class="caret"></b>
            </p>
        </a>
        <div class="collapse {{ Request::is('trafico*')  ? 'in' : ''}}" id="menuTrafico">
            <ul class="nav">
                <li {{ Request::is('trafico*') && !Request::is('trafico/nuevo*') && !Request::is('trafico/coordinacion*') ? ' class=active' : ''}}>
                    <a href="/trafico/">
                        Todos los servicios
                    </a>
                </li>
                <li {{ Request::is('trafico/nuevo*') ? ' class=active' : ''}}>
                    <a href="/trafico/nuevo">
                        Nuevo Servicio
                    </a>
                </li>
                <li {{ Request::is('trafico/coordinacion*') ? ' class=active' : ''}}>
                    <a href="/trafico/coordinacion">
                        Coordinación
                    </a>
                </li>
            </ul>
        </div>

    </li>
    @endif

</ul>
