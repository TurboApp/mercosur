<template>
<div>
    <card v-for="(transporte, index) in transportes" :key="index" >
        <div class="row">
            <div class="col-md-12">  
                <div class="form-group">
                    <span class="twitter-typeahead">
                        <label for="lineaTransporte" class="control-label">Linea de transporte</label>
                        <transporte-suggest name="" v-model="transporte.lineaTranporte" ></transporte-suggest>
                        <input type="text" class="transporte-id" :name="name_id_linea_transporte(index)" >
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">  
                <div class="form-group">
                    <label for="operadorUnidad" class="control-label">Nombre del operador</label>
                    <input type="text" class="form-control" :name="name_nombre_operador(index)" v-model="transporte.nombre_operador" required maxlength="120" >   
                </div>
            </div>
            <div class="col-md-4">  
                <div class="form-group">
                    <label for="n_talon" class="control-label">No. de talon</label>
                    <input type="text" class="form-control" :name="name_talon_embarque(index)" v-model="transporte.talon_embarque" maxlength="191" required>   
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="marcaVehiculo" class="control-label">Marca del Vehiculo</label>
                    <input type="text" :name="name_marca_vehiculo(index)" class="form-control get-marca-vehiculo" v-model="transporte.marca_vehiculo" maxlength="191" required>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="placasTractor" class="control-label">Placas del tractor</label>
                    <input type="text" :name="name_placas_tractor(index)" class="form-control" v-model="transporte.placas_tractor" maxlength="191"  required>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="placasCaja" class="control-label">Placas de la caja</label>
                    <input type="text" :name="name_placas_caja(index)" class="form-control" v-model="transporte.placas_caja" maxlength="191" required>
                    <span class="material-input"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group ">
                    <label  for="tipoUnidad" class="control-label">Tipo de unidad</label>
                    <span class="twitter-typeahead">
                        <input :id="tipoVehiculo(index)" type="text" class="form-control siggest-tipo-vehiculo" :name="name_tipo_unidad(index)" v-model="transporte.tipo_unidad" maxlength="191" required>
                    </span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Medida</label>
                    <select class="selectpicker" :name="name_medida_unidad(index)" data-style="select-with-transition" v-model="transporte.medida_unidad" title=" " required>
                        <option value="9 PIES" >9 PIES</option> 
                        <option value="26 PIES" >26 PIES</option> 
                        <option value="35 PIES" >35 PIES</option> 
                        <option value="40 PIES" >40 PIES</option> 
                        <option value="45 PIES" >45 PIES</option> 
                        <option value="48 PIES" >48 PIES</option> 
                        <option value="53 PIES" >53 PIES</option>
                    </select>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="ejes" class="control-label">No. Ejes</label>
                    <input type="number" class="form-control" :name="name_ejes(index)" v-model="transporte.ejes" min="1" max="20" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="cantidad" class="control-label">Cantidad</label>
                    <input type="number" class="form-control" :name="name_cantidad(index)" v-model="transporte.cantidad" min="1" max="20" required>
                </div>
            </div>
        </div>
        <div slot="footer">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-danger btn-just-icon btn-rounded " @click="rmTransporte(index)">
                        <i class="material-icons">delete</i> 
                    </button>
                </div>
            </div>
        </div>
    </card>
    
    <div class="row">
        <div class="col-md-12 text-right">
            <button type="button" class="btn btn-primary btn-simple" @click="addTransporte">
                <i class="material-icons">add_box</i> Agregar transporte
            </button>
        </div>
    </div>
</div>
</template>
<script>
import card from '../../../cards/Card.vue';
import transporteSuggest from './transporteSuggest'
import EventBus from '../../../event-bus.js';
export default {
    components:{
        'card':card,
        'transporte-suggest': transporteSuggest
    },

    name:'form-transporte',
    props : {
		tipo: {
            type: String,
            default:'origen'
        },
    },
    data(){
        
        return {
            id:this._uid,
            transportes:[
                {
                 lineaTranporte:'',
                 id_linea_transporte:'', 
                 nombre_operador:'',
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
    mounted(){
        //this.init_typeahead();
    },
    methods:{
       
        addTransporte(){

            this.transportes.push({
                lineaTranporte:'',
                id_linea_transporte:'', 
                nombre_operador:'',
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
        rmTransporte(index){
            this.transportes.splice( index , 1 )
            eventBus.$emit('remove')
            if(this.transportes.length<1){
                this.addTransporte();
            }
        },


        //nombres de campos     
        name_id_linea_transporte(indice){
            return 'transporte['+ (indice) +']['+ this.tipo +'][id_linea_transporte]';
            
        }, 
        name_nombre_operador(indice){
            return 'transporte['+ indice +']['+this.tipo+'][nombre_operador]';
        },
        name_talon_embarque(indice){
            return 'transporte['+indice+']['+this.tipo+'][talon_embarque]';
        },
        name_marca_vehiculo(indice){
            return 'transporte['+indice+']['+this.tipo+'][marca_vehiculo]';
        },
        name_placas_tractor(indice){
            return 'transporte['+indice+']['+this.tipo+'][placas_tractor]';
        },
        name_placas_caja(indice){
            return 'transporte['+indice+']['+this.tipo+'][placas_caja]';    
        },
        name_tipo_unidad(indice){
            return 'transporte['+indice+']['+this.tipo+'][tipo_unidad]';
        },
        name_medida_unidad(indice){
            return 'transporte['+indice+']['+this.tipo+'][medida_unidad]';
        },
        name_ejes(indice){
            return 'transporte['+indice+']['+this.tipo+'][ejes]';
        },
        name_cantidad(indice){
            return 'transporte['+indice+']['+this.tipo+'][cantidad]';
        },  

        tipoVehiculo(index){
            return 'tipoVehiculo'+index;
        },

    },

    updated() {
        $(this.$el).find('.selectpicker').selectpicker('refresh');
    },

}
</script>

