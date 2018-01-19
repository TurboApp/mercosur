{{--Verifica si el usuario esta autenticado--}}
@if( auth()->check() && auth()->user()->perfil->perfil == 'trafico' )
    <ul class="nav">
        {{-- Inicio --}}
        <li {{ Request::is('/') ? ' class=active' : ''}}>
            <a href="/">
                <i class="material-icons">dashboard</i>
                <p>Inicio</p>
            </a>
        </li>

        {{-- Servicios --}}
        <li {{ Request::is('servicio*') || Request::is('servicios*') ? ' class=active' : ''}}>
            <a  href="#nuevoServicio" data-toggle="collapse">
                <i class="material-icons">flag</i>
                <p>Servicios <b class="caret"></b></p>
            </a>
            <div class="collapse {{ Request::is('servicio*')  ? 'in' : ''}}" id="nuevoServicio">
                <ul class="nav">
                    <li {{ Request::is('servicios*') && !Request::is('servicios/nuevo*')  ? ' class=active' : ''}}>
                        <a href="/servicios/">
                            Todos los servicios
                        </a>
                    </li>
                    <li {{ Request::is('servicios/nuevo*') ? ' class=active' : ''}}>
                        <a href="/servicios/nuevo">
                            Nuevo Servicio
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- Notificaciones --}}
        <li {{ Request::is('notificaciones*') ? ' class=active' : ''}}>
            <a href="/notificaciones/">
                <i class="material-icons">notifications</i>
                <p>Notificaciones</p>
            </a>
        </li>
    </ul>
@endif
