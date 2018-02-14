<page backtop="25mm" backbottom="11mm" backleft="25mm" backright="0mm">
    <page_header>
        <table class="page_header" style="width:100%;">
            <tr>
                <td><img src='/laragon/www/mercosur/public/img/mercosur.jpg' style="width:300px; height:87px;"/></td>
                <td style='font-weight: bold; font-size: 33pt; color: #2962FF; font-family: Times; text-align:center; padding:10px;'>TARJETA DE IDENTIDICACIÓN</td>
            </tr>
        </table>
    </page_header>
    <page_footer>
    </page_footer>
    <table border=".5px" cellspacing="0" bordercolor="Blue Grey" style="width:100%;">
        <tr>
            <th style='font-weight: italic; font-size: 30pt; color: #000000; padding:7px; text-align:center;'>REMITENTE</th>
            <th style='font-weight: italic; font-size: 30pt; color: #000000; padding:7px; text-align:center;'>DESTINO</th>
            <th style='font-weight: italic; font-size: 30pt; color: #000000; padding:7px; text-align:center;'>PAÍS</th>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 20pt; color: #000000; padding:7px; text-align:center;'> {{$data->cliente->nombre_corto}}-{{$data->cliente->nombre}} </td>
            <td style='font-weight: italic; font-size: 20pt; color: #000000; padding:7px; text-align:center;'>{{$data->destino}}</td>
            <td style='font-weight: italic; font-size: 20pt; color: #000000; padding:7px; text-align:center;'>{{$data->destino_pais}}</td>
        </tr>
        <tr>
            <th style='font-weight: italic; font-size: 30pt; color: #000000; padding:7px; text-align:center;'>FECHA ENT</th>
            <th style='font-weight: italic; font-size: 30pt; color: #000000; padding:7px; text-align:center;'>TALON</th>
            <th style='font-weight: italic; font-size: 30pt; color: #000000; padding:7px; text-align:center;'>
                @foreach ($data->documentos as $documento)
                    {{ucfirst($documento->tipo_documento)}}
                @endforeach
            </th>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 20pt; color: #000000; padding:7px; text-align:center;'>
                {{date('d/m/Y',strtotime($data->coordinacion->termino_maniobra))}}
            </td>
            <td style='font-weight: italic; font-size: 20pt; color: #000000; padding:7px; text-align:center;'>
                @foreach ($data->transportes as $documento)
                    {{ucfirst($documento->talon_embarque)}}
                @endforeach
            </td>
            <td style='font-weight: italic; font-size: 20pt; color: #000000; padding:7px; text-align:center;'>
                @foreach ($data->documentos as $documento)
                    {{ucfirst($documento->num_documento)}}
                @endforeach
            </td>
        </tr>
        <tr>
            <th style='font-weight: italic; font-size: 30pt; color: #000000; padding:7px; text-align:center;'>BULTOS</th>
            <th style='font-weight: italic; font-size: 30pt; color: #000000; padding:7px; text-align:center;' colspan="2">PESO</th>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 20pt; color: #000000; padding:7px; text-align:center;'>
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Recepción')->first();
                    $bultos=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Ingrese la cantidad de bultos"]])->first();
                ?>
                {{$bultos->value}}
            </td>
            <td colspan="2" style='font-weight: italic; font-size: 20pt; color: #000000; padding:7px; text-align:center;'>
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Recepción')->first();
                    $peso=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Ingrese el peso total de la mercancia de acuerdo a la documentación"]])->first();
                ?>
                {{$peso->value}} KG
            </td>
        </tr>
        <tr>
            <th style='font-weight: italic; font-size: 30pt; color: #000000; padding:7px; text-align:center;' colspan="2">MERCANCIA</th>
            <th style='font-weight: italic; font-size: 30pt; color: #000000; padding:7px; text-align:center;'>SUPERVISOR</th>
        </tr>
        <tr>
            <td colspan="2" style='font-weight: italic; font-size: 20pt; color: #000000; padding:7px; text-align:center;'>R</td>
            <td style='font-weight: italic; font-size: 20pt; color: #000000; padding:7px; text-align:center;'> {{$data->coordinacion->supervisor->nombre}} {{$data->coordinacion->supervisor->apellido}}</td>
        </tr>
        <tr>
            <th style='font-weight: italic; font-size: 30pt; color: #000000; padding:7px; text-align:center;' colspan="3">OBSERVACIONES</th>
        </tr>
        <tr>
            <td colspan="3" style='font-weight: italic; font-size: 20pt; color: #000000; padding:7px; text-align:center;'>
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Proceso de maniobra')->first();
                    $observacion_mercancia=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Escriba las observaciones de la mercancia"]])->first();
                ?>
                {{ucwords($observacion_mercancia->value)}}
            </td>
        </tr>
    </table>
</page>