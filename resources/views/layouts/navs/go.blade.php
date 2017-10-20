<ul class="nav">
    @if (auth()->check()) <!--Verifica si el usuario esta autenticado-->
      <!-- NOTIFICACIONES -->
      <li>
          <a href="../notificaciones.html">
              <i class="material-icons">notifications</i>
              <p>Notificaciones</p>
          </a>
      </li>
    @endif

</ul>
