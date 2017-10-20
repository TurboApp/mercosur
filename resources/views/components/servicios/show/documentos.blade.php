<card type="header-icon" icon="fa-file-text-o">
    <template>
        <template slot="title">Registro de documentos</template>
        {{--  <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>&nbsp;</th>
                    <th>Documento</th>
                    <th>Descripción</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>&nbsp;</th>
                    <th>Documento</th>
                    <th>Descripción</th>
                    <th>Estatus</th>
                </tr>  
            </tfoot>
            <tbody>
                @foreach($data as $index => $documento)
                    <tr @if(! $documento->status ) class="text-muted" @endif >
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if( $documento->status )
                                <i class="fa fa-square-o" aria-hidden="true"></i>
                            @else
                                <i class="fa fa-check-square-o" aria-hidden="true"></i>
                            @endif
                        </td>
                        <td>
                            @if( $documento->status )
                                {{ $documento->tipo_documento }} - {{ $documento->documento }}
                            @else
                                <del><em class="text-muted">{{ $documento->tipo_documento }} - {{ $documento->documento }}
                            @endif
                        </td>
                        <td>
                            @if( $documento->status )
                                {{ $documento->descripcion }}
                            @else
                                <del><em class="text-muted">{{ $documento->descripcion }}</em></del>
                            @endif
                        </td>
                        <td>
                            @if( $documento->status )
                                Almacén
                            @else
                                <a href="/trafico/servicio/{{$documento->carga_id}}" >
                                Cargado <i class="fa fa-external-link" aria-hidden="true"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>  --}}
        <ul class="documentos-list">
            @foreach($data as $index => $documento)
                @if($documento->status)
                <li class="documento-item">
                    <h4> {{ $documento->tipo_documento }} - {{ $documento->documento }} <small class="label label-default">Almacén</small></h4>
                    
                    <p> {{ $documento->descripcion }} </p>
                </li>
                @else
                <li class="documento-item">
                    <h4> {{ $documento->tipo_documento }} - {{ $documento->documento }} <small class="label light-green accent-4"><i class="fa fa-check" aria-hidden="true"></i> Cargado</small> </h4>
                    <em class="text-muted"> {{ $documento->descripcion }} </em>
                </li>
                @endif
            @endforeach
        </ul>  
    </template>
</card> 