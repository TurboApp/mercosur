@extends('layouts.master')
@section('title','Nueva orden de servicio')
@section('nav-top')
  
<form class="navbar-form navbar-right" method="GET" action="/trafico/busqueda/" role="search">
  <div class="form-group form-search is-empty">
      <input type="text" class="form-control" name="s" placeholder="Buscar">
      <span class="material-input"></span>
  </div>
  <button type="submit" class="btn btn-white btn-round btn-just-icon">
      <i class="material-icons">search</i>
      <div class="ripple-container"></div>
  </button>
</form>
@endsection
@section('content')

<div class="container-fluid">
    {!! Form::open(array('url' => '/trafico/carga', 'method'=>'post', 'id'=>'formNuevoServicio', 'class'=>'form-horizontal','files'=>true, 'autocomplete'=>'off')) !!}
    <input type="hidden" name="descarga_id" value="{{$servicio->id}}" >
    
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <h2>Carga</h2>
        </div>
        <div class="col-md-6">
            <div class="text-right form-group">
                {{ $data["hoy"]->format('l j \\d\\e F \\d\\e Y') }}
                <p class="lead text-muted">Número de servicio {{ $data["numero_servicio"] }}</p>
            </div>
        </div>
    </div>
    
    <card type="header-icon" icon="fa-info" bg-color="blue">
    <template>
        <template slot="title">Datos generales</template>
        <div class="row ">
            <div class="col-md-6 ">
                <div class="row">
                    <div class="form-group">                       
                        <div class="col-md-6">
                            <select id="agente_id" class="selectpicker" name="datos_generales[agente_id]" data-style="btn btn-primary btn-round" disabled>
                                <option value="{{$servicio->agente_id}}" selected>{{$servicio->agente->nombre_corto}}</option>
                            </select>
                            <input type="hidden" name="datos_generales[agente_id]" value="{{$servicio->agente_id}}" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" title="Fecha">
                                <i class="fa fa-calendar "></i> Fecha
                            </span>
                            <input type="text" name="datos_generales[fecha_recepcion]" value="{{$data['hoy']->format('j/m/Y')}}" class="form-control datepicker"  maxlength="10" required>
                            
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-clock-o"></i> Hora
                            </span>
                            <input type="text" value="{{$data['hoy']->format('H:i')}}" name="datos_generales[hora_recepcion]" class="form-control timepicker" maxlength="12" required>
                            <span class="material-input"></span>
                        </div>
                    </div>
                </div><!-- ./form-horizontal  -->
            </div><!-- ./col -->
            
        </div><!-- ./row -->
        <hr style="border:0;">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="form-group">
                        <label for="cliente" class="col-md-2 control-label">Cliente</label>
                        <div class="col-md-10">
                            <span class="twitter-typeahead">
                                <input type="text" class="form-control search_cliente" value="{{ $servicio->cliente->nombre }}" disabled>
                                <input type="hidden" name="datos_generales[cliente_id]" value="{{$servicio->cliente_id}}" >
                                <span class="material-input"></span>
                            </span> 
                        </div>
                    </div>
                </div>
            </div>    
            <div class="col-md-4">
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-2 control-label">RFC</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="rfc_cliente" value="{{ $servicio->cliente->rfc }}" disabled>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        <!-- cliente input hidden -->
        

        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="row">
                    <div class="form-group">
                        <label for="destiinatario" class="col-md-2 control-label">Destinatario</label>
                        <div class="col-md-10">
                            <span class="twitter-typeahead">
                                <input type="text" class="form-control search_destinatario" name="datos_generales[destino]" value="{{ $servicio->destino }}" maxlength="191"  required>
                                <span class="material-input"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-2 control-label">País</label>
                        <div class="col-md-10">
                            <span class="twitter-typeahead">
                                <input type="text" class="form-control paises" name="datos_generales[destino_pais]" value="{{ $servicio->destino_pais }}" maxlength="35" required>
                                <span class="material-input"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /row-->
        <div class="row">
            <div class="col-md-12">
                <div class="form-group label-floating">
                    <label for="observaciones" class="control-label">Observaciones</label>
                    <textarea name="datos_generales[observaciones]" id="observaciones" class="form-control" maxlength="191" >{{ old('observaciones') }}</textarea>
                </div>
            </div>
        </div>

    </template>
    </card>

    @component('components.cardTransporte',[
        'option' => 'create'
    ])
    @endcomponent

    {{--  <card type="header-icon" icon="fa-truck" bg-color="blue">
    <template>
        <template slot="title">Transporte</template>
        <div class="row">
            <div class="col-md-12">  
                <div class="form-group">
                    <span class="twitter-typeahead">
                        <label for="lineaTransporte" class="control-label">Linea de transporte</label>
                        <input type="text" id="busqueda_transporte" class="form-control search_transporte" name="lineaTransporte" value="{{ old('lineaTransporte') }}" required>
                        <input type="hidden" id="idtransporte" name="transporte[id_linea_transporte]" value="{{ old('transporte.id_linea_transporte') }}">
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">  
                <div class="form-group">
                    <label for="operadorUnidad" class="control-label">Nombre del operador</label>
                    <input type="text" class="form-control" name="transporte[nombre_operador]" value="{{ old('transporte.nombre_operador') }}" maxlength="120" required>   
                </div>
            </div>
            <div class="col-md-4">  
                <div class="form-group">
                    <label for="n_talon" class="control-label">No. de talon</label>
                    <input type="text" class="form-control" name="transporte[talon_embarque]" value="{{ old('transporte.talon_embarque') }}" maxlength="191" required>   
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="marcaVehiculo" class="control-label">Marca del Vehiculo</label>
                    <input type="text" name="transporte[marca_vehiculo]" class="form-control get-marca-vehiculo" value="{{ old('transporte.marca_vehiculo') }}" maxlength="191" required>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="placasTractor" class="control-label">Placas del tractor</label>
                    <input type="text" name="transporte[placas_tractor]" class="form-control" value="{{ old('transporte.placas_tractor') }}" maxlength="191"  required>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="placasCaja" class="control-label">Placas de la caja</label>
                    <input type="text" name="transporte[placas_caja]" class="form-control" value="{{ old('transporte.placas_caja') }}" maxlength="191" required>
                    <span class="material-input"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group ">
                    <label  for="tipoUnidad" class="control-label">Tipo de unidad</label>
                    <span class="twitter-typeahead">
                        <input type="text" class="form-control siggest-tipo-vehiculo" name="transporte[tipo_unidad]" value="{{ old('transporte.tipo_unidad') }}" maxlength="191" required>
                    </span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Medida</label>
                    <select class="selectpicker" name="transporte[medida_unidad]" data-style="select-with-transition"  title=" " required>
                        <option value="26 PIES" @if(old('transporte.medida_unidad') === '26 PIES') selected @endif >26 PIES</option> 
                        <option value="35 PIES" @if(old('transporte.medida_unidad') === '35 PIES') selected @endif >35 PIES</option> 
                        <option value="40 PIES" @if(old('transporte.medida_unidad') === '40 PIES') selected @endif >40 PIES</option> 
                        <option value="45 PIES" @if(old('transporte.medida_unidad') === '45 PIES') selected @endif >45 PIES</option> 
                        <option value="48 PIES" @if(old('transporte.medida_unidad') === '48 PIES') selected @endif >48 PIES</option> 
                        <option value="53 PIES" @if(old('transporte.medida_unidad') === '53 PIES') selected @endif >53 PIES</option>
                    </select>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="ejes" class="control-label">No. Ejes</label>
                    <input type="number" class="form-control" name="transporte[ejes]" value="{{ old('transporte.ejes') }}" min="1" max="20" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="cantidad" class="control-label">Cantidad</label>
                    <input type="number" class="form-control" name="transporte[cantidad]" value="{{ old('transporte.cantidad') }}" min="1" max="20" required>
                </div>
            </div>
        </div>
    </template>
    </card>  --}}

    <card type="header-icon" icon="fa-file-text-o" bg-color="blue">
    <template>
        <template slot="title">Documentos</template>
        
        <div class="row">
            <div class="col-md-12">
                <legend>Seleccione los documentos con la mercancia a cargar</legend>
            </div>
            <div class="col-md-12">
                <div class="group-form">
                    <select class="selectpicker" data-size="8" data-style="select-with-transition" title="<i class='fa fa-hand-o-right'></i> Seleccionar documento(s)" name="documentos[][id]" multiple required>
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
                <ul class="list-group">
                    @foreach($servicio->documentosDescarga as $index => $documento )
                        <li class="list-group-item">
                            <h4 class="list-group-item-heading">
                                    {{$documento->tipo_documento}} - {{$documento->documento}}
                                @if(!$documento->status)
                                    <span class="label label-success"><i class="fa fa-check" aria-hidden="true"></i> Cargado</span>
                                @endif
                            </h4>
                            <p class="list-group-item-text">
                                   @if($documento->descripcion)
                                    {{$documento->descripcion}}
                                   @else
                                    ...
                                   @endif
                            </p>
                        </li>           
                    @endforeach
                    
                </ul><!-- list group -->

            </div>
        </div>
    </template>
    </card> 

    @component('components.showTableArchivos',[
        'archivos'=>$servicio->archivosDescarga
    ])
    @endcomponent
    
    {{--  <card type="header-icon" icon="fa-paperclip" bg-color="blue">
    <template>
        <template slot="title">Archivos</template>
        <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Extensión</th>
                    <th>Peso</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicio->archivosDescarga as $index => $archivo)
                    <tr>
                        <td>
                            {{$index + 1 }}
                        </td>
                        
                        <td>
                            {{$archivo->nombre}}
                        </td>
                        <td>

                           <p>
                           @if( $archivo->minetype === 'application/pdf' )
                                <i class="fa fa-file-pdf-o text-muted fa-lg" aria-hidden="true"></i>
                            @elseif( $archivo->minetype === 'application/vnd.ms-excel' )
                                <i class="fa fa-file-excel-o text-muted fa-lg" aria-hidden="true"></i>
                            @elseif( $archivo->minetype === 'image/gif' || $archivo->minetype === 'image/jpg' || $archivo->minetype === 'image/jpeg' ||  $archivo->minetype === 'image/png')
                                <i class="fa fa-file-image-o text-muted fa-lg" aria-hidden="true"></i>
                            @else
                                <i class="fa fa-file-o text-muted fa-lg" aria-hidden="true"></i>
                            @endif
                           .{{$archivo->extension}}
                           </p>
                        
                        </td>
                        <td>
                                    {{$archivo->size}}
                        
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </template>
    </card>
      --}}
    {!! Form::submit('Enviar', array('class'=>'btn btn-primary')) !!}
{!! Form::close() !!}

