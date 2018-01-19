{{--Verifica si el usuario esta autenticado--}}
@if( auth()->check() && auth()->user()->perfil->perfil == 'coordinador' ) 
    <ul class="nav">
        {{-- Inicio --}}
        <li {{ Request::is('/') ? ' class=active' : ''}}>
            <a href="/">
                <i class="material-icons">dashboard</i>
                <p>Inicio</p>
            </a>
        </li>

        {{--  COORDINACIÓN  --}}
        <li  {{ Request::is('coordinacion*') ? ' class=active' : ''}}>
            <a href="/coordinacion">
                <i class="material-icons">swap_vert</i>
                <p>Coordinación</p>
            </a>
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