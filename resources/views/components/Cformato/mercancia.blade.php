<?php
    $titulo="font-weight: bold; font-size: 10pt; color: #000000; font-family: Times; text-align:center;";
    $label="font-weight: italic; font-size: 8pt; color: #000000; padding:4px;";
?>
@if ($tipo=="Descarga" || $tipo=="Carga")
    <tr>
            <td colspan="3" style="{{$titulo}}">DATOS DE LA  MERCANCIA QUE SE ENTREGO O RECIBIO EN BODEGA</td>
    </tr>
        <tr>
            <td style="{{$label}}" colspan="3">Ciudad Hidalgo, Chiapas: <strong>{{$fecha}}</strong></td>
        </tr>
        <tr>
            <td style="{{$label}}" colspan="3">El suscrito operador: 
            <strong>
                @foreach ($data->transportes as $servicio)
                {{ucwords($servicio->nombre_operador)}}
                @endforeach
            </strong>
            </td>
        </tr>
        <tr>
            <td style="{{$label}}" colspan="3">Fecha y hora de entrega de documentos:
            <strong>
                {{$data->fecha_recepcion->format('d/m/Y')}} a las {{date('h:i A',strtotime($data->hora_recepcion))}} 
            </strong>
            </td>
        </tr>
        <tr>
            <td style="{{$label}}">Inicio de maniobras:
            <strong>
                {{date('d/m/Y \\a \\l\\a\\s h:i A',strtotime($data->coordinacion->inicio_maniobra))}}
            </strong>
            </td>
            <td style="{{$label}}" colspan="2">Finalización de maniobra:
            <strong>
                {{date('d/m/Y \\a \\l\\a\\s h:i A',strtotime($data->coordinacion->termino_maniobra))}}
            </strong>
            </td>
        </tr>
        <tr>
            @if ($tipo=="Carga")
                <td style="{{$label}}" colspan="3">Me Entregaron Mercancia:
                    <?php
                            $tarea=$data->coordinacion->tareas->where('titulo_corto','Proceso de maniobra')->first();
                            $entrege=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Entregue mercancia en... "]])->first();
                    ?>
                    @if (!empty($entrege->value))
                        <strong>{{$entrege->value}}</strong>
                    @else
                        <strong>...</strong>
                    @endif
                </td>    
            @else
                <td style="{{$label}}" colspan="3">Me Recibieron Mercancia:
                    <?php
                            $tarea=$data->coordinacion->tareas->where('titulo_corto','Proceso de maniobra')->first();
                            $recibi=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Recibi mercancia en..."]])->first();
                    ?>
                    @if (!empty($recibi->value))
                        <strong>{{$recibi->value}}</strong>
                    @else
                        <strong>...</strong>
                    @endif
                </td>   
            @endif
        </tr>
        <tr>
            <td style="{{$label}}" colspan="3">Mercancia del Cliente:
                @foreach ($data->documentos as $mercancia)
                    {{$mercancia->mercancia_descripcion}},
                @endforeach
            </td>
        </tr>
        <tr>
            <td style="{{$label}}" colspan="3">Con destino al cliente: 
            <strong>{{ucwords($data->destino)}}</strong>
            </td>
        </tr>
        <tr>
            <td style="{{$label}}">Con peso de:
            <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Recepción')->first();
                        $peso=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Ingrese el peso total de la mercancia de acuerdo a la documentación"]])->first();
            ?>
            @if (!empty($peso->value))
                <strong>{{$peso->value}} KG</strong>
            @else
                <strong>...</strong>
            @endif
            </td>
            <td style="{{$label}}">Cant/Bts:
                <strong>
                    <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Recepción')->first();
                        $bultos=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Ingrese la cantidad de bultos de acuerdo a la documentación"]])->first();
                    ?>
                    @if (!empty($bultos->value))
                        <strong>...</strong>
                    @else
                        <strong>{{$bultos->value}}</strong>
                    @endif  
                </strong>
            </td>
            <td style="{{$label}}">Talon:
                <strong>
                    @foreach ($data->transportes as $servicio)
                    {{ucfirst($servicio->talon_embarque)}}
                    @endforeach
                </strong>
            </td>
        </tr>
        <tr>
            <td style="{{$label}}" colspan="3">Documentos:
                @foreach ($data->documentos as $servicio)
                    <strong>{{ucfirst($servicio->tipo_documento)}}-{{$servicio->num_documento}}</strong>,
                @endforeach
            </td>
        </tr>
        <tr>
            <td style="{{$label}}" colspan="3">Observación de la mercancia:
            <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Proceso de maniobra')->first();
                $observacion_mercancia=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Escriba las observaciones de la mercancia"]])->first();
            ?>
                <strong>{{ucwords($observacion_mercancia->value)}}</strong>
            </td>
        </tr>
