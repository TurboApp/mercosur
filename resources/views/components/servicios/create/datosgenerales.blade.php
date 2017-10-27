<h3 class="title">Datos generales</h3>
{{--  <card type="header-icon" icon="fa-info">  --}}
<card>
    <template>
        {{--  <template slot="title">Datos generales</template>  --}}
        <div class="row ">
            <div class="col-md-6 ">
                <div class="row">
                    <div class="form-group">                       
                        <div class="col-md-7">
                            @if(isset($servicio->id))                  

                                <select id="agente_id" class="selectpicker" name="datos_generales[agente_id]" data-style="btn btn-primary btn-round" disabled>
                                    <option value="{{$servicio->agente_id}}" selected>{{$servicio->agente->nombre_corto}}</option>
                                </select>
                                <input type="hidden" name="datos_generales[agente_id]" value="{{$servicio->agente_id}}" >
                            
                            @else

                                <select id="agente_id" class="selectpicker" name="datos_generales[agente_id]" data-size="5" data-style="btn btn-primary btn-round" title="seleccione un agente" required>
                                    @foreach($data['agentes'] as $agente)
                                        @if (old('datos_generales.agente_id') == $agente->id)
                                            <option value="{{$agente->id}}" selected>{{$agente->nombre_corto}}</option>
                                        @else
                                            <option value="{{$agente->id}}">{{$agente->nombre_corto}}</option>
                                        @endif
                                    @endforeach
                                </select>

                            @endif  
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
                            <input type="text" id="datepicker" name="datos_generales[fecha_recepcion]" value="{{$data['hoy']->format('j/m/Y')}}" class="form-control"  maxlength="10" required>
                            <span class="material-input"></span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-clock-o"></i> Hora
                            </span>
                            <input type="text" id="timepicker" name="datos_generales[hora_recepcion]" value="{{$data['hoy']->format('H:i')}}" class="form-control" maxlength="12" required>
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
                                @if(isset($servicio->id))                  
                                    <input type="text" class="form-control search_cliente" value="{{ $servicio->cliente->nombre }}" disabled>
                                    <input type="hidden" name="datos_generales[cliente_id]" value="{{$servicio->cliente_id}}" >
                                @else
                                    <input id="busqueda_cliente" type="text" class="form-control search_cliente" value="{{ old('cliente') }}" name="cliente" required>
                                    <input type="hidden" id="idcliente" name="datos_generales[cliente_id]" value="{{old('datos_generales.cliente_id')}}" >
                                @endif    
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
                            @if(isset($servicio->id))                  
                                <input type="text" class="form-control" name="rfc_cliente" value="{{ $servicio->cliente->rfc }}" disabled>
                            @else
                                <input id="rfc_cliente" type="text" class="form-control" placeholder="RFC del Cliente" name="rfc_cliente" value="{{ old('rfc_cliente') }}" readonly>
                            @endif
                        </div>
                    </div>
                </div>
            </div>            
        </div>
 
        
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="row">
                    <div class="form-group">
                        <label for="destiinatario" class="col-md-2 control-label">Destinatario</label>
                        <div class="col-md-10">
                            <span class="twitter-typeahead">
                                @if(isset($servicio->id))                  
                                    <input type="text" class="form-control search_destinatario" name="datos_generales[destino]" value="{{ $servicio->destino }}" maxlength="191"  required>
                                @else
                                    <input type="text" class="form-control search_destinatario" name="datos_generales[destino]" value="{{ old('datos_generales.destino') }}" maxlength="191"  required>
                                @endif
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
                                @if(isset($servicio->id))                  
                                    <input type="text" class="form-control paises" name="datos_generales[destino_pais]" value="{{ $servicio->destino_pais }}" maxlength="60" required>
                                @else
                                    <input type="text" class="form-control paises" name="datos_generales[destino_pais]" value="{{old('datos_generales.destino_pais')}}" maxlength="60" required>
                                @endif    
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
                    <textarea name="datos_generales[observaciones]" class="form-control" >{{ old('datos_generales.observaciones') }}</textarea>
                </div>
            </div>
        </div>

    </template>
</card>
@push('scripts')
<script>
    $(function(){
        $('#datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            useCurrent:true,
            locale: 'es',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true
            }
         });

         $('#timepicker').datetimepicker({
            format: 'HH:mm',    // use this format if you want the 24hours timepicker
//            format: 'h:mm A',    //use this format if you want the 12hours timpiecker with AM/PM toggle
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true

            }
         });
        app.getCountry('.paises'); //sugerencia paises
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
    });
</script>
@endpush