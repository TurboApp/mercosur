<page backtop="25mm" backbottom="11mm" backleft="0mm" backright="190mm">
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
    
        <?php
            $titulo="font-weight: italic; font-size: 25pt; color: #000000; padding:7px; text-align:center; color:#ffffff;";
            $dato="font-weight: italic; font-size: 14pt; color: #000000; padding:7px; text-align:center;";
        ?>
        @foreach ($data->documentos as $documento)
                <table border=".5px" cellspacing="0" bordercolor="Blue Grey" style='position: absolute' style="width:100%;">
                    <col width="400">
                        <tr>
                            <th style='{{$titulo}}' bgcolor="#D50000">REMITENTE</th>
                            <th style='{{$titulo}}' bgcolor="#D50000">DESTINO</th>
                            <th style='{{$titulo}}' bgcolor="#D50000">PAÍS</th>
                        </tr>
                        <tr>
                            <td style='{{$dato}}'> {{$data->cliente->nombre_corto}}-{{$data->cliente->nombre}} </td>
                            <td style='{{$dato}}'>{{$data->destino}}</td>
                            <td style='{{$dato}}'>{{$data->destino_pais}}</td>
                        </tr>
                        <tr>
                            <th style='{{$titulo}}' bgcolor="#D50000">FECHA ENT</th>
                            <th style='{{$titulo}}' bgcolor="#D50000">TALON</th>
                            <th style='{{$titulo}}' bgcolor="#D50000">
                                {{ucfirst($documento->tipo_documento)}}
                            </th>
                        </tr>
                        <tr>
                            <td style='{{$dato}}'>
                                {{date('d/m/Y',strtotime($data->coordinacion->termino_maniobra))}}
                            </td>
                            <td style='{{$dato}}'>
                                @foreach ($data->transportes as $talon)
                                    {{ucfirst($talon->talon_embarque)}}
                                @endforeach
                            </td>
                            <td style='{{$dato}}'>
                                {{ucfirst($documento->num_documento)}}
                            </td>
                        </tr>
                        <tr>
                            <th style='{{$titulo}}' bgcolor="#D50000">BULTOS</th>
                            <th style='{{$titulo}}' colspan="2" bgcolor="#D50000">PESO</th>
                        </tr>
                        <tr>
                            <td style='{{$dato}}'>
                                <?php
                                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Recepción')->first();
                                    $bultos=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Ingrese la cantidad de bultos"]])->first();
                                ?>
                                {{$bultos->value}}
                            </td>
                            <td colspan="2" style='{{$dato}}'>
                                <?php
                                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Recepción')->first();
                                    $peso=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Ingrese el peso total de la mercancia de acuerdo a la documentación"]])->first();
                                ?>
                                {{$peso->value}} KG
                            </td>
                        </tr>
                        <tr>
                            <th style='{{$titulo}}' colspan="3" bgcolor="#D50000">MERCANCIA</th>
                        </tr>
                        <tr>
                            <td colspan="3" style='{{$dato}}'>
                                    {{$documento->mercancia_descripcion}}
                            </td>
                        </tr>
                        <tr>
                            <th style='{{$titulo}}' colspan="3" bgcolor="#D50000">OBSERVACIONES</th>
                        </tr>
                        <tr>
                            <td colspan="3" style='{{$dato}}'>
                                <?php
                                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Proceso de maniobra')->first();
                                    $observacion_mercancia=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Escriba las observaciones de la mercancia"]])->first();
                                ?>
                                {{ucwords($observacion_mercancia->value)}}
                            </td>
                        </tr>
                    
                </table>
            <page pageset="old">
            </page>   
        @endforeach
       
</page>