@else
        <tr>
            <td colspan="3" style="{{$titulo}}">DATOS DE LA  MERCANCIA QUE SE ENTREGO O RECIBIO EN BODEGA</td>
        </tr>
        <tr>
            <td style="{{$label}}" colspan="3">Ciudad Hidalgo, Chiapas: <span style="font-weight: bold; font-size: 8pt;">{{$fecha}}</span></td>
        </tr>
        <tr>
            <td style="{{$label}}" colspan="3">El suscrito operador: 
            <strong>
                {{DB::table('servicio_transportes')->select('nombre_operador')->where([['servicio_id',$data->id],['operacion','Origen']])->value('nombre_operador')}}    
            </strong>
            </td>
        </tr>
        <tr>
            <td style="{{$label}}" colspan="3">Fecha y hora de entrega de documentos:
            <strong>
                {{$data->fecha_recepcion->format('d/m/Y')}} a las {{date('h:i A',strtotime($data->hora_recepcion))}}
            </strong>
            </td>
        </tr>
        <tr>
            <td style="{{$label}}">Inicio de maniobras:
            <strong>
                {{date('d/m/Y \\a \\l\\a\\s h:i A',strtotime($data->coordinacion->inicio_maniobra))}}
            </strong>
            </td>
            <td style="{{$label}}" colspan="2">Finalización de maniobra:
            <strong>
                {{date('d/m/Y \\a \\l\\a\\s h:i A',strtotime($data->coordinacion->termino_maniobra))}}
            </strong>
            </td>
        </tr>
        <tr>
            <td style="{{$label}}">Me Recibieron Mercancia:
                <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Proceso de maniobra')->first();
                        $recibi=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Recibi mercancia en..."],["tipo_transporte","N"]])->first();
                ?>
                @if ($recibi->tipo_transporte=="N")
                    <strong>{{$recibi->value}}</strong>
                @else
                    <strong>...</strong>
                @endif
            </td>
            <td style="{{$label}}" colspan="2">Me Entregaron Mercancia:
                <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Proceso de maniobra')->first();
                        $entrege=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Entregue mercancia en..."],["tipo_transporte","C"]])->first();
                ?>
                @if ($entrege->tipo_transporte=="C")
                    <strong>{{$entrege->value}}</strong>
                @else
                    <strong>...</strong>
                @endif
            </td>
        </tr>
        <tr>
            <td style="{{$label}}" colspan="3">Mercancia del Cliente:
                @foreach ($data->documentos as $mercancia)
                        {{ucwords($mercancia->mercancia_descripcion)}},
                @endforeach
            </td>
        </tr>
        <tr>
            <td style="{{$label}}" colspan="3">Con destino al cliente: 
            <strong>{{ucwords($data->destino)}}</strong>
            </td>
        </tr>
        <tr>
            <td style="{{$label}}">Con peso de:
                <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Recepción')->first();
                        $peso=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Ingrese el peso total de la mercancia de acuerdo a la documentación"],["tipo_transporte","N"]])->first();
                ?>
                <strong>{{$peso->value}} KG</strong>
            </td>
            <td style="{{$label}}">Talon:
            <strong>
                {{DB::table('servicio_transportes')->select('talon_embarque')->where([['servicio_id',$data->id],['operacion','Origen']])->value('talon_embarque')}}
            </strong>
            </td>
            <td style="{{$label}}">cant/bts:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Recepción')->first();
                    $bultos=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Ingrese la cantidad de bultos de acuerdo a la documentación"],["tipo_transporte","N"]])->first();
                ?>
                <strong>{{$bultos->value}}</strong>
            </td>
        </tr>
        <tr>
            <td style="{{$label}}" colspan="3">Documentos:
                @foreach ($data->documentos as $servicio)
                    <strong>{{ucfirst($servicio->tipo_documento)}}-{{$servicio->num_documento}}</strong>
                @endforeach
            </td>
        </tr>
        <tr>
            <td style="{{$label}}" colspan="3">Observación de la mercancia:
            <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Proceso de maniobra')->first();
                $observacion_mercancia=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Observaciones de la mercancia"],["tipo_transporte","N"]])->first();
            ?>
            <strong>{{ucwords($observacion_mercancia->value)}}</strong>
            </td>
        </tr>
@endif
        