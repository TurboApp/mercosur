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

        {{-- Trafico --}}
        <li {{ Request::is('trafico*') ? ' class=active' : ''}}>
            <a data-toggle="collapse" href="#menuTrafico">
                <i class="material-icons">traffic</i>
                <p>Tráfico <b class="caret"></b></p>
            </a>
            <div class="collapse {{ Request::is('trafico*')  ? 'in' : ''}}"  id="menuTrafico">
                <ul class="nav">
                    <li {{ Request::is('trafico*') && !Request::is('trafico/nuevo*') && !Request::is('trafico/coordinacion*') ? ' class=active' : ''}}>
                        <a href="/trafico/">
                            Servicios
                        </a>
                    </li>
                    <li {{ Request::is('trafico/nuevo*') ? ' class=active' : ''}}>
                        <a href="/trafico/nuevo">
                            Nuevo
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- Notificaciones --}}
        <li>
            <a href="../notificaciones.html">
                <i class="material-icons">notifications</i>
                <p>Notificaciones</p>
            </a>
        </li>
    </ul>
@endif