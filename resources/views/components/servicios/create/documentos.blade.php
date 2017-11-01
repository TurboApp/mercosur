 <h3 class="title">Documentos</h3>
 

<card>
    <template>
        @if( isset($servicio->id) )
            {{--  <template slot="title">Documentos</template>  --}}
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
                    <ul class="documentos-list">
                        @foreach($servicio->documentosDescarga as $index => $documento)
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
                </div>
            </div>

        @else
        
            {{--  <template slot="title">Registro de documentos</template>  --}}
            <add-document ></add-document>

        @endif   
        

        
    </template>
    </card> 