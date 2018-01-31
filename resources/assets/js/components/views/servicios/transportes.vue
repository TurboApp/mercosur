<template>
<div>
    <transporte-form  
        v-for="(transporte, index) in transportes" 
        :key="index" 
        :transporte="transporte"
        :index="index"
        :tipo="tipo"
        @remove="deleteTransporte(index)">
    </transporte-form>
    <!-- <div class="row">
        <div class="col-md-12 text-right">
            <button type="button" class="btn btn-primary btn-simple" @click="addTransporte">
                <i class="material-icons">add_box</i> Agregar transporte
            </button>
        </div>
    </div> -->
</div>
</template>
<script>
import transporteForm from './transporte-form.vue';
export default {
    components:{
        'transporte-form':transporteForm
    },
    props:['tipo'],
    data(){
        return {
            transportes:[
                {
                 lineaTranporte:'',
                 id_linea_transporte:'', 
                 nombre_operador:'',
                 telefono_operador:'',
                 talon_embarque:'',
                 marca_vehiculo:'',
                 placas_tractor:'',
                 placas_caja:'',
                 tipo_unidad:'',
                 medida_unidad:'',
                 ejes:'',
                 cantidad:'',  
                }
            ],
        }
    },
     methods:{
        addTransporte(){
            this.transportes.push({
                lineaTranporte:'',
                id_linea_transporte:'', 
                nombre_operador:'',
                telefono_operador:'',
                talon_embarque:'',
                marca_vehiculo:'',
                placas_tractor:'',
                placas_caja:'',
                tipo_unidad:'',
                medida_unidad:'',
                ejes:'',
                cantidad:'',  
            });
        },
        deleteTransporte(index){
            console.log("se Eliminara: "+index);
        	this.transportes.splice(index, 1);
    	}

       

    },

}
</script>

