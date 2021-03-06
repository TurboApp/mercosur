{{--Verifica si el usuario esta autenticado--}}
@if( auth()->check() && auth()->user()->perfil->perfil == 'admin' )
    <ul class="nav">
        {{-- DASHBOARD --}}
        <li  {{ Request::is('/') ? ' class=active' : ''}}>
            <a href="/">
                <i class="material-icons">dashboard</i>
                <p>Inicio</p>
            </a>
        </li>

        {{--USUARIOS--}}
        <li {{ Request::is('usuarios*') ? ' class=active' : ''}}>
            <a  href="#menuUsuarios" data-toggle="collapse">
                <i class="material-icons">account_circle</i>
                <p>Usuarios <b class="caret"></b></p>
            </a>
            <div class="collapse {{ Request::is('usuarios*')  ? 'in' : ''}}" id="menuUsuarios">
                <ul class="nav">
                    <li {{ Request::is('usuarios*') && !Request::is('usuarios/nuevo') ? ' class=active' : ''}}>
                        <a href="/usuarios/">
                            Todos los usuarios
                        </a>
                    </li>
                    <li {{ Request::is('usuarios/nuevo') ? ' class=active' : ''}}>
                        <a href="/usuarios/nuevo">
                            Agergar usuario
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- FUERZA DE TAREA --}}
        <li {{ Request::is('fuerzas*') ? ' class=active' : ''}}>
            <a  href="#menuFuerzas" data-toggle="collapse">
                <i class="fa fa-users fa-lg" aria-hidden="true"></i>
                <p>Fuerza de tarea <b class="caret"></b></p>
            </a>
            <div class="collapse {{ Request::is('fuerzas*')  ? 'in' : ''}}" id="menuFuerzas">
                <ul class="nav">
                    <li {{ Request::is('fuerzas*') && !Request::is('fuerzas/nuevo') ? ' class=active' : ''}}>
                        <a href="/fuerzas/">
                            Todos los operarios
                        </a>
                    </li>
                    <li {{ Request::is('fuerzas/nuevo') ? ' class=active' : ''}}>
                        <a href="/fuerzas/nuevo">
                            Agregar operario
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- CLIENTES --}}
        <li {{ Request::is('clientes*') ? ' class=active' : ''}}>
            <a  href="#menuClientes" data-toggle="collapse">
                <i class="material-icons">group</i>
                <p>Clientes <b class="caret"></b></p>
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
                            Agregar cliente
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- AGENTES --}}
        <li {{ Request::is('agentes*') ? ' class=active' : ''}}>
            <a  href="#menuAgentes" data-toggle="collapse">
                <i class="fa fa-id-card-o" aria-hidden="true"></i>
                <p>Agentes <b class="caret"></b></p>
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
                            Agregar Agente
                        </a>
                    </li>
              </ul>
          </div>

        </li>

        {{--
        <!-- DESTINOS -->
        <li {{ Request::is('destinos*') ? ' class=active' : ''}}>
            <a  href="#menuDestinos" data-toggle="collapse">
                <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                <p>Destinos
                    <b class="caret"></b>
                </p>
            </a>
            <div class="collapse {{ Request::is('destinos*')  ? 'in' : ''}}" id="menuDestinos">
                <ul class="nav">
                    <li {{ Request::is('destinos*') && !Request::is('destinos/nuevo') ? ' class=active' : ''}}>
                        <a href="/destinos/">
                            Todos los destinos
                        </a>
                    </li>
                    <li {{ Request::is('destinos/nuevo') ? ' class=active' : ''}}>
                        <a href="/destinos/nuevo">
                            Añadir nuevo
                        </a>
                    </li>
                </ul>
            </div>

        </li>
        --}}

        {{-- TRASNPORTES --}}
        <li {{ Request::is('transportes*') ? ' class=active' : ''}}>
            <a  href="#menuTransportes" data-toggle="collapse">
                <i class="fa fa-truck" aria-hidden="true"></i>
                <p>Lineas de transportes <b class="caret"></b></p>
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
                            Agregar transporte
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- SERVICIOS --}}
        <li {{ Request::is('servicios*') ? ' class=active' : ''}}>
            <a href="/servicios/">
                <i class="material-icons">flag</i>
                <p>Servicios</p>
            </a>
        </li>
        
        
        {{-- HERRAMIENTAS  --}}
        <li {{ Request::is('herramientas*') ? ' class=active' : ''}}>
          <a  href="#menuHerramientas" data-toggle="collapse">
              <i class="fa fa-cogs fa-2x" aria-hidden="true"></i>
              <p>Herramientas
                  <b class="caret"></b>
              </p>
          </a>
          <div class="collapse {{ Request::is('herramientas*')  ? 'in' : ''}}" id="menuHerramientas">
              <ul class="nav">
                  {{--  <li {{ Request::is('herramientas*') && !Request::is('herramientas/nuevo') ? ' class=active' : ''}}>
                  </li>  --}}
                  <li {{ Request::is('herramientas/puestos') ? ' class=active' : ''}}>
                      <a href="/herramientas/puestos">
                          Puestos
                      </a>
                  </li>
                  <li {{ Request::is('herramientas/equipos') ? ' class=active' : ''}}>
                      <a href="/herramientas/equipos">
                          Equipos
                      </a>
                  </li>
              </ul>
          </div>
        </li>

        

        {{-- NOTIFICACIONES --}}
        <li {{ Request::is('notificaciones*') ? ' class=active' : ''}}>
            <a href="/notificaciones/">
                <i class="material-icons">notifications</i>
                <p>Notificaciones</p>
            </a>
        </li>
    </ul>
@endif
