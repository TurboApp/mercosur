<card>
<template>
    <div class="form-horizontal">
        <div class="form-group">
            <label class="col-md-2 control-label">Fecha de recepción</label>
            <div class="col-md-10">
                <input type="text" id="datepicker" name="datos_generales[fecha_recepcion]" value="{{ $data->fecha_recepcion->format('d/m/Y') }}" class="form-control"  maxlength="10" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label">Hora de recepción</label>
            <div class="col-md-10">
                <input type="text" id="timepicker" name="datos_generales[hora_recepcion]" value="{{$data->hora_recepcion}}" class="form-control" maxlength="12" required>
            </div>
        </div>

        <div class="form-group">                       
            <label class="col-md-2 control-label">Agente</label>
            <div class="col-md-10">
                <select id="agente_id" class="selectpicker" name="datos_generales[agente_id]" data-size="5" data-style="btn btn-primary btn-round" title="<span class='text-danger'>*</span> seleccione un agente " required>
                    @foreach($data['agentes'] as $agente)
                        @if (old('datos_generales.agente_id') == $agente->id)
                            <option value="{{$agente->id}}" selected>{{$agente->nombre_corto}}</option>
                        @else
                            <option value="{{$agente->id}}">{{$agente->nombre_corto}}</option>
                        @endif
                    @endforeach
                </select>
                <input type="hidden" name="datos_generales[agente_id]" value="{{$data->agente->id}}" />
            </div>
        </div>

        <div class="form-group">
            <label  class="col-md-2 control-label">Cliente</label>
            <div class="col-md-10">
                <input type="text" class="form-control" value="{{ $data->cliente->nombre_corto }} - {{$data->cliente->nombre}} {{ $data->cliente->rfc }}" disabled>
            </div>
        </div>    
                

        <div class="form-group">
            <label for="destiinatario" class="col-md-2 control-label">Destinatario</label>
            <div class="col-md-10">
                <input type="text" class="form-control" value="{{ $data->destino }} - {{$data->destino_pais}}" disabled>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-2 control-label">Observaciones</label>
            <div class="col-md-10">
                <textarea class="form-control" disabled>{{ $data->observaciones }}</textarea>
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
