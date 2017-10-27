<h3 class="title">Transporte ({{ $data->type }})</h3>
{{--  <card type="header-icon" icon="fa-truck">  --}}
<card>
    <template>
        {{--  <template slot="title">Transporte ({{ $data->type }})</template>  --}}
        <div class="row">
            <div class="col-md-12">  
                <div class="form-group">
                    <span class="twitter-typeahead">
                        <label class="control-label">Linea de transporte</label>
                        <input type="text" class="form-control" value="{{ $data->transporte->nombre }}" disabled>  
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">  
                <div class="form-group">
                    <label for="operadorUnidad" class="control-label">Nombre del operador</label>
                    <input type="text" class="form-control"  value="{{ $data->nombre_operador }}" disabled>   
                </div>
            </div>
            <div class="col-md-4">  
                <div class="form-group">
                    <label for="n_talon" class="control-label">No. de talon</label>
                    <input type="text" class="form-control" value="{{ $data->talon_embarque }}" disabled>   
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="marcaVehiculo" class="control-label">Marca del Vehiculo</label>
                    <input type="text" class="form-control" value="{{ $data->marca_vehiculo }}" disabled>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="placasTractor" class="control-label">Placas del tractor</label>
                    <input type="text" class="form-control" value="{{ $data->placas_tractor }}" disabled>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="placasCaja" class="control-label">Placas de la caja</label>
                    <input type="text" class="form-control" value="{{ $data->placas_caja }}" disabled>
                    <span class="material-input"></span>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group ">
                    <label  for="tipoUnidad" class="control-label">Tipo de unidad</label>
                    <input type="text" class="form-control" value="{{ $data->tipo_unidad }}" disabled>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Medida</label>
                    <select class="selectpicker" data-style="select-with-transition" disabled>
                        <option selected>{{ $data->medida_unidad }}</option> 
                    </select>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="ejes" class="control-label">No. Ejes</label>
                    <input type="number" class="form-control" value="{{ $data->ejes }}" disabled>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="cantidad" class="control-label">Cantidad</label>
                    <input type="number" class="form-control" value="{{ $data->cantidad }}" disabled>
                </div>
            </div>  
        </div>
    </template>
</card>