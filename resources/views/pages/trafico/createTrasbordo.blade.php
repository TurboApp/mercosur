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
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <h2>Trasbordo</h2>
        </div>
        <div class="col-md-6">
            <div class="text-right form-group">
                {{$data['hoy']->format('l j \\d\\e F \\d\\e Y')}}
                <p class="lead text-muted">Número de servicio {{$data["numero_servicio"]}}</p>
            </div>
        </div>
    </div>
    {!! Form::open(array('url' => '/trafico/trasbordo', 'method'=>'post', 'id'=>'formNuevoServicio', 'class'=>'form-horizontal','files'=>true, 'autocomplete'=>'off')) !!}
    
    <card>
    <template>
        <template slot="title">Datos generales</template>
        <div class="row ">
            <div class="col-md-6 ">
                <div class="row">
                    <div class="form-group">                       
                        <div class="col-md-6">
                            <select id="agente_id" class="selectpicker" name="datos_generales[agente_id]" data-style="btn btn-primary btn-round" data-size="5" title="seleccione un agente" required>
                                @foreach($data['agentes'] as $agente)
                                    @if (old('datos_generales.agente_id') == $agente->id)
                                        <option value="{{$agente->id}}" selected>{{$agente->nombre_corto}}</option>
                                    @else
                                        <option value="{{$agente->id}}">{{$agente->nombre_corto}}</option>
                                    @endif
                                @endforeach
                            </select>
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
                            <span class="material-input"></span>
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
                                <input id="busqueda_cliente" type="text" class="form-control search_cliente" value="{{ old('cliente') }}" name="cliente" required>
                                <input type="hidden" id="idcliente" name="datos_generales[cliente_id]" value="{{old('datos_generales.cliente_id')}}" >
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
                            <input id="rfc_cliente" type="text" class="form-control" placeholder="RFC del Cliente" name="rfc_cliente" value="{{ old('rfc_cliente') }}" readonly>
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
                                <input type="text" class="form-control search_destinatario" name="datos_generales[destino]" value="{{ old('datos_generales.destino') }}" maxlength="191"  required>
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
                                <input type="text" class="form-control paises" name="datos_generales[destino_pais]" value="{{old('datos_generales.destino_pais')}}" maxlength="35" required>
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


    <card type="header-icon" icon="fa-truck" bg-color="blue">
    <template>
        <template slot="title">Transporte - Descarga</template>
        <div class="row">
            <div class="col-md-12">  
                <div class="form-group">
                    <span class="twitter-typeahead">
                        <label for="lineaTransporte" class="control-label">Linea de transporte</label>
                        <input type="text" id="busqueda_transporte_descarga" class="form-control search_transporte" name="lineaTransporteDescarga" value="{{ old('lineaTransporte.descarga.transporte') }}" required>
                        <input type="hidden" id="idtransporteDescarga" name="transporte[descarga][id_linea_transporte]" value="{{ old('transporte.descarga.id_linea_transporte') }}">
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">  
                <div class="form-group">
                    <label for="operadorUnidad" class="control-label">Nombre del operador</label>
                    <input type="text" class="form-control" name="transporte[descarga][nombre_operador]" value="{{ old('transporte.descarga.nombre_operador') }}" maxlength="120" required>   
                </div>
            </div>
            <div class="col-md-4">  
                <div class="form-group">
                    <label for="n_talon" class="control-label">No. de talon</label>
                    <input type="text" class="form-control" name="transporte[descarga][talon_embarque]" value="{{ old('transporte.descarga.talon_embarque') }}" maxlength="191" required>   
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="marcaVehiculo" class="control-label">Marca del Vehiculo</label>
                    <input type="text" name="transporte[descarga][marca_vehiculo]" class="form-control get-marca-vehiculo" value="{{ old('transporte.descarga.marca_vehiculo') }}" maxlength="191" required>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="placasTractor" class="control-label">Placas del tractor</label>
                    <input type="text" name="transporte[descarga][placas_tractor]" class="form-control" value="{{ old('transporte.descarga.placas_tractor') }}" maxlength="191"  required>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="placasCaja" class="control-label">Placas de la caja</label>
                    <input type="text" name="transporte[descarga][placas_caja]" class="form-control" value="{{ old('transporte.descarga.placas_caja') }}" maxlength="191" required>
                    <span class="material-input"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group ">
                    <label  for="tipoUnidad" class="control-label">Tipo de unidad</label>
                    <span class="twitter-typeahead">
                        <input type="text" class="form-control siggest-tipo-vehiculo" name="transporte[descarga][tipo_unidad]" value="{{ old('transporte.descarga.tipo_unidad') }}" maxlength="191" required>
                    </span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Medida</label>
                    <select class="selectpicker" name="transporte[descarga][medida_unidad]" data-style="select-with-transition"  title=" " required>
                        <option value="26 PIES" @if(old('transporte.descarga.medida_unidad') === '26 PIES') selected @endif >26 PIES</option> 
                        <option value="35 PIES" @if(old('transporte.descarga.medida_unidad') === '35 PIES') selected @endif >35 PIES</option> 
                        <option value="40 PIES" @if(old('transporte.descarga.medida_unidad') === '40 PIES') selected @endif >40 PIES</option> 
                        <option value="45 PIES" @if(old('transporte.descarga.medida_unidad') === '45 PIES') selected @endif >45 PIES</option> 
                        <option value="48 PIES" @if(old('transporte.descarga.medida_unidad') === '48 PIES') selected @endif >48 PIES</option> 
                        <option value="53 PIES" @if(old('transporte.descarga.medida_unidad') === '53 PIES') selected @endif >53 PIES</option>
                    </select>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="ejes" class="control-label">No. Ejes</label>
                    <input type="number" class="form-control" name="transporte[descarga][ejes]" value="{{ old('transporte.descarga.ejes') }}" min="1" max="20" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="cantidad" class="control-label">Cantidad</label>
                    <input type="number" class="form-control" name="transporte[descarga][cantidad]" value="{{ old('transporte.descarga.cantidad') }}" min="1" max="20"
                     required>
                </div>
            </div>
        </div>
    </template>
    </card>


    <!-- Transporte Carga -->

    <card type="header-icon" icon="fa-truck" bg-color="blue">
    <template>
        <template slot="title">Transporte - Carga</template>
        <div class="row">
            <div class="col-md-12">  
                <div class="form-group">
                    <span class="twitter-typeahead">
                        <label for="lineaTransporte" class="control-label">Linea de transporte</label>
                        <input type="text" id="busqueda_transporte_carga" class="form-control search_transporte" name="lineaTransporteCarga" value="{{ old('lineaTransporte.carga.transporte') }}" required>
                        <input type="hidden" id="idtransporteCarga" name="transporte[carga][id_linea_transporte]" value="{{ old('transporte.carga.id_linea_transporte') }}">
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">  
                <div class="form-group">
                    <label for="operadorUnidad" class="control-label">Nombre del operador</label>
                    <input type="text" class="form-control" name="transporte[carga][nombre_operador]" value="{{ old('transporte.carga.nombre_operador') }}" maxlength="120" required>   
                </div>
            </div>
            <div class="col-md-4">  
                <div class="form-group">
                    <label for="n_talon" class="control-label">No. de talon</label>
                    <input type="text" class="form-control" name="transporte[carga][talon_embarque]" value="{{ old('transporte.carga.talon_embarque') }}" maxlength="191" required>   
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="marcaVehiculo" class="control-label">Marca del Vehiculo</label>
                    <input type="text" name="transporte[carga][marca_vehiculo]" class="form-control get-marca-vehiculo" value="{{ old('transporte.carga.marca_vehiculo') }}" maxlength="191" required>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="placasTractor" class="control-label">Placas del tractor</label>
                    <input type="text" name="transporte[carga][placas_tractor]" class="form-control" value="{{ old('transporte.carga.placas_tractor') }}" maxlength="191"  required>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="placasCaja" class="control-label">Placas de la caja</label>
                    <input type="text" name="transporte[carga][placas_caja]" class="form-control" value="{{ old('transporte.carga.placas_caja') }}" maxlength="191" required>
                    <span class="material-input"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group ">
                    <label  for="tipoUnidad" class="control-label">Tipo de unidad</label>
                    <span class="twitter-typeahead">
                        <input type="text" class="form-control siggest-tipo-vehiculo" name="transporte[carga][tipo_unidad]" value="{{ old('transporte.carga.tipo_unidad') }}" maxlength="191" required>
                    </span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Medida</label>
                    <select class="selectpicker" name="transporte[carga][medida_unidad]" data-style="select-with-transition"  title=" " required>
                        <option value="26 PIES" @if(old('transporte.carga.medida_unidad') === '26 PIES') selected @endif >26 PIES</option> 
                        <option value="35 PIES" @if(old('transporte.carga.medida_unidad') === '35 PIES') selected @endif >35 PIES</option> 
                        <option value="40 PIES" @if(old('transporte.carga.medida_unidad') === '40 PIES') selected @endif >40 PIES</option> 
                        <option value="45 PIES" @if(old('transporte.carga.medida_unidad') === '45 PIES') selected @endif >45 PIES</option> 
                        <option value="48 PIES" @if(old('transporte.carga.medida_unidad') === '48 PIES') selected @endif >48 PIES</option> 
                        <option value="53 PIES" @if(old('transporte.carga.medida_unidad') === '53 PIES') selected @endif >53 PIES</option>
                    </select>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="ejes" class="control-label">No. Ejes</label>
                    <input type="number" class="form-control" name="transporte[carga][ejes]" value="{{ old('transporte.carga.ejes') }}" min="1" max="20" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="cantidad" class="control-label">Cantidad</label>
                    <input type="number" class="form-control" name="transporte[carga][cantidad]" value="{{ old('transporte.carga.cantidad') }}" min="1" max="20" required>
                </div>
            </div>
        </div>
    </template>
    </card>


    
    <card type="header-icon" icon="fa-file-text-o" bg-color="blue">
    <template>
        <template slot="title">Registro de documentos</template>
        <add-document ></add-document>
    </template>
    </card> 
    
    <card type="header-icon" icon="fa-paperclip" bg-color="blue">
    <template>
        <template slot="title">Archivos</template>
        <a class="file_input btn-simple btn btn-primary btn-block" data-jfiler-name="files" data-jfiler-extensions="jpg, jpeg, png, gif, pdf, xls, xlsx, ppt, pptx, doc, docx">
            <i class="material-icons">attach_file</i>
            Adjuntar archivos
        </a> 
            
    </template>
    </card>

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
        
        /*
        *    Typeahead Busqueda para cliente, destino, lineas de transportes
        */
        //TYPEAHEAD CLIENTE

        let busquedaCliente = $('#busqueda_cliente.search_cliente');
        let rfcCliente = $('#rfc_cliente');
        let idcliente=$('#idcliente');
        let getDataClientes = new Bloodhound({
            remote: {
                url: '/find/cliente?q=%QUERY%',
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });
        getDataClientes.initialize();
        busquedaCliente.typeahead({
            hint: true,
            highlight: true,
            limit:8,
        }, {
            display: 'nombre',
            source: getDataClientes.ttAdapter(),
            name: 'clientes',
            templates: {
                empty:function(){
                    return '<h4 class="text-danger"> &nbsp;<i class="fa fa-exclamation-circle" aria-hidden="true"></i> La busqueda no obtuvo ningun resultado.</h4>';
                },
                suggestion: function (data) {
                    return '<p>' + data.nombre + '</p>';
                }
            }
        });

        let clienteSelected='';
        let clienteSeleccionado=function(eventObject, suggestionObject, suggestionDataset){
            clienteSelected=suggestionObject.nombre;
            rfcCliente.val(suggestionObject.rfc);
            idcliente.val(suggestionObject.id);
            $('#busqueda_cliente').closest('div.form-group').removeClass('has-error');
        }     
        busquedaCliente.on('typeahead:selected', clienteSeleccionado);
        busquedaCliente.on('typeahead:autocompleted', clienteSeleccionado);
        busquedaCliente.on('typeahead:change', function($e,data){
            if(data!==clienteSelected){
                rfcCliente.val('');
                idcliente.val('');
                $('#busqueda_cliente').closest('div.form-group').addClass('has-error');
            }
        });
        
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
        
        //TYPEAHEAD TRANSPORTES Descarga
        let idtransporteDescarga=$('#idtransporteDescarga');
        let busquedaTransporteDescarga = $('#busqueda_transporte_descarga.search_transporte');
        let getDataTransportesDescarga = new Bloodhound({
            remote: {
                url: '/find/transporte?q=%QUERY%',
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });
        getDataTransportesDescarga.initialize();
        busquedaTransporteDescarga.typeahead({
            hint: true,
            highlight: true,
            limit:8,
        }, {
            display: 'nombre',
            source: getDataTransportesDescarga.ttAdapter(),
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
        let ltransporteDescargaSelected='';
        let ltransporteDescarga=function(eventObject, suggestionObject, suggestionDataset){
            ltransporteDescargaSelected=suggestionObject.nombre;
            idtransporteDescarga.val(suggestionObject.id);
            $('#busqueda_transporte_descarga').closest('div.form-group').removeClass('has-error');
        };
        busquedaTransporteDescarga.on('typeahead:selected', ltransporteDescarga);
        busquedaTransporteDescarga.on('typeahead:autocompleted', ltransporteDescarga);
        busquedaTransporteDescarga.on('typeahead:change', function($e,data){
            if(data !== ltransporteDescargaSelected){
                idtransporteDescarga.val('');
                $('#busqueda_transporte_descarga').closest('div.form-group').addClass('has-error');
            }
        });
            

        //TYPEAHEAD TRANSPORTES Carga
        let idtransporteCarga=$('#idtransporteCarga');
        let busquedaTransporteCarga = $('#busqueda_transporte_carga.search_transporte');
        let getDataTransportesCarga = new Bloodhound({
            remote: {
                url: '/find/transporte?q=%QUERY%',
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });
        getDataTransportesCarga.initialize();
        busquedaTransporteCarga.typeahead({
            hint: true,
            highlight: true,
            limit:8,
        }, {
            display: 'nombre',
            source: getDataTransportesCarga.ttAdapter(),
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
        let ltransporteCargaSelected='';
        let ltransporteCarga=function(eventObject, suggestionObject, suggestionDataset){
            ltransporteCargaSelected=suggestionObject.nombre;
            idtransporteCarga.val(suggestionObject.id);
            $('#busqueda_transporte_carga').closest('div.form-group').removeClass('has-error');
        };
        busquedaTransporteCarga.on('typeahead:selected', ltransporteCarga);
        busquedaTransporteCarga.on('typeahead:autocompleted', ltransporteCarga);
        busquedaTransporteCarga.on('typeahead:change', function($e,data){
            if(data !== ltransporteCargaSelected){
                idtransporteCarga.val('');
                $('#busqueda_transporte_carga').closest('div.form-group').addClass('has-error');
            }
        });
            
        /*Termina typeahead*/   

       
        
        var validator = $('#formNuevoServicio').validate({
            errorPlacement: function(error, element) {
                $(element).closest('div.form-group').addClass('has-error');
                $(element).siblings( ".btn" ).addClass('btn-danger');
                $(element).siblings( ".select-with-transition" ).addClass('error_selectpicker');
            },
            submitHandler: function(form) {
                if(!$('#idcliente').val()){
                    $.notify({
                        icon: "warning",
                        message: "Debes seleccionar un cliente valido para continuar"
                    },{
                        type: 'warning',
                        timer: 4000,
                        placement: {
                            from: 'top',
                            align: 'right'
                        }
                    });
                    $('#busqueda_cliente').closest('div.form-group').addClass('has-error');
                    return;
                }
                if(!$('#idtransporteCarga, #idtransporteDescarga').val()){
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
                    
                let validDocs=0;
                $('select[name^="documento"],input[name^="documento"]').each(function() {
                    if($(this).val()=='' && $(this).prop('required')){
                        $(this).closest('div.card-collapse').addClass("has-error");
                        validDocs+=1;
                    }
                });
                if(validDocs>1){
                    $.notify({
                        icon: "warning",
                        message: "Algunos documentos no se registraron correctamente"

                    },{
                        type: 'warning',
                        timer: 4000,
                        placement: {
                            from: 'top',
                            align: 'right'
                        }
                    });
                    return ;
                }
                
                form.submit();
                
            }

        });
        $('.selectpicker').on('change', function () {
            $(this).valid();
            $(this).siblings( ".btn" ).removeClass('btn-danger');
            $(this).siblings( ".select-with-transition" ).removeClass('error_selectpicker');
            $(this).closest( ".form-group" ).removeClass('has-error');
        });

        $('.file_input').filer({
            showThumbs: true,
            maxSize: 2,
            templates: {
                box: '<ul class="jFiler-item-list"></ul>',
                item: '<li class="jFiler-item">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-info">\
                                            <span class="jFiler-item-title"><b title="@{{fi-name}}">@{{fi-name | limitTo: 25}}</b></span>\
                                        </div>\
                                        @{{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left">\
                                            <li><span class="jFiler-item-others">@{{fi-icon}} @{{fi-size2}}</span></li>\
                                        </ul>\
                                        <ul class="list-inline pull-right">\
                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                    </div>\
                                </div>\
                            </div>\
                        </li>',
                itemAppend: '<li class="jFiler-item">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-info">\
                                            <span class="jFiler-item-title"><b title="@{{fi-name}}">@{{fi-name | limitTo: 25}}</b></span>\
                                        </div>\
                                        @{{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left">\
                                            <span class="jFiler-item-others">@{{fi-icon}} @{{fi-size2}}</span>\
                                        </ul>\
                                        <ul class="list-inline pull-right">\
                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                    </div>\
                                </div>\
                            </div>\
                        </li>',
                progressBar: '<div class="bar"></div>',
                itemAppendToEnd: true,
                removeConfirmation: true,
                _selectors: {
                    list: '.jFiler-item-list',
                    item: '.jFiler-item',
                    progressBar: '.bar',
                    remove: '.jFiler-item-trash-action',
                }
            },
            addMore: true,
            captions: {
                button: "Seleccionar archivos",
                feedback: "Seleccionar archivos para subir",
                feedback2: "Los archivos fueron elejidos",
                drop: "Descargar archivo aquí para cargar",
                removeConfirmation: "¿Seguro que quieres eliminar este archivo?",
                errors: {
                    filesLimit: "Sólo se pueden cargar un maximo de @{{fi-limit}} archivos.",
                    filesType: "Este tipo de archivo no es valido",
                    filesSize: "¡El archivo '@{{fi-name}}' es muy grande! \nPor favor cargue achivos no mayores a @{{fi-maxSize}} MB.",
                    filesSizeAll: "¡El total de carga de los archvivos que has elegido supera los @{{fi-maxSize}}!\nPor favor cargue archivos menores a @{{fi-maxSize}} MB."
                }
            },
            files: []
        });

    });
    </script>
@endpush
