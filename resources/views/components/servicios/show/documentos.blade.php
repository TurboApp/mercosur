{{--  <card type="header-icon" icon="fa-file-text-o">  --}}
        <h3 class="title">Documentos</h3>
<card>
    <template>
        
        <ul class="document-list">
            @foreach($data as $index => $documento)
                <li class="document-item">
                    
                    @if($documento->status)
                        <div class="document-icon text-center ">
                            <img src="/img/iconos/almacen.svg">
                            <label class="label label-default"> Almacen </label>
                        </div>
                    @else
                        <div class="document-icon text-center ">
                            <img src="/img/iconos/camion-cargado.svg" >
                            <label class="label label-success"> Cargado </label>
                        </div>
                    @endif

                    <div class="document-details">
                        <h6 class="text-truncate" title="{{ $documento->tipo_documento }} - {{ $documento->documento }}"><b>{{ $documento->tipo_documento }} - {{ $documento->documento }}</b></h6>
                        <p class="text-truncate-ln4">{{ $documento->descripcion }}</p>
                        <span class="text-truncate text-muted">
                            <small>
                                <i class="fa fa-calendar-o" aria-hidden="true"></i> Descarga {{ $documento->created_at->format('j/m/Y - H:m:s') }}
                            </small>
                        </span>
                        @if(!$documento->status)
                        <span class="text-truncate text-muted">
                            <small>
                                <i class="fa fa-calendar-o" aria-hidden="true"></i> Carga {{ $documento->updated_at->format('j/m/Y - H:m:s') }}
                            </small>
                        </span>
                        @endif
                    </div>
                    
                </li>
            @endforeach
        </ul>

        {{--  <ul class="documentos-list">
            @foreach($data as $index => $documento)
                @if($documento->status)
                <li class="documento-item">
                    <h4> {{ $documento->tipo_documento }} - {{ $documento->documento }} <small class="label label-default">Almacén</small></h4>
                    <p> {{ $documento->descripcion }} </p>
                    <span>Descargado el {{ $documento->updated_at->format('j/m/Y - H:m:s') }}</span>
                </li>
                @else
                <li class="documento-item">
                    <h4> {{ $documento->tipo_documento }} - {{ $documento->documento }} <small class="label light-green accent-4"><i class="fa fa-check" aria-hidden="true"></i> Cargado</small> </h4>
                    <p class="text-muted"> {{ $documento->descripcion }} </p>
                </li>
                @endif
            @endforeach
        </ul>    --}}
    </template>
</card> 