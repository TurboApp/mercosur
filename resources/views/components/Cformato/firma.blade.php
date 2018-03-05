<?php
    $label="font-size: 10pt; color: #000000; font-weight: italic; text-align:center; padding:4px;";
?>
@if ($tipo=="Descarga" || $tipo=="Carga")
                <tr>
                <td style="{{$label}}" colspan="1">
                    <span>TRANSPORTISTA</span><br><br>
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
                <td style="{{$label}}" width="50%" colspan="2">
                    <span>SUPERVISOR</span><br><br>
                    <span>
                    <?php
                    $tarea=$data->coordinacion->tareas->where('titulo_corto','Finalización')->first();
                    $firma_supervisor=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Firma del supervisor"]])->first();
                    ?>
                    <img src="{{storage_path('app/'.$firma_supervisor->value)}}" style="width:200px; " />
                    </span><br>
                    <span>{{$data->coordinacion->supervisor->nombre}} {{$data->coordinacion->supervisor->apellido}}</span>
                </td>
                </tr>
@else
    <tr>
            <td style="{{$label}}" colspan="1">
                <span>TRANSPORTISTA</span><br><br>
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
            <td style="{{$label}}" colspan="2">
                <span>SUPERVISOR</span><br><br>
                <span>
                <?php
                $tarea=$data->coordinacion->tareas->where('titulo_corto','Finalización')->first();
                $firma_supervisor=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Firma del supervisor"]])->first();
                ?>
                <img src="{{storage_path('app/'.$firma_supervisor->value)}}" style="width:150px; " />
                </span><br>
                <span>{{$data->coordinacion->supervisor->nombre}} {{$data->coordinacion->supervisor->apellido}}</span>
            </td>
    </tr>
@endif
