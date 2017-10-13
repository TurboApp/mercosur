<card type="header-icon" icon="fa-file-text-o">
    <template>
        @if( isset($servicio->id) )
            <template slot="title">Documentos</template>
            <div class="row">
                <div class="col-md-12">
                    <legend>Seleccione los documentos con la mercancia a cargar</legend>
                </div>
                <div class="col-md-12">
                    <div class="group-form">
                        <select class="selectpicker" data-size="8" data-style="select-with-transition" title="<i class='fa fa-hand-o-right'></i> Seleccionar documento(s)" name="documento[][id]" multiple required>
                            @foreach($servicio->documentosDescarga as $index => $documento )
                                @if($documento->status)
                                    <option value="{{$documento->id}}" >{{$documento->tipo_documento}} - {{$documento->documento}}</option>
                                @else
                                    <option value="{{$documento->id}}" disabled>{{$documento->tipo_documento}} - {{$documento->documento}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <hr style="border:0">
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Documento</th>
                                <th>Descripción</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Documento</th>
                                <th>Descripción</th>
                                <th>Estatus</th>
                            </tr>  
                        </tfoot>
                        <tbody>
                            @foreach($servicio->documentosDescarga as $index => $documento)
                                <tr @if(! $documento->status ) class="text-muted" @endif >
                                    <td>{{ $index + 1 }}</td>
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
                </div>
            </div>  

        @else
        
            <template slot="title">Registro de documentos</template>
            <add-document ></add-document>

        @endif   
        

        
    </template>
    </card> 