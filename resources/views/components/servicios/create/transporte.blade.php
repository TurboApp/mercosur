@if($tipo==='Descarga')
    <transportes-list tipo="Origen"></transportes-list>
@elseif($tipo==='Carga')
    <transportes-list tipo="Destino"></transportes-list>
@elseif($tipo==='Trasbordo')
    <h4 class="info-text">Introdusca los datos del transporte (Origen)</h4>    
    <transportes-list tipo="Origen"></transportes-list>
    <hr>  
    <h4 class="info-text">Introdusca los datos del transporte (Destino)</h4>    
    <transportes-list tipo="Destino"></transportes-list>
@endif