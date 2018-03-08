<?php
    $label="font-size: 10pt; color: #000000; font-weight: italic; text-align:center; padding:4px;";
?>

<tr>
                <td style="{{$label}}" colspan="1">
                        <span>TRANSPORTISTA</span><br><br>
                        <span>
                            <?php
                            $tarea=$data->coordinacion->tareas->where('titulo_corto','Finalización')->first();
                            $firma_operaor=App\ManiobraSubtarea::where([["tarea_id",$tarea->id],["subtarea","Firma del operador Centroamericano"]])->first();
                            ?>
                            <img src="{{storage_path('app/'.$firma_operaor->value)}}" style="width:150px; " />
                            </span><br>
                        <span>
                            {{DB::table('servicio_transportes')->select('nombre_operador')->where([['servicio_id',$data->id],['operacion','Destino']])->value('nombre_operador')}}
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
                    <span>
                        {{$data->coordinacion->supervisor->nombre}} {{$data->coordinacion->supervisor->apellido}}
                    </span>
                </td>
</tr>