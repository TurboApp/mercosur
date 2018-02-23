<page backtop="25mm" backbottom="11mm" backleft="0mm" backright="100mm">
    <page_header>
        <table class="page_header" style="width:100%;">
            <tr>
                <td><img src='/laragon/www/mercosur/public/img/mercosur.jpg' style="width:300px; height:87px;"/></td>
                <td style='font-weight: bold; font-size: 33pt; color: #2962FF; font-family: Times; text-align:center; padding:10px;'>TARJETA DE IDENTIDICACIÓN</td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <p>Esta maniobra fue supervisada por <strong>{{$data->coordinacion->supervisor->nombre}} {{$data->coordinacion->supervisor->apellido}}</strong></p>
    </page_footer>
    <nobreak>
        <table border=".5px" cellspacing="0" bordercolor="Blue Grey" style='position: absolute' style="width:100%;">
            <col style="width:100%;">
                <tr>
                    <th style='font-weight: italic; font-size: 25pt; color: #000000; padding:7px; text-align:center; color:#ffffff;' bgcolor="#D50000">REMITENTE</th>
                    <th style='font-weight: italic; font-size: 25pt; color: #000000; padding:7px; text-align:center; color:#ffffff;' bgcolor="#D50000">DESTINO</th>
                    <th style='font-weight: italic; font-size: 25pt; color: #000000; padding:7px; text-align:center; color:#ffffff;' bgcolor="#D50000">PAÍS</th>
                </tr>
                <tr>
                    <td style='font-weight: italic; font-size: 20pt; color: #000000; padding:7px; text-align:center;'> {{$data->cliente->nombre_corto}}-{{$data->cliente->nombre}} </td>
                    <td style='font-weight: italic; font-size: 20pt; color: #000000; padding:7px; text-align:center;'>{{$data->destino}}</td>
                    <td style='font-weight: italic; font-size: 20pt; color: #000000; padding:7px; text-align:center;'>{{$data->destino_pais}}</td>
                </tr>
                <tr>
                    <th style='font-weight: italic; font-size: 25pt; color: #000000; padding:7px; text-align:center; color:#ffffff;' bgcolor="#D50000">FECHA ENT</th>
                    <th style='font-weight: italic; font-size: 25pt; color: #000000; padding:7px; text-align:center; color:#ffffff;' bgcolor="#D50000">TALON</th>
                    <th style='font-weight: italic; font-size: 25pt; color: #000000; padding:7px; text-align:center; color:#ffffff;' bgcolor="#D50000">
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
                    <th style='font-weight: italic; font-size: 25pt; color: #000000; padding:7px; text-align:center; color:#ffffff;' bgcolor="#D50000">BULTOS</th>
                    <th style='font-weight: italic; font-size: 25pt; color: #000000; padding:7px; text-align:center; color:#ffffff;' colspan="2" bgcolor="#D50000">PESO</th>
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
                    <th style='font-weight: italic; font-size: 25pt; color: #000000; padding:7px; text-align:center; color:#ffffff;' colspan="3" bgcolor="#D50000">MERCANCIA</th>
                </tr>
                <tr>
                    <td colspan="3" style='font-weight: italic; font-size: 20pt; color: #000000; padding:7px; text-align:left;'>
                        @foreach ($data->documentos as $documento)                    
                            {{--  {{var_dump(explode("\n",$documento->mercancia_descripcion))}}  --}}
                            {{$documento->mercancia_descripcion}}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th style='font-weight: italic; font-size: 25pt; color: #000000; padding:7px; text-align:center; color:#ffffff;' colspan="3" bgcolor="#D50000">OBSERVACIONES</th>
                </tr>
                <tr>
                    <td colspan="3" style='font-weight: italic; font-size: 20pt; color: #000000; padding:7px; text-align:left;'>
                        <?php
                            $tarea=$data->coordinacion->tareas->where('titulo_corto','Proceso de maniobra')->first();
                            $observacion_mercancia=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Escriba las observaciones de la mercancia"]])->first();
                        ?>
                        {{ucwords($observacion_mercancia->value)}}
                    </td>
                </tr>
            
        </table>
    </nobreak>    
</page>