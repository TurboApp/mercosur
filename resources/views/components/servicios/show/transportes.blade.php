<card>
    <template>
        <div class="form-horizontal">
            <div class="form-group">
                <label class="col-md-2 control-label">Linea de transporte</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" value="{{ $data->transporte->nombre }}" disabled>  
                </div>
            </div>
        
            <div class="form-group">
                <label class="col-md-2 control-label">Nombre del operador</label>
                <div class="col-md-10">
                    <input type="text" class="form-control"  value="{{ $data->nombre_operador }}" disabled>   
                </div>
            </div>
        
            <div class="form-group">
                <label class="col-md-2 control-label">No. de talon</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" value="{{ $data->talon_embarque }}" disabled>   
                </div>
                    
                <label class="col-md-2 control-label">Operación</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" value="{{ $data->operacion }}" disabled>   
                </div>
            
            </div>
                
            <div class="form-group">
                <label class="col-md-2 control-label">Marca del Vehiculo</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" value="{{ $data->marca_vehiculo }}" disabled>
                </div>
            </div>
                
            <div class="form-group">
                <label class="col-md-2 control-label">Placas del tractor</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" value="{{ $data->placas_tractor }}" disabled>
                </div>
           
                <label class="col-md-2 control-label">Placas de caja</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" value="{{ $data->placas_caja }}" disabled>
                </div>
                
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">Tipo de unidad</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" value="{{ $data->tipo_unidad }}" disabled>
                </div>
            </div>

            <div class="form-group">
                    <label class="col-md-2 control-label">Medida</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" value="{{ $data->medida_unidad }}" disabled/> 
                    </div>
                 
                    <label class="col-md-1 control-label">No. Ejes</label>
                    <div class="col-md-2">
                        <input type="number" class="form-control" value="{{ $data->ejes }}" disabled>
                    </div>

                    <label class="col-md-1 control-label">Cantidad</label>
                    <div class="col-md-2">
                        <input type="number" class="form-control" value="{{ $data->cantidad }}" disabled>
                    </div>
                </div>
            </div>  
    </template>
</card>