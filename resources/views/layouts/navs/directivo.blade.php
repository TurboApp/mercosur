<ul class="nav">
    @if (auth()->check()) <!--Verifica si el usuario esta autenticado-->
      <!-- DASHBOARD -->
      <li  {{ Request::is('/') ? ' class=active' : ''}}>
          <a href="/">
              <i class="material-icons">dashboard</i>
              <p>Inicio</p>
          </a>
      </li>
      <!--USUARIOS-->
      @if (auth()->user()->hasPerfils(['Administrador']))
        <li {{ Request::is('usuarios*') ? ' class=active' : ''}}>
          <a  href="#menuUsuarios" data-toggle="collapse">
            <i class="material-icons">account_circle</i>
            <p>Usuarios
              <b class="caret"></b>
            </p>
          </a>
          <div class="collapse {{ Request::is('usuarios*')  ? 'in' : ''}}" id="menuUsuarios">
            <ul class="nav">
              <li {{ Request::is('usuarios*') && !Request::is('usuarios/nuevo') ? ' class=active' : ''}}>
                <a href="/usuarios/">
                  Todos los Usuarios
                </a>
              </li>
              <li {{ Request::is('usuarios/nuevo') ? ' class=active' : ''}}>
                <a href="/usuarios/nuevo">
                  Añadir nuevo
                </a>
              </li>
            </ul>
          </div>
        </li>
      @endif
      <!--USUARIOS-->
      {{-- FUERZA DE TAREA --}}
      <li {{ Request::is('fuerzas*') ? ' class=active' : ''}}>
          <a  href="#menuFuerzas" data-toggle="collapse">
              <i class="fa fa-users fa-lg" aria-hidden="true"></i>
              <p>Fuerza de Tarea
                  <b class="caret"></b>
              </p>
          </a>
          <div class="collapse {{ Request::is('fuerzas*')  ? 'in' : ''}}" id="menuFuerzas">
              <ul class="nav">
                  <li {{ Request::is('fuerzas*') && !Request::is('fuerzas/nuevo') ? ' class=active' : ''}}>
                      <a href="/fuerzas/">
                          Todos los Operarios
                      </a>
                  </li>
                  <li {{ Request::is('fuerzas/nuevo') ? ' class=active' : ''}}>
                      <a href="/fuerzas/nuevo">
                          Añadir nuevo
                      </a>
                  </li>
              </ul>
          </div>
      </li>
      <!-- CLIENTES -->
      <li {{ Request::is('clientes*') ? ' class=active' : ''}}>
          <a  href="#menuClientes" data-toggle="collapse">
              <i class="material-icons">group</i>
              <p>Clientes
                  <b class="caret"></b>
              </p>
          </a>
          <div class="collapse {{ Request::is('clientes*')  ? 'in' : ''}}" id="menuClientes">
              <ul class="nav">
                  <li {{ Request::is('clientes*') && !Request::is('clientes/nuevo') ? ' class=active' : ''}}>
                      <a href="/clientes/">
                          Todos los clientes
                      </a>
                  </li>
                  <li {{ Request::is('clientes/nuevo') ? ' class=active' : ''}}>
                      <a href="/clientes/nuevo">
                          Añadir nuevo
                      </a>
                  </li>
              </ul>
          </div>
      </li>
      <!-- AGENTES -->
      <li {{ Request::is('agentes*') ? ' class=active' : ''}}>
          <a  href="#menuAgentes" data-toggle="collapse">
              <i class="fa fa-id-card-o" aria-hidden="true"></i>
              <p>Agentes
                  <b class="caret"></b>
              </p>
          </a>
          <div class="collapse {{ Request::is('agentes*')  ? 'in' : ''}}" id="menuAgentes">
              <ul class="nav">
                  <li {{ Request::is('agentes*') && !Request::is('agentes/nuevo') ? ' class=active' : ''}}>
                      <a href="/agentes/">
                          Todos los agentes
                      </a>
                  </li>
                  <li {{ Request::is('agentes/nuevo') ? ' class=active' : ''}}>
                      <a href="/agentes/nuevo">
                          Añadir nuevo
                      </a>
                  </li>
              </ul>
          </div>

    </li>
    
    <!-- TRASNPORTES -->
    <li {{ Request::is('transportes*') ? ' class=active' : ''}}>
        <a  href="#menuTransportes" data-toggle="collapse">
            <i class="fa fa-truck" aria-hidden="true"></i>
            <p>Lineas de transpotes
                <b class="caret"></b>
            </p>
        </a>
        <div class="collapse {{ Request::is('transportes*')  ? 'in' : ''}}" id="menuTransportes">
            <ul class="nav">
                <li {{ Request::is('transportes*') && !Request::is('transportes/nuevo') ? ' class=active' : ''}}>
                    <a href="/transportes/">
                        Todos los trasnportes
                    </a>
                </li>
                <li {{ Request::is('transportes/nuevo') ? ' class=active' : ''}}>
                    <a href="/transportes/nuevo">
                        Añadir nuevo
                    </a>
                </li>
            </ul>
        </div>
      </li>
      
      

      <!-- NOTIFICACIONES -->
        <li {{ Request::is('notificaciones*') ? ' class=active' : ''}}>
            <a href="/notificaciones/">
                <i class="material-icons">notifications</i>
                <p>Notificaciones</p>
            </a>
        </li>
    @endif

</ul>
