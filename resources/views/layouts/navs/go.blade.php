<ul class="nav">
    @if (auth()->check()) <!--Verifica si el usuario esta autenticado-->
      <!-- NOTIFICACIONES -->
      <li {{ Request::is('notificaciones*') ? ' class=active' : ''}}>
            <a href="/notificaciones/">
                <i class="material-icons">notifications</i>
                <p>Notificaciones</p>
            </a>
        </li>
    @endif

</ul>
