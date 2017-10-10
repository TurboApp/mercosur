<card type="header-icon" icon="fa-file-text-o">
    <template>
        <template slot="title">Registro de documentos</template>
        <table class="table table-striped">
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
                                <del><em class="text-muted">Cargado</em></del>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </template>
</card> 