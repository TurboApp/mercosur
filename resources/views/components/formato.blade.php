@if ($data->tipo=="Descarga")
    <table border=".5px" cellspacing="0" bordercolor="Blue Grey">
        <col style="width:100%;">
        <tr>
            <td colspan="3" style='font-weight: bold; font-size: 10pt; color: #000000; font-family: Times; text-align:center; padding:10px;'>DATOS DE LA  MERCANCIA QUE SE ENTREGO O RECIBIO EN BODEGA</td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Ciudad Hidalgo, Chiapas: <span style="font-weight: bold; font-size: 8pt;">{{$fecha}}</span></td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">El suscrito operador: 
            <strong>
                @foreach ($data->transportes as $servicio)
                {{ucwords($servicio->nombre_operador)}}
                @endforeach
            </strong>
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Fecha y hora de entrega de documentos:
            <strong>
                {{$data->fecha_recepcion->format('d/m/Y')}} a las {{date('h:i A',strtotime($data->hora_recepcion))}} 
            </strong>
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Inicio de maniobras:
            <strong>
                {{date('d/m/Y \\a \\l\\a\\s h:i A',strtotime($data->coordinacion->inicio_maniobra))}}
            </strong>
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">Finalización de maniobra:
            <strong>
                {{date('d/m/Y \\a \\l\\a\\s h:i A',strtotime($data->coordinacion->termino_maniobra))}}
            </strong>
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Me Recibieron Mercancia:</td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">Me Entregaron Mercancia:</td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Mercancia del Cliente:</td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Con destino al cliente: 
            <strong>{{ucwords($data->destino)}}</strong>
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">cant/bts:
            <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Recepción')->first();
                $bultos=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Ingrese la cantidad de bultos"]])->first();
            ?>
            <strong>{{$bultos->value}}</strong>
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Con peso de:
            <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Recepción')->first();
                        $peso=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Ingrese el peso total de la mercancia de acuerdo a la documentación"]])->first();
            ?>
            <strong>{{$peso->value}} KG</strong>
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Talon:
            <strong>
                @foreach ($data->transportes as $servicio)
                {{ucfirst($servicio->talon_embarque)}}
                @endforeach
            </strong>
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Fact o Rem. N°:
            @foreach ($data->documentos as $servicio)
                <strong>{{ucfirst($servicio->tipo_documento)}}-{{$servicio->num_documento}}</strong>
            @endforeach
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Observación de la mercancia:
            <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Proceso de maniobra')->first();
                $observacion_mercancia=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Escriba las observaciones de la mercancia"]])->first();
            ?>
            <strong>{{ucwords($observacion_mercancia->value)}}</strong>
            </td>
        </tr>
        <tr>
            <td colspan="3" style='font-weight: bold; font-size: 10pt; color: #000000; font-family: Times; text-align:center; padding:10px;'>DATOS DEL VEHICULO QUE ENTREGO O RECIBIO LA MERCANCIA</td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Tipo de transporte:
            @foreach ($data->transportes as $servicio)
                <strong>{{ucfirst($servicio->tipo_unidad)}}</strong>
            @endforeach
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Medias:
            <strong>
                @foreach ($data->transportes as $servicio)
                {{ucfirst($servicio->medida_unidad)}}
                @endforeach
            </strong>
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000;'>
                @foreach ($data->transportes as $servicio)
                <p>Placas Caja: <strong>{{ucfirst($servicio->placas_caja)}}</strong></p>  
                <span style='display:block'>Placas Tractor: <strong>{{ucfirst($servicio->placas_tractor)}}</strong></span>
                @endforeach
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Linea de transporte:
            <strong>
                @foreach ($data->transportes as $servicio)
                {{ucfirst($servicio->transporte->nombre)}}
                @endforeach
            </strong>
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Estado de la plataforma:
            <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                $plataforma_caja=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Indique el estado de la plataforma / caja"]])->first();
            ?>
            @if ($plataforma_caja->value)
                <strong>{{$plataforma_caja->value}}</strong>
            @else
                <strong style='font-weight: italic; font-size: 8pt; color: #B71C1C; padding:7px;'>...</strong>
            @endif
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Llantas en buen estado:
            <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                $llantas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Seleccione el estado de las llantas"]])->first();
            ?>
            @if ($llantas->value)
                <strong>{{$llantas->value}}</strong>
            @else
                <strong style='font-weight: italic; font-size: 8pt; color: #B71C1C; padding:7px;'>...</strong>
            @endif
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Las llantas traen la presión adecuada:
            <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                $calibracion=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Indique el estado de la  presion de llantas"]])->first();
            ?>
            @if ($calibracion->value)
                <strong>{{$calibracion->value}}</strong>
            @else
                <strong style='font-weight: italic; font-size: 8pt; color: #B71C1C; padding:7px;'>...</strong>
            @endif
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Traen la totalidad de tuercas en las llantas:
            <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                $tuerca=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿Las llantas cuentan con sus tuercas completas?"]])->first();
            ?>
            @if ($tuerca->value=='1')
                <strong>SI</strong>
            @else
                <strong>NO</strong>
            @endif
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">Llantas de repuesto:
            <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                $llantas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿La unidad cuenta con llantas de repuesto?"]])->first();
            ?>
            @if ($llantas->value=='1')
                <strong>SI</strong>
            @else
                <strong>NO</strong>
            @endif
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Herramientas y señales reflejantes:
            <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                $herramientas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿La unidad cuenta con herramientas y señales reflejantes?"]])->first();
            ?>
            @if ($herramientas->value=='1')
                <strong>SI</strong>
            @else
                <strong>NO</strong>
            @endif
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Lonas en buen estado:
            <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                $herramientas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿La unidad cuenta con lonas en buen estado?"]])->first();
            ?>
            @if ($herramientas->value=='1')
                <strong>SI</strong>
            @else
                <strong>NO</strong>
            @endif
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Cuenta con lona:
            <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                $herramientas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿La cantidad de lonas es la adecuada?"]])->first();
            ?>
            @if ($herramientas->value=='1')
                <strong>SI</strong>
            @else
                <strong>NO</strong>
            @endif
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Cuenta con cadenas, Lazos, Slingas y Fajas para ajustar el material y en buenestado:
            <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                $cadenas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿La unidad cuenta con herramientas para ajustar?"]])->first();
            ?>
            @if ($cadenas->value=='1')
                <strong>SI</strong>
            @else
                <strong>NO</strong>
            @endif
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">Que tipo:
            <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                $lazos=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Ingrese el tipo de herramientas para ajustar con que cuenta la unidad"]])->first();
            ?>
            <strong>{{$lazos->value}}</strong>
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Funcionamiento de luces Indicadoras, Direccionales y/o Faros en buen estado:
            <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                $luces=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿Las luces indicadoras funcionan adecuadamente?"]])->first();
            ?>
            @if ($luces->value=='1')
                <strong>SI</strong>
            @else
                <strong>NO</strong>
            @endif
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Observaciones Generales de la plantaforma o caja:
            <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                $observaciones_generales=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Escriba las observaciones generales de la plataforma o caja"]])->first();
            ?>
            <strong>{{ucfirst($observaciones_generales->value)}}</strong>
            </td>
        </tr>
        @if ($data->tipo=="Descarga")
            <tr>
            <td style='font-size: 10pt; color: #000000; font-weight: italic; text-align:center; padding:2px;' colspan="1">
                <span>ENTREGO</span><br><br>
                <span>
                <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Finalización')->first();
                $firma_operaor=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Firma del operador"]])->first();
                ?>
                <img src="{{storage_path('app/'.$firma_operaor->value)}}" style="width:200px; " />
                </span><br>
                <span>@foreach ($data->transportes as $servicio)
                    {{ucwords($servicio->nombre_operador)}}
                @endforeach
                </span>
            </td>
            <td style='font-size: 10pt; color: #000000; font-weight: italic; text-align:center; padding:6px;' width="50%" colspan="2">
                <span>RECIBIO</span><br><br>
                <span>
                <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Finalización')->first();
                $firma_supervisor=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Firma del supervisor"]])->first();
                ?>
                <img src="{{storage_path('app/'.$firma_supervisor->value)}}" style="width:200px; " />
                </span><br>
                <span>{{$data->autor->nombre}} {{$data->autor->apellido}}</span>
            </td>
            </tr>
        @else    
            <tr>
            <td style='font-size: 10pt; color: #000000; font-weight: italic; text-align:center; padding:6px;' colspan="1">
                <span>ENTREGO</span><br><br>
                <span>
                <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Finalización')->first();
                $firma_supervisor=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Firma del supervisor"]])->first();
                ?>
                <img src="{{storage_path('app/'.$firma_supervisor->value)}}" style="width:200px; " />
                </span><br>
                <span>{{$data->autor->nombre}} {{$data->autor->apellido}}</span>
            </td>
            <td style='font-size: 10pt; color: #000000; font-weight: italic; text-align:center; padding:6px;' colspan="2">
                <span>RECIBIO</span><br><br>
                <span>
                <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Finalización')->first();
                $firma_operaor=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Firma del operador"]])->first();
                ?>
                <img src="{{storage_path('app/'.$firma_operaor->value)}}" style="width:200px; " />
                </span><br>
                <span>@foreach ($data->transportes as $servicio)
                    {{ucwords($servicio->nombre_operador)}}
                @endforeach
                </span>
            </td>
            </tr>
        @endif
    </table>
