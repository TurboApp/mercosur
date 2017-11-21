@if ( auth()->check()  && auth()->user()->perfil->perfil == 'supervisor' ) <!--Verifica si el usuario esta autenticado-->
    <ul class="nav">
        <!-- DASHBOARD -->
        <li  {{ Request::is('/') ? ' class=active' : ''}}>
            <a href="/">
                <i class="material-icons">dashboard</i>
                <p>Inicio</p>
            </a>
        </li>

        {{-- Maniobras --}}
        <li  {{ Request::is('maniobras*') ? ' class=active' : ''}}>
            <a href="/maniobras">
                <i class="material-icons">flag</i>
                <p>Manibras</p>
            </a>
        </li>

        

    </ul>
@endif
