<template>
  <div>
        <h3 class="title">Datos generales</h3>
        <card>
        <template>
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-md-2 control-label">Recepción</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" :value="datosGenerales.datos.fecha" disabled>
                    </div>
                </div>

                <div class="form-group">                       
                    <label class="col-md-2 control-label">Agente</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" :value="datosGenerales.datos.agente" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label  class="col-md-2 control-label">Cliente</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" :value="datosGenerales.datos.cliente" disabled>
                    </div>
                </div>    
                        
                <div class="form-group">
                    <label for="destiinatario" class="col-md-2 control-label">Destinatario</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" :value="datosGenerales.datos.destino" disabled>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Observaciones</label>
                    <div class="col-md-10">
                        <textarea class="form-control" v-text="datosGenerales.datos.observaciones" disabled></textarea>
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
        datosGenerales:{
            type:[Array, Object],
            required:true
        },
    
    },
    
    
}
</script>