@endif
@if ($data->tipo=="Trasbordo")
{{--  Tabla para Nacionales  --}}
    <table border=".5px" cellspacing="0" bordercolor="Blue Grey">
        <col style="width:100%;">
        <tr>
            <td colspan="3" style='font-weight: bold; font-size: 10pt; color: #000000; font-family: Times; text-align:center; padding:10px;'>DATOS DE LA  MERCANCIA QUE SE ENTREGO O RECIBIO EN BODEGA</td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Ciudad Hidalgo, Chiapas: <span style="font-weight: bold; font-size: 8pt;">{{$fecha}}</span></td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">El suscrito operador: 
            <strong>
                {{DB::table('servicio_transportes')->select('nombre_operador')->where([['servicio_id',$data->id],['operacion','Origen']])->value('nombre_operador')}}    
            </strong>
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Fecha y hora de entrega de documentos:
            <strong>
                {{$data->fecha_recepcion->format('d/m/Y')}} a las {{date('h:i A',strtotime($data->hora_recepcion))}}
            </strong>
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Inicio de maniobras:
            <strong>
                {{date('d/m/Y \\a \\l\\a\\s h:i A',strtotime($data->coordinacion->inicio_maniobra))}}
            </strong>
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">Finalización de maniobra:
            <strong>
                {{date('d/m/Y \\a \\l\\a\\s h:i A',strtotime($data->coordinacion->termino_maniobra))}}
            </strong>
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Me Recibieron Mercancia:</td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">Me Entregaron Mercancia:</td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Mercancia del Cliente:</td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Con destino al cliente: 
            <strong>{{ucwords($data->destino)}}</strong>
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">cant/bts:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Recepción')->first();
                    $bultos=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Ingrese la cantidad de bultos"],["tipo_transporte","N"]])->first();
                ?>
                <strong>{{$bultos->value}}</strong>
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Con peso de:
                <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Recepción')->first();
                        $peso=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Ingrese el peso total de la mercancia"],["tipo_transporte","N"]])->first();
                ?>
                <strong>{{$peso->value}} KG</strong>
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Talon:
            <strong>
                {{DB::table('servicio_transportes')->select('talon_embarque')->where([['servicio_id',$data->id],['operacion','Origen']])->value('talon_embarque')}}
            </strong>
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>
                @foreach ($data->documentos as $servicio)
                    <strong>{{ucfirst($servicio->tipo_documento)}}-{{$servicio->num_documento}}</strong>
                @endforeach
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Observación de la mercancia:
            <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Proceso de maniobra')->first();
                $observacion_mercancia=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Observaciones de la mercancia"],["tipo_transporte","N"]])->first();
            ?>
            <strong>{{ucwords($observacion_mercancia->value)}}</strong>
            </td>
        </tr>
        <tr>
            <td colspan="3" style='font-weight: bold; font-size: 10pt; color: #000000; font-family: Times; text-align:center; padding:10px;'>DATOS DEL VEHICULO QUE ENTREGO O RECIBIO LA MERCANCIA</td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Tipo de transporte:
                <strong>{{DB::table('servicio_transportes')->select('tipo_unidad')->where([['servicio_id',$data->id],['operacion','Origen']])->value('tipo_unidad')}}</strong>
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Medidas:
            <strong>
                {{DB::table('servicio_transportes')->select('medida_unidad')->where([['servicio_id',$data->id],['operacion','Origen']])->value('medida_unidad')}}                
            </strong>
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000;'>
                <p>Placas Caja: <strong>{{DB::table('servicio_transportes')->select('placas_caja')->where([['servicio_id',$data->id],['operacion','Origen']])->value('placas_caja')}}</strong></p>  
                <span style='display:block'>Placas Tractor: <strong>{{DB::table('servicio_transportes')->select('placas_tractor')->where([['servicio_id',$data->id],['operacion','Origen']])->value('placas_tractor')}}</strong></span>
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Linea de transporte:
            <strong>
                {{DB::table('servicio_transportes')->join('lineas_transportes','servicio_transportes.linea_transporte_id','=','lineas_transportes.id')->select('lineas_transportes.nombre')->where('operacion','Origen')->value('lineas_transportes.nombre')}}
            </strong>
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Estado de la plataforma:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $plataforma_caja=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Indique el estado de la plataforma / caja"],["tipo_transporte","N"]])->first();
                ?>
                @if ($plataforma_caja->value)
                    <strong>{{$plataforma_caja->value}}</strong>
                @else
                    <strong style='font-weight: italic; font-size: 8pt; color: #B71C1C; padding:7px;'>...</strong>
                @endif
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Llantas en buen estado:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $llantas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Seleccione el estado de las llantas"],["tipo_transporte","N"]])->first();
                ?>
                @if ($llantas->value)
                    <strong>{{$llantas->value}}</strong>
                @else
                    <strong style='font-weight: italic; font-size: 8pt; color: #B71C1C; padding:7px;'>...</strong>
                @endif            
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Las llantas traen la presión adecuada:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $calibracion=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Indique el estado de la  presion de llantas"],["tipo_transporte","N"]])->first();
                ?>
                @if ($calibracion->value)
                    <strong>{{$calibracion->value}}</strong>
                @else
                    <strong style='font-weight: italic; font-size: 8pt; color: #B71C1C; padding:7px;'>...</strong>
                @endif
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Traen la totalidad de tuercas en las llantas:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $tuerca=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿Las llantas cuentan con sus tuercas completas?"],["tipo_transporte","N"]])->first();
                ?>
                @if ($tuerca->value=='1')
                    <strong>SI</strong>
                @else
                    <strong>NO</strong>
                @endif
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">Llantas de repuesto:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $llantas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿La unidad cuenta con llantas de repuesto?"],["tipo_transporte","N"]])->first();
                ?>
                @if ($llantas->value=='1')
                    <strong>SI</strong>
                @else
                    <strong>NO</strong>
                @endif
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Herramientas y señales reflejantes:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $herramientas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿La unidad cuenta con herramientas y señales reflejantes?"],["tipo_transporte","N"]])->first();
                ?>
                @if ($herramientas->value=='1')
                    <strong>SI</strong>
                @else
                    <strong>NO</strong>
                @endif
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Lonas en buen estado:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $herramientas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿La unidad cuenta con lonas en buen estado?"],["tipo_transporte","N"]])->first();
                ?>
                @if ($herramientas->value=='1')
                    <strong>SI</strong>
                @else
                    <strong>NO</strong>
                @endif
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Cuenta con lona:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $herramientas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿La cantidad de lonas es la adecuada?"],["tipo_transporte","N"]])->first();
                ?>
                @if ($herramientas->value=='1')
                    <strong>SI</strong>
                @else
                    <strong>NO</strong>
                @endif
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Cuenta con cadenas, Lazos, Slingas y Fajas para ajustar el material y en buenestado:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $cadenas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿La unidad cuenta con herramientas para ajustar?"],["tipo_transporte","N"]])->first();
                ?>
                @if ($cadenas->value=='1')
                    <strong>SI</strong>
                @else
                    <strong>NO</strong>
                @endif
            </td>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">Que tipo:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $lazos=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Ingrese el tipo de herramientas para ajustar con que cuenta la unidad"],["tipo_transporte","N"]])->first();
                ?>
                <strong>{{$lazos->value}}</strong>
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Funcionamiento de luces Indicadoras, Direccionales y/o Faros en buen estado:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $luces=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿Las luces indicadoras funcionan adecuadamente?"],["tipo_transporte","N"]])->first();
                ?>
                @if ($luces->value=='1')
                    <strong>SI</strong>
                @else
                    <strong>NO</strong>
                @endif
            </td>
        </tr>
        <tr>
            <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Observaciones Generales de la plantaforma o caja:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $observaciones_generales=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Escriba las observaciones generales de la plataforma o caja"],["tipo_transporte","N"]])->first();
                ?>
                <strong>{{ucfirst($observaciones_generales->value)}}</strong>
            </td>
        </tr>
            <tr>
            <td style='font-size: 10pt; color: #000000; font-weight: italic; text-align:center; padding:2px;' colspan="1">
                <span>ENTREGO</span><br><br>
                <span>
                <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Finalización')->first();
                $firma_operaor=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Firma del operador Nacional"]])->first();
                ?>
                <img src="{{storage_path('app/'.$firma_operaor->value)}}" style="width:150px; " />
                </span><br>
                <span>
                    {{DB::table('servicio_transportes')->select('nombre_operador')->where([['servicio_id',$data->id],['operacion','Origen']])->value('nombre_operador')}}
                </span>
            </td>
            <td style='font-size: 10pt; color: #000000; font-weight: italic; text-align:center; padding:6px;' colspan="2">
                <span>RECIBIO</span><br><br>
                <span>
                <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Finalización')->first();
                $firma_supervisor=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Firma del supervisor"]])->first();
                ?>
                <img src="{{storage_path('app/'.$firma_supervisor->value)}}" style="width:150px; " />
                </span><br>
                <span>{{$data->autor->nombre}} {{$data->autor->apellido}}</span>
            </td>
            </tr>
    </table>
{{--  Tabla CentroAmericano  --}}
    <page pageset="old">
        <table border=".5px" cellspacing="0" bordercolor="Blue Grey">
            <col style="width:100%;">
            <tr>
                <td colspan="3" style='font-weight: bold; font-size: 10pt; color: #000000; font-family: Times; text-align:center; padding:10px;'>DATOS DE LA  MERCANCIA QUE SE ENTREGO O RECIBIO EN BODEGA</td>
            </tr>
            <tr>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Ciudad Hidalgo, Chiapas: <span style="font-weight: bold; font-size: 8pt;">{{$fecha}}</span></td>
            </tr>
            <tr>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">El suscrito operador: 
                <strong>
                    {{DB::table('servicio_transportes')->select('nombre_operador')->where([['servicio_id',$data->id],['operacion','Destino']])->value('nombre_operador')}}    
                </strong>
                </td>
            </tr>
            <tr>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Fecha y hora de entrega de documentos:
                <strong>
                    {{$data->fecha_recepcion->format('d/m/Y')}} a las {{date('h:i A',strtotime($data->hora_recepcion))}}
                </strong>
                </td>
            </tr>
            <tr>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Inicio de maniobras:
                <strong>
                    {{date('d/m/Y \\a \\l\\a\\s h:i A',strtotime($data->coordinacion->inicio_maniobra))}}
                </strong>
                </td>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">Finalización de maniobra:
                <strong>
                    {{date('d/m/Y \\a \\l\\a\\s h:i A',strtotime($data->coordinacion->termino_maniobra))}}
                </strong>
                </td>
            </tr>
            <tr>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Me Recibieron Mercancia:</td>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">Me Entregaron Mercancia:</td>
            </tr>
            <tr>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Mercancia del Cliente:</td>
            </tr>
            <tr>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Con destino al cliente: 
                <strong>{{ucwords($data->destino)}}</strong>
                </td>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">cant/bts:
                    <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Recepción')->first();
                        $bultos=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Ingrese la cantidad de bultos"],["tipo_transporte","C"]])->first();
                    ?>
                    <strong>{{$bultos->value}}</strong>
                </td>
            </tr>
            <tr>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Con peso de:
                    <?php
                            $tarea=$data->coordinacion->tareas->where('titulo_corto','Recepción')->first();
                            $peso=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Capture las fotos del peso total"],["tipo_transporte","C"]])->first();
                    ?>
                    <strong>{{$peso->value}} KG</strong>
                </td>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Talon:
                <strong>
                    {{DB::table('servicio_transportes')->select('talon_embarque')->where([['servicio_id',$data->id],['operacion','Origen']])->value('talon_embarque')}}
                </strong>
                </td>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>
                    @foreach ($data->documentos as $servicio)
                        <strong>{{ucfirst($servicio->tipo_documento)}}-{{$servicio->num_documento}}</strong>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Observación de la mercancia:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Proceso de maniobra')->first();
                    $observacion_mercancia=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Observaciones de la mercancia"],["tipo_transporte","N"]])->first();
                ?>
                <strong>{{ucwords($observacion_mercancia->value)}}</strong>
                </td>
            </tr>
            <tr>
                <td colspan="3" style='font-weight: bold; font-size: 10pt; color: #000000; font-family: Times; text-align:center; padding:10px;'>DATOS DEL VEHICULO QUE ENTREGO O RECIBIO LA MERCANCIA</td>
            </tr>
            <tr>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Tipo de transporte:
                    <strong>{{DB::table('servicio_transportes')->select('tipo_unidad')->where([['servicio_id',$data->id],['operacion','Destino']])->value('tipo_unidad')}}</strong>
                </td>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Medidas:
                <strong>
                    {{DB::table('servicio_transportes')->select('medida_unidad')->where([['servicio_id',$data->id],['operacion','Destino']])->value('medida_unidad')}}                
                </strong>
                </td>
                <td style='font-weight: italic; font-size: 8pt; color: #000000;'>
                    <p>Placas Caja: <strong>{{DB::table('servicio_transportes')->select('placas_caja')->where([['servicio_id',$data->id],['operacion','Destino']])->value('placas_caja')}}</strong></p>  
                    <span style='display:block'>Placas Tractor: <strong>{{DB::table('servicio_transportes')->select('placas_tractor')->where([['servicio_id',$data->id],['operacion','Destino']])->value('placas_tractor')}}</strong></span>
                </td>
            </tr>
            <tr>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Linea de transporte:
                <strong>
                    {{DB::table('servicio_transportes')->join('lineas_transportes','servicio_transportes.linea_transporte_id','=','lineas_transportes.id')->select('lineas_transportes.nombre')->where('operacion','Destino')->value('lineas_transportes.nombre')}}
                </strong>
                </td>
            </tr>
            <tr>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Estado de la plataforma:
                    <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                        $plataforma_caja=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Indique el estado de la plataforma / caja"],["tipo_transporte","C"]])->first();
                    ?>
                    @if ($plataforma_caja->value)
                        <strong>{{$plataforma_caja->value}}</strong>
                    @else
                        <strong style='font-weight: italic; font-size: 8pt; color: #B71C1C; padding:7px;'>...</strong>
                    @endif
                </td>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Llantas en buen estado:
                    <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                        $llantas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Seleccione el estado de las llantas"],["tipo_transporte","C"]])->first();
                    ?>
                    @if ($llantas->value)
                        <strong>{{$llantas->value}}</strong>
                    @else
                        <strong style='font-weight: italic; font-size: 8pt; color: #B71C1C; padding:7px;'>...</strong>
                    @endif            
                </td>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Las llantas traen la presión adecuada:
                    <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                        $calibracion=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Indique el estado de la  presion de llantas"],["tipo_transporte","C"]])->first();
                    ?>
                    @if ($calibracion->value)
                        <strong>{{$calibracion->value}}</strong>
                    @else
                        <strong style='font-weight: italic; font-size: 8pt; color: #B71C1C; padding:7px;'>...</strong>
                    @endif
                </td>
            </tr>
            <tr>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Traen la totalidad de tuercas en las llantas:
                    <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                        $tuerca=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿Las llantas cuentan con sus tuercas completas?"],["tipo_transporte","C"]])->first();
                    ?>
                    @if ($tuerca->value=='1')
                        <strong>SI</strong>
                    @else
                        <strong>NO</strong>
                    @endif
                </td>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">Llantas de repuesto:
                    <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                        $llantas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿La unidad cuenta con llantas de repuesto?"],["tipo_transporte","C"]])->first();
                    ?>
                    @if ($llantas->value=='1')
                        <strong>SI</strong>
                    @else
                        <strong>NO</strong>
                    @endif
                </td>
            </tr>
            <tr>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Herramientas y señales reflejantes:
                    <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                        $herramientas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿La unidad cuenta con herramientas y señales reflejantes?"],["tipo_transporte","C"]])->first();
                    ?>
                    @if ($herramientas->value=='1')
                        <strong>SI</strong>
                    @else
                        <strong>NO</strong>
                    @endif
                </td>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Lonas en buen estado:
                    <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                        $herramientas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿La unidad cuenta con lonas en buen estado?"],["tipo_transporte","C"]])->first();
                    ?>
                    @if ($herramientas->value=='1')
                        <strong>SI</strong>
                    @else
                        <strong>NO</strong>
                    @endif
                </td>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Cuenta con lona:
                    <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                        $herramientas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿La cantidad de lonas es la adecuada?"],["tipo_transporte","C"]])->first();
                    ?>
                    @if ($herramientas->value=='1')
                        <strong>SI</strong>
                    @else
                        <strong>NO</strong>
                    @endif
                </td>
            </tr>
            <tr>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Cuenta con cadenas, Lazos, Slingas y Fajas para ajustar el material y en buenestado:
                    <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                        $cadenas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿La unidad cuenta con herramientas para ajustar?"],["tipo_transporte","C"]])->first();
                    ?>
                    @if ($cadenas->value=='1')
                        <strong>SI</strong>
                    @else
                        <strong>NO</strong>
                    @endif
                </td>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">Que tipo:
                    <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                        $lazos=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Ingrese el tipo de herramientas para ajustar con que cuenta la unidad"],["tipo_transporte","C"]])->first();
                    ?>
                    <strong>{{$lazos->value}}</strong>
                </td>
            </tr>
            <tr>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Funcionamiento de luces Indicadoras, Direccionales y/o Faros en buen estado:
                    <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                        $luces=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿Las luces indicadoras funcionan adecuadamente?"],["tipo_transporte","C"]])->first();
                    ?>
                    @if ($luces->value=='1')
                        <strong>SI</strong>
                    @else
                        <strong>NO</strong>
                    @endif
                </td>
            </tr>
            <tr>
                <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Observaciones Generales de la plantaforma o caja:
                    <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                        $observaciones_generales=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Escriba las observaciones generales de la plataforma o caja"],["tipo_transporte","C"]])->first();
                    ?>
                    <strong>{{ucfirst($observaciones_generales->value)}}</strong>
                </td>
            </tr>
                <tr>
                <td style='font-size: 10pt; color: #000000; font-weight: italic; text-align:center; padding:2px;' colspan="1">
                    <span>ENTREGO</span><br><br>
                    <span>
                        <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Finalización')->first();
                        $firma_supervisor=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Firma del supervisor"]])->first();
                        ?>
                        <img src="{{storage_path('app/'.$firma_supervisor->value)}}" style="width:150px; " />
                        </span><br>
                    <span>{{$data->autor->nombre}} {{$data->autor->apellido}}</span>
                </td>
                <td style='font-size: 10pt; color: #000000; font-weight: italic; text-align:center; padding:6px;' colspan="2">
                    <span>RECIBIO</span><br><br>
                    <span>
                        <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Finalización')->first();
                        $firma_operaor=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Firma del operador Nacional"]])->first();
                        ?>
                        <img src="{{storage_path('app/'.$firma_operaor->value)}}" style="width:150px; " />
                        </span><br>
                        <span>
                            {{DB::table('servicio_transportes')->select('nombre_operador')->where([['servicio_id',$data->id],['operacion','Origen']])->value('nombre_operador')}}
                    </span>
                </td>
                </tr>
        </table>
    </page>
@endif