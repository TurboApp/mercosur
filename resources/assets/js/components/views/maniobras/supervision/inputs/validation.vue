<template>
    <div class="row">
        <div class="col-xs-12" v-if="load">
            <div v-if="isValid=='okValidation'">
                <p class="text-center lead text-muted">
                    La validación fue realizada satisfactoriamente
                </p>
            </div>
            <div v-else-if="isValid=='errorValidation'" class="text-center">
                <p class="text-danger lead">
                    No paso la validación<br/>
                    Debe de hacer algunas correcciones.
                </p>
                <button 
                    type="button" 
                    class="btn btn-warning btn-lg" 
                    @click="validar"
                    :disabled="disabled"
                    >
                    Volver a validar
                </button>
            </div>
            <div v-else-if="isValid=='onValidation'">
                <p class="lead text-muted text-center">
                    <i class="fa fa-cog fa-spin fa-lg fa-fw"></i>

                    En espera de ser validado
                    
                </p>
            </div>
            <card v-else class="text-center">
                <p class="lead">Asegurese de haber realizado las actividades anteriores correctamente</p>
                <p class="form-group text-muted " v-text="text"></p>
                <button 
                    type="button" 
                    class="btn btn-warning btn-lg" 
                    v-text="title"
                    @click="validar"
                    :disabled="disabled"
                    >
                </button>  
            </card>
            
        </div>
        <div v-else>
            <p class="lead text-center text-muted">
                <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i><br>
                Cargando...
            </p>
        </div>
    </div>
</template>
<script>
import card from "./../../../../cards/Card.vue";
import EventBus from './../../../../event-bus';
export default {
    components:{
        'card':card,
    },
    props:{
        title:{
            type:String,
            required:true
            },
        text:{
            type:String,
            required:true
            },
        id:{
            type:[Number]
        },
        maniobraId:{
            type:[Number]
        },
        value:{
            type:[String, Number]
        },
        tareaId:{
            type:Number,
        }
    },
    data(){
        return{
            disabled:false,
            load:false,
            estado:'',
            token:'',
            isValid:''
        }
    },
    created(){
        this.EventBus();
    },
    mounted(){
        this.isValid=this.value;
        this.token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        this.init();
    },
    methods:{
        init()
        {
            let data = {
                maniobraId : this.maniobraId,
                tareaId : this.tareaId
            };
           
            switch (this.value) {
                case 'onValidation':
                        //EventBus.$emit('onValidation', data);
                        this.disabled = true;
                        this.load = true;
                    break;
            
                case 'okValidation':
                        //EventBus.$emit('okValidation', data);
                        this.disabled = true;
                        this.load = true;
                    break;
            
                case 'errorValidation': 
                        //EventBus.$emit('errorValidation', data);
                        this.disabled=false;
                        this.load = true;
                    break;
            
                default:
                        this.disabled = false;
                        this.load = true;
                    break;
            }
        },
        validar()
        {
            let self = this;
            axios.post('/maniobra/subtarea/'+ this.id,{
                inputType: 'validation',
                    value:'onValidation',
                    _token: this.token 
            }).then(function(response){
                // if(response.data.tarea_id == self.tareaId){
                //     self.disabled=true;
                //     self.load = true;
                //     self.isValid='onValidation';
                // }
            });
        },
        EventBus(){
            let self = this;
            Echo.channel('maniobra-channel')
                .listen('ManiobraTareaValidacion', (data) => {
                    if(data.validation.id == self.id){
                        switch (data.validation.value) {

                            case 'onValidation':
                                    this.disabled = true;
                                    this.load = true;
                                    this.isValid= 'onValidation';
                                break;
                        
                            case 'okValidation':
                                    this.disabled = true;
                                    this.load = true;
                                    this.isValid= 'okValidation';
                                break;
                        
                            case 'errorValidation': 
                                    this.disabled=false;
                                    this.load = true;
                                    this.isValid= 'errorValidation';
                                break;
                        
                            default:
                                    this.load = true;
                                break;
                        }
                    }
                });              
            
            
                

            
        }
       
    }
}
</script>

