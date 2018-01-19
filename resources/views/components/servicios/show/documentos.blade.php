<card>
    <template>
        <ul class="document-list">
            @foreach($data as $index => $documento)
                <li class="document-item">
                    @if($documento->status)
                        <span class="fa-stack fa-3x">
                            <i class="fa fa-circle text-primary fa-stack-2x"></i>
                            <i class="fa fa-file-text-o fa-stack-1x fa-inverse"></i>
                        </span>
                    @else
                        <span class="fa-stack fa-3x">
                            <i class="fa fa-circle text-success fa-stack-2x"></i>
                            <i class="fa fa-check fa-stack-1x fa-inverse"></i>
                        </span>
                    @endif

                    <div class="document-details">
                        <h4 class="text-truncate title" title="{{ $documento->tipo_documento }} - {{ $documento->documento }}">{{ $documento->tipo_documento }} - {{ $documento->num_documento }}</h4>
                        <p class="text-truncate-ln4">{{ $documento->mercancia_descripcion }}</p>
                    </div>
                    
                </li>
            @endforeach
        </ul>
    </template>
</card> 