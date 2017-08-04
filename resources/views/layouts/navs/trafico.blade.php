  <ul class="nav">
    <!-- menu de un nivel -->
    <li  class="active">
        <a href="./inicio.html">
            <i class="material-icons">dashboard</i>
            <p>Inicio</p>
        </a>
    </li>
    <!-- menu de dos niveles -->
    <li>
        <a data-toggle="collapse" href="#menuTrafico" aria-expanded="true">
            <i class="material-icons">traffic</i>
            <p>Tráfico
                <b class="caret"></b>
            </p>
        </a>
        <div class="collapse in" id="menuTrafico">
            <ul class="nav">
                <li>
                    <a href="./nuevo_servicio.html">
                        Nuevo servicio
                    </a>
                </li>
                <li>
                    <a href="./lista_servicios.html">
                        Lista de servicios
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li>
        <a href="../notificaciones.html">
            <i class="material-icons">notifications</i>
            <p>Notificaciones</p>
        </a>
    </li>


</ul>