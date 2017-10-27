<h3 class="title">Transporte ({{$type}})</h3>
{{--  <card type="header-icon" icon="fa-truck">  --}}
<card>
    <template>
        {{--  <template slot="title">Transporte ({{$type}})</template>  --}}
        <div class="row">
            <div class="col-md-12">  
                <div class="form-group">
                    <span class="twitter-typeahead">
                        <label for="lineaTransporte" class="control-label">Linea de transporte</label>
                        <input type="text" id="busqueda_transporte{{$type}}" class="form-control search_transporte" name="lineaTransporte" value="{{ old('lineaTransporte') }}" required>
                        <input type="hidden" id="idtransporte{{$type}}" name="transporte[{{$type}}][id_linea_transporte]" value="{{ old('transporte.'.$type.'.id_linea_transporte') }}">
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">  
                <div class="form-group">
                    <label for="operadorUnidad" class="control-label">Nombre del operador</label>
                    <input type="text" class="form-control" name="transporte[{{$type}}][nombre_operador]" value="{{ old('transporte.'.$type.'.nombre_operador') }}" required maxlength="120" >   
                </div>
            </div>
            <div class="col-md-4">  
                <div class="form-group">
                    <label for="n_talon" class="control-label">No. de talon</label>
                    <input type="text" class="form-control" name="transporte[{{$type}}][talon_embarque]" value="{{ old('transporte.'.$type.'.talon_embarque') }}" maxlength="191" required>   
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="marcaVehiculo" class="control-label">Marca del Vehiculo</label>
                    <input type="text" name="transporte[{{$type}}][marca_vehiculo]" class="form-control get-marca-vehiculo" value="{{ old('transporte.'.$type.'.marca_vehiculo') }}" maxlength="191" required>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="placasTractor" class="control-label">Placas del tractor</label>
                    <input type="text" name="transporte[{{$type}}][placas_tractor]" class="form-control" value="{{ old('transporte.'.$type.'.placas_tractor') }}" maxlength="191"  required>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="placasCaja" class="control-label">Placas de la caja</label>
                    <input type="text" name="transporte[{{$type}}][placas_caja]" class="form-control" value="{{ old('transporte.'.$type.'.placas_caja') }}" maxlength="191" required>
                    <span class="material-input"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group ">
                    <label  for="tipoUnidad" class="control-label">Tipo de unidad</label>
                    <span class="twitter-typeahead">
                        <input type="text" class="form-control siggest-tipo-vehiculo" name="transporte[{{$type}}][tipo_unidad]" value="{{ old('transporte.'.$type.'.tipo_unidad') }}" maxlength="191" required>
                    </span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Medida</label>
                    <select class="selectpicker" name="transporte[{{$type}}][medida_unidad]" data-style="select-with-transition"  title=" " required>
                        <option value="26 PIES" @if(old('transporte.'.$type.'.medida_unidad') === '26 PIES') selected @endif >26 PIES</option> 
                        <option value="35 PIES" @if(old('transporte.'.$type.'.medida_unidad') === '35 PIES') selected @endif >35 PIES</option> 
                        <option value="40 PIES" @if(old('transporte.'.$type.'.medida_unidad') === '40 PIES') selected @endif >40 PIES</option> 
                        <option value="45 PIES" @if(old('transporte.'.$type.'.medida_unidad') === '45 PIES') selected @endif >45 PIES</option> 
                        <option value="48 PIES" @if(old('transporte.'.$type.'.medida_unidad') === '48 PIES') selected @endif >48 PIES</option> 
                        <option value="53 PIES" @if(old('transporte.'.$type.'.medida_unidad') === '53 PIES') selected @endif >53 PIES</option>
                    </select>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="ejes" class="control-label">No. Ejes</label>
                    <input type="number" class="form-control" name="transporte[{{$type}}][ejes]" value="{{ old('transporte.'.$type.'.ejes') }}" min="1" max="20" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="cantidad" class="control-label">Cantidad</label>
                    <input type="number" class="form-control" name="transporte[{{$type}}][cantidad]" value="{{ old('transporte.'.$type.'.cantidad') }}" min="1" max="20" required>
                </div>
            </div>
        </div>
    </template>
</card>
@push('scripts')
<script>
    $(function(){
                
        //TYPEAHEAD TRANSPORTES
        let idtransporte = $('#idtransporte{{$type}}');
        let busquedaTransporte = $('#busqueda_transporte{{$type}}.search_transporte');

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
    });
</script>
@endpush()