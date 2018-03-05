<?php
    $titulo="font-weight: bold; font-size: 10pt; color: #000000; font-family: Times; text-align:center;";
    $label="font-weight: italic; font-size: 8pt; color: #000000; padding:4px;";
?>

<tr>
<td colspan="3" style="{{$titulo}}">DATOS DEL VEHICULO QUE ENTREGO O RECIBIO LA MERCANCIA</td>
            </tr>
            <tr>
            <td style="{{$label}}">Tipo de transporte:
                    <strong>{{DB::table('servicio_transportes')->select('tipo_unidad')->where([['servicio_id',$data->id],['operacion','Destino']])->value('tipo_unidad')}}</strong>
                </td>
                <td style="{{$label}}">Medidas:
                <strong>
                    {{DB::table('servicio_transportes')->select('medida_unidad')->where([['servicio_id',$data->id],['operacion','Destino']])->value('medida_unidad')}}                
                </strong>
                </td>
                <td style="{{$label}}">
                    <p>Placas Caja: <strong>{{DB::table('servicio_transportes')->select('placas_caja')->where([['servicio_id',$data->id],['operacion','Destino']])->value('placas_caja')}}</strong></p>  
                    <span style='display:block'>Placas Tractor: <strong>{{DB::table('servicio_transportes')->select('placas_tractor')->where([['servicio_id',$data->id],['operacion','Destino']])->value('placas_tractor')}}</strong></span>
                </td>
            </tr>
            <tr>
                <td style="{{$label}}" colspan="3">Linea de transporte:
                <strong>
                    {{DB::table('servicio_transportes')->join('lineas_transportes','servicio_transportes.linea_transporte_id','=','lineas_transportes.id')->select('lineas_transportes.nombre')->where('operacion','Destino')->value('lineas_transportes.nombre')}}
                </strong>
                </td>
            </tr>
            <tr>
                <td style="{{$label}}">Estado de la plataforma:
                    <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                        $plataforma_caja=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Indique el estado de la plataforma / caja"],["tipo_transporte","C"]])->first();
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
                        $llantas=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Seleccione el estado de las llantas"],["tipo_transporte","C"]])->first();
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
                        $calibracion=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Indique el estado de la  presion de llantas"],["tipo_transporte","C"]])->first();
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
                        $tuerca=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","¿Las llantas cuentan con sus tuercas completas?"],["tipo_transporte","C"]])->first();
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
                <td style="{{$label}}">Herramientas y señales reflejantes:
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
                <td style="{{$label}}">Lonas en buen estado:
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
                <td style="{{$label}}">Cuenta con lona:
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
                <td style="{{$label}}">Cuenta con cadenas, Lazos, Slingas y Fajas para ajustar el material y en buenestado:
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
                <td style="{{$label}}" colspan="2">Que tipo:
                    <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                        $lazos=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Ingrese el tipo de herramientas para ajustar con que cuenta la unidad"],["tipo_transporte","C"]])->first();
                    ?>
                    <strong>{{$lazos->value}}</strong>
                </td>
            </tr>
            <tr>
                <td style="{{$label}}" colspan="3">Funcionamiento de luces Indicadoras, Direccionales y/o Faros en buen estado:
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
                <td style="{{$label}}" colspan="3">Observaciones Generales de la plantaforma o caja:
                    <?php
                        $tarea=$data->coordinacion->tareas->where('titulo_corto','Revisión')->first();
                        $observaciones_generales=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Escriba las observaciones generales de la plataforma o caja"],["tipo_transporte","C"]])->first();
                    ?>
                    <strong>{{ucfirst($observaciones_generales->value)}}</strong>
                </td>
            </tr>