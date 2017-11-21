<div class="row">
    <div class="col-md-12 text-right">
        <ul class="nav nav-pills pull-right"> 
            <li {{ Request::is('trafico/maniobra/*/detalles') ? ' class=active' : '' }} >
                <a href="/coordinacion/servicio/{{$id}}/detalles">Detalles</a>
            </li>
            <li {{ Request::is('trafico/maniobra/*/datos_generales') ? ' class=active' : '' }} >
                <a href="/trafico/maniobra/{{$id}}/datos_generales">Datos generales</a>
            </li>
            <li {{ Request::is('trafico/maniobra/*/transportes') ? ' class=active' : '' }} >
                <a href="/trafico/maniobra/{{$id}}/transportes">Transporte(s)</a>
            </li>
            <li {{ Request::is('trafico/maniobra/*/documentos') ? ' class=active' : '' }} >
                <a href="/trafico/maniobra/{{$id}}/documentos">Documento(s)</a>
            </li>
            <li {{ Request::is('trafico/maniobra/*/archivos') ? ' class=active' : '' }} >
                <a href="/trafico/maniobra/{{$id}}/archivos">Archivo(s)</a>
            </li>
        </ul>
    </div>
</div>