</div>

@endsection
@push('scripts')
    @include('layouts.partials.errors')
    <script type="text/javascript">

    $(function() {
        demo.initFormExtendedDatetimepickers();
        demo.getCountry('.paises'); //sugerencia paises
        demo.getMarcaVehiculo('.get-marca-vehiculo'); //sujerencia marca de vehiculo
        demo.getTipoVehiculo('.siggest-tipo-vehiculo');
        
        $('[data-toggle="popover"]').popover();

        /*
        *    Typeahead Busqueda para cliente, destino, lineas de transportes
        */
        
        //TYPEAHEAD DESTINO
        let busquedaDestino=$('.search_destinatario');
        let getDataDestino = new Bloodhound({
            remote: {
                url: '/find/destino?q=%QUERY%',
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });
        getDataDestino.initialize();
        busquedaDestino.typeahead({
            hint: true,
            highlight: true,
            limit:8,
        }, {
            display: 'destino',
            source: getDataDestino.ttAdapter(),
            name: 'clientes',
            templates: {
        
                suggestion: function (data) {
                    return '<p>' + data.destino + '</p>';
                }
            }
        });
        //TYPEAHEAD TRANSPORTES
        let idtransporte=$('#idtransporte');
        let busquedaTransporte = $('#busqueda_transporte.search_transporte');
        let getDataTransportes = new Bloodhound({
            remote: {
                url: '/find/transporte?q=%QUERY%',
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });
        getDataTransportes.initialize();
        busquedaTransporte.typeahead({
            hint: true,
            highlight: true,
            limit:8,
        }, {
            display: 'nombre',
            source: getDataTransportes.ttAdapter(),
            name: 'transportes',
            templates: {
                empty:function(){
                    return '<h4 class="text-danger"> &nbsp;<i class="fa fa-exclamation-circle" aria-hidden="true"></i> La busqueda no obtuvo ningun resultado.</h4>';
                },
                suggestion: function (data) {
                    return '<p>' + data.nombre + ' ( '+ data.nombre_corto +' )' + '</p>';
                }
            }
        });
        let ltransporteSelected='';
        let ltransporte=function(eventObject, suggestionObject, suggestionDataset){
            ltransporteSelected=suggestionObject.nombre;
            idtransporte.val(suggestionObject.id);
            $('#busqueda_transporte').closest('div.form-group').removeClass('has-error');
        };
        busquedaTransporte.on('typeahead:selected', ltransporte);
        busquedaTransporte.on('typeahead:autocompleted', ltransporte);
        busquedaTransporte.on('typeahead:change', function($e,data){
            if(data !== ltransporteSelected){
                idtransporte.val('');
                $('#busqueda_transporte').closest('div.form-group').addClass('has-error');
            }
        });
            
        /*Termina typeahead*/   
 
        var validator = $('#formNuevoServicio').validate({
            errorPlacement: function(error, element) {
                $(element).closest('div.form-group').addClass('has-error');
                
            },
            submitHandler: function(form) {
                if(!$('#idtransporte').val()){
                    $.notify({
                        icon: "warning",
                        message: "Debes seleccionar una linea de trasnporte valida para continuar"

                    },{
                        type: 'warning',
                        timer: 4000,
                        placement: {
                            from: 'top',
                            align: 'right'
                        }
                    });
                    $('#busqueda_transporte').closest('div.form-group').addClass('has-error');
                    return;
                }
                    
                /*let validDocs=0;
                $('input[name^="documento"]').each(function() {
                    if( !$(this).is(':checked') ){
                        validDocs+=1;
                    }
                });
                if(!validDocs){
                    $('input[name^="documento"]').each(function() {
                        $(element).closest('div.checkbox').addClass('has-error');
                    });
                    $.notify({
                        icon: "warning",
                        message: "No se ha seleccionado ningun documento"

                    },{
                        type: 'warning',
                        timer: 4000,
                        placement: {
                            from: 'top',
                            align: 'right'
                        }
                    });
                    return ;
                }*/
                
                form.submit();
                
            }

        });
        

        

    });
    </script>
@endpush
