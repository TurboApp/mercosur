<?php
    $titulo="font-weight: bold; font-size: 10pt; color: #000000; font-family: Times; text-align:center;";
    $label="font-weight: italic; font-size: 8pt; color: #000000; padding:4px;";
?>

@if ($tipo=="Descarga" || $tipo=="Carga")
    <tr>
        <td colspan="3" style="{{$titulo}}">DATOS DEL VEHICULO QUE ENTREGO O RECIBIO LA MERCANCIA</td>
    </tr>
        <tr>
            <td style="{{$label}}">Tipo de transporte:
                @foreach ($data->transportes as $servicio)
                    <strong>{{ucfirst($servicio->tipo_unidad)}}</strong>
                @endforeach
            </td>
            <td style="{{$label}}">Medias:
                <strong>
                    @foreach ($data->transportes as $servicio)
                    {{ucfirst($servicio->medida_unidad)}}
                    @endforeach
                </strong>
            </td>
            <td style="{{$label}}">
                @foreach ($data->transportes as $servicio)
                <p>Placas Caja: <strong>{{ucfirst($servicio->placas_caja)}}</strong></p>  
                <span style='display:block'>Placas Tractor: <strong>{{ucfirst($servicio->placas_tractor)}}</strong></span>
                @endforeach
            </td>
        </tr>
        <tr>
            <td style="{{$label}}" colspan="3">Linea de transporte:
                <strong>
                    @foreach ($data->transportes as $servicio)
                    {{ucfirst($servicio->transporte->nombre)}}
                    @endforeach
                </strong>
            </td>
        </tr>
        <tr>
            <td style="{{$label}}">Estado de la plataforma:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $plataforma_caja=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Indique el estado de la plataforma / caja"]])->first();
                ?>
                @if ($plataforma_caja->value)
                    <strong>{{$plataforma_caja->value}}</strong>
                @else
                    <strong style="{{$label}}">...</strong>
                @endif
            </td>
            <td style="{{$label}}">Llantas en buen estado:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $llantas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Seleccione el estado de las llantas"]])->first();
                ?>
                @if ($llantas->value)
                    <strong>{{$llantas->value}}</strong>
                @else
                    <strong style="{{$label}}">...</strong>
                @endif
            </td>
            <td style="{{$label}}">Las llantas traen la presión adecuada:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $calibracion=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Indique el estado de la  presion de llantas"]])->first();
                ?>
                @if ($calibracion->value)
                    <strong>{{$calibracion->value}}</strong>
                @else
                    <strong style={{$label}}>...</strong>
                @endif
            </td>
        </tr>
        <tr>
            <td style="{{$label}}">Traen la totalidad de tuercas en las llantas:
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
            <td style="{{$label}}" colspan="2">Llantas de repuesto:
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
            <td style="{{$label}}">Herramientas y señales reflejantes:
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
            <td style="{{$label}}">Lonas en buen estado:
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
            <td style="{{$label}}">Cuenta con lona:
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
            <td style="{{$label}}">Cuenta con cadenas, Lazos, etc. Para ajustar el material y en buenestado:
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
            <td style="{{$label}}" colspan="2">Que tipo:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $lazos=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Ingrese el tipo de herramientas para ajustar con que cuenta la unidad"]])->first();
                ?>
                <strong>{{$lazos->value}}</strong>
            </td>
        </tr>
        <tr>
            <td style="{{$label}}" colspan="3">Funcionamiento de luces Indicadoras, Direccionales y/o Faros en buen estado:
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
            <td style="{{$label}}" colspan="3">Observaciones Generales de la plantaforma o caja:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $observaciones_generales=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Escriba las observaciones generales de la plataforma o caja"]])->first();
                ?>
                <strong>{{ucfirst($observaciones_generales->value)}}</strong>
            </td>
        </tr>

@else
    <tr>
    <td colspan="3" style="{{$titulo}}">DATOS DEL VEHICULO QUE ENTREGO O RECIBIO LA MERCANCIA</td>
        </tr>
        <tr>
        <td style="{{$label}}">Tipo de transporte:
                <strong>{{DB::table('servicio_transportes')->select('tipo_unidad')->where([['servicio_id',$data->id],['operacion','Origen']])->value('tipo_unidad')}}</strong>
            </td>
            <td style="{{$label}}">Medidas:
            <strong>
                {{DB::table('servicio_transportes')->select('medida_unidad')->where([['servicio_id',$data->id],['operacion','Origen']])->value('medida_unidad')}}                
            </strong>
            </td>
            <td style="{{$label}}">
                <p>Placas Caja: <strong>{{DB::table('servicio_transportes')->select('placas_caja')->where([['servicio_id',$data->id],['operacion','Origen']])->value('placas_caja')}}</strong></p>  
                <span style='display:block'>Placas Tractor: <strong>{{DB::table('servicio_transportes')->select('placas_tractor')->where([['servicio_id',$data->id],['operacion','Origen']])->value('placas_tractor')}}</strong></span>
            </td>
        </tr>
        <tr>
            <td style="{{$label}}" colspan="3">Linea de transporte:
            <strong>
                {{DB::table('servicio_transportes')->join('lineas_transportes','servicio_transportes.linea_transporte_id','=','lineas_transportes.id')->select('lineas_transportes.nombre')->where('operacion','Origen')->value('lineas_transportes.nombre')}}
            </strong>
            </td>
        </tr>
        <tr>
            <td style="{{$label}}">Estado de la plataforma:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $plataforma_caja=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Indique el estado de la plataforma / caja"],["tipo_transporte","N"]])->first();
                ?>
                @if ($plataforma_caja->value)
                    <strong>{{$plataforma_caja->value}}</strong>
                @else
                    <strong style="{{$label}}">...</strong>
                @endif
            </td>
            <td style="{{$label}}">Llantas en buen estado:
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
            <td style="{{$label}}">Las llantas traen la presión adecuada:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $calibracion=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Indique el estado de la  presion de llantas"],["tipo_transporte","N"]])->first();
                ?>
                @if ($calibracion->value)
                    <strong>{{$calibracion->value}}</strong>
                @else
                    <strong style="{{$label}}">...</strong>
                @endif
            </td>
        </tr>
        <tr>
            <td style="{{$label}}">Traen la totalidad de tuercas en las llantas:
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
            <td style="{{$label}}" colspan="2">Llantas de repuesto:
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
            <td style="{{$label}}">Herramientas y señales reflejantes:
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
            <td style="{{$label}}">Lonas en buen estado:
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
            <td style="{{$label}}">Cuenta con lona:
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
            <td style="{{$label}}">Cuenta con cadenas, Lazos, Slingas y Fajas para ajustar el material y en buenestado:
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
            <td style="{{$label}}" colspan="2">Que tipo:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $lazos=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Ingrese el tipo de herramientas para ajustar con que cuenta la unidad"],["tipo_transporte","N"]])->first();
                ?>
                <strong>{{$lazos->value}}</strong>
            </td>
        </tr>
        <tr>
            <td style="{{$label}}" colspan="3">Funcionamiento de luces Indicadoras, Direccionales y/o Faros en buen estado:
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
            <td style="{{$label}}" colspan="3">Observaciones Generales de la plantaforma o caja:
                <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                    $observaciones_generales=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Escriba las observaciones generales de la plataforma o caja"],["tipo_transporte","N"]])->first();
                ?>
                <strong>{{ucfirst($observaciones_generales->value)}}</strong>
            </td>
        </tr>
@endif
    