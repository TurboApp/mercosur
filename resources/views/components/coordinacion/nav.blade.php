
<div class="row">
    <div class="col-md-12 text-right">
        <ul class="nav nav-pills pull-right"> 
            <li {{ Request::is('coordinacion/servicio/*/detalles') ? ' class=active' : '' }} >
                <a href="/coordinacion/servicio/{{$id}}/detalles">Detalles</a>
            </li>
            <li {{ Request::is('coordinacion/servicio/*/datos_generales') ? ' class=active' : '' }} >
                <a href="/coordinacion/servicio/{{$id}}/datos_generales">Datos generales</a>
            </li>
            <li {{ Request::is('coordinacion/servicio/*/transportes') ? ' class=active' : '' }} >
                <a href="/coordinacion/servicio/{{$id}}/transportes">Transportes</a>
            </li>
            <li {{ Request::is('coordinacion/servicio/*/documentos') ? ' class=active' : '' }} >
                <a href="/coordinacion/servicio/{{$id}}/documentos">Documentos</a>
            </li>
            <li {{ Request::is('coordinacion/servicio/*/archivos') ? ' class=active' : '' }} >
                <a href="/coordinacion/servicio/{{$id}}/archivos">Archivos</a>
            </li>
        </ul>
    </div>
</div>