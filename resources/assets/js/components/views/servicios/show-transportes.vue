<template>
  <div>
      <h3 class="title">Transportes</h3>
      <card v-for="(transporte, index) in transportes" :key="index">
          <template>
              <div class="form-horizontal">
                  <div class="form-group">
                      <label class="col-md-2 control-label">Linea de transporte</label>
                      <div class="col-md-10">
                          <input type="text" class="form-control" :value="transporte.lineaTransporte" disabled>  
                      </div>
                  </div>
              
                  <div class="form-group">
                      <label class="col-md-2 control-label">Nombre del operador</label>
                      <div class="col-md-10">
                          <input type="text" class="form-control"  :value="transporte.nombre_operador" disabled>   
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-md-2 control-label">Telefono del operador</label>
                      <div class="col-md-10">
                          <input type="text" class="form-control"  :value="transporte.telefono_operador" disabled>   
                      </div>
                  </div>
              
                  <div class="form-group">
                      <label class="col-md-2 control-label">No. de talon</label>
                      <div class="col-md-4">
                          <input type="text" class="form-control" :value="transporte.talon_embarque" disabled>   
                      </div>
                          
                      <label class="col-md-2 control-label">Operación</label>
                      <div class="col-md-4">
                          <input type="text" class="form-control" :value="transporte.operacion" disabled>   
                      </div>
                  
                  </div>
                      
                  <div class="form-group">
                      <label class="col-md-2 control-label">Marca del Vehiculo</label>
                      <div class="col-md-10">
                          <input type="text" class="form-control" :value="transporte.marca_vehiculo" disabled>
                      </div>
                  </div>
                      
                  <div class="form-group">
                      <label class="col-md-2 control-label">Placas del tractor</label>
                      <div class="col-md-4">
                          <input type="text" class="form-control" :value="transporte.placas_tractor" disabled>
                      </div>
                
                      <label class="col-md-2 control-label">Placas de caja</label>
                      <div class="col-md-4">
                          <input type="text" class="form-control" :value="transporte.placas_caja" disabled>
                      </div>
                      
                  </div>

                  <div class="form-group">
                      <label class="col-md-2 control-label">Tipo de unidad</label>
                      <div class="col-md-10">
                          <input type="text" class="form-control" :value="transporte.tipo_unidad" disabled>
                      </div>
                  </div>

                  <div class="form-group">
                          <label class="col-md-2 control-label">Medida</label>
                          <div class="col-md-4">
                              <input type="text" class="form-control" :value="transporte.medida_unidad" /> 
                          </div>
                      
                          <label class="col-md-1 control-label">No. Ejes</label>
                          <div class="col-md-2">
                              <input type="number" class="form-control" :value="transporte.ejes" disabled>
                          </div>

                          <label class="col-md-1 control-label">Cantidad</label>
                          <div class="col-md-2">
                              <input type="number" class="form-control" :value="transporte.cantidad" disabled>
                          </div>
                      </div>
                  </div>  
          </template>
      </card>
      
  </div>
</template>
<script>
export default {
  props:{
      transportes:{
        type: [Array, Object],
      }
  }
}
</script>

