{{--Verifica si el usuario esta autenticado--}}
@if( auth()->check() && auth()->user()->perfil->perfil == 'go' )
    <ul class="nav">
        {{-- DASHBOARD --}}
        <li  {{ Request::is('/') ? ' class=active' : ''}}>
            <a href="/">
                <i class="material-icons">dashboard</i>
                <p>Inicio</p>
            </a>
        </li>

        {{-- FUERZA DE TAREA --}}
        <li {{ Request::is('operarios*') || Request::is('coordinadores*') || Request::is('supervisores*') ? ' class=active' : ''}}>
            <a  href="#menuFuerzaTarea" data-toggle="collapse">
                <i class="fa fa-users fa-lg" aria-hidden="true"></i>
                <p>Fuerza de tarea <b class="caret"></b></p>
            </a>
            <div class="collapse {{ Request::is('usuarios*')  ? 'in' : ''}}" id="menuFuerzaTarea">
                <ul class="nav">
                    <li  {{ Request::is('operarios-produccion*') ? ' class=active' : ''}}>
                        <a href="/operarios-produccion/">
                            <p>Operarios</p>
                        </a>
                    </li>

                    <li {{ Request::is('supervisores*')  ? ' class=active' : ''}}>
                        <a href="/supervisores/">
                            Supervisores
                        </a>
                    </li>
                    <li {{ Request::is('coordinadores*') ? ' class=active' : ''}}>
                        <a href="/coordinadores/">
                            Coordinadores
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        

        {{-- CLIENTES --}}
        <li  {{ Request::is('clientes*') ? ' class=active' : ''}}>
            <a href="/clientes/">
                <i class="material-icons">group</i>
                <p>Clientes</p>
            </a>
        </li>
        
        {{-- AGENTES --}}
        <li  {{ Request::is('agentes*') ? ' class=active' : ''}}>
            <a href="/agentes/">
                <i class="fa fa-id-card-o" aria-hidden="true"></i>
                <p>Agentes</p>
            </a>
        </li>


        

        
        {{-- TRASNPORTES --}}
        <li {{ Request::is('transportes*') ? ' class=active' : ''}}>
            <a  href="/transportes/">
                <i class="fa fa-truck" aria-hidden="true"></i>
                <p>Lineas de transportes </p>
            </a>
            
        </li>

        

        {{-- SERVICIOS --}}
        <li {{ Request::is('servicios*')  ? ' class=active' : ''}}>
            <a href="/servicios/">
                <i class="material-icons">flag</i>
                <p>Servicios</p>
            </a>
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
