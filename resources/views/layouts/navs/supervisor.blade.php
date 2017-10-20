<ul class="nav">
    @if (auth()->check()) <!--Verifica si el usuario esta autenticado-->
      <!-- DASHBOARD -->
      <li  {{ Request::is('/') ? ' class=active' : ''}}>
          <a href="/">
              <i class="material-icons">dashboard</i>
              <p>Inicio</p>
          </a>
      </li>
    @endif

</ul>
