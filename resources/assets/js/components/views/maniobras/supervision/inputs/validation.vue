<template>
    <div class="row">
        <div class="col-xs-12" v-if="load">
            <div v-if="isValid=='okValidation'">
                <p class="text-center lead text-muted">
                    La validación fue realizada satisfactoriamente
                </p>
            </div>
            <card v-else class="text-center">
                <p class="lead">Asegurese de haber realizado las actividades anteriores correctamente</p>
                <p class="form-group text-muted " v-text="text"></p>
                <p>
                    <button v-if="!disabled"
                        type="button" 
                        class="btn btn-warning btn-lg" 
                        v-text="title"
                        @click="validar"
                        :disabled="disabled"
                        >

                    </button>  
                </p>
                <div v-if="disabled">
                    <p class="lead text-muted">
                        En espera de ser validado
                    </p>
                </div>
                <div v-if="isValid=='errorValidation'">
                    <p>Debe de hacer correcciones</p>
                </div>
              
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
            switch (this.value) {
                case 'onValidation':
                        this.disabled = true;
                        EventBus.$emit('onValidation');
                        this.load = true;
                    break;
            
                case 'okValidation':
                        this.disabled = true;
                        EventBus.$emit('okValidation');
                        this.load = true;
                    break;
            
                case 'errorValidation': 
                        this.disabled=false;
                        EventBus.$emit('errorValidation');
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
            let data = {
                maniobraId : this.maniobraId,
                tareaId : this.tareaId
            };
            axios.post('/maniobra/subtarea/'+ this.id,{
                    inputType: 'validation',
                    value:'onValidation',
                    _token: this.token 
            }).then(function(response){
                EventBus.$emit('onValidation', data );
                self.disabled=true;
            });
        },
        EventBus(){
            let self = this;
            EventBus.$on('validationEvent', (data)=>{
                if(data.validation.id == self.id){
                    self.isValid = data.validation.value;
                    
                    //EventBus.$emit(data.validation.value);
                    switch (data.validation.value) {
                        case 'onValidation':
                                this.disabled = true;
                                this.load = true;
                            break;
            
                        case 'okValidation':
                                this.disabled = true;
                                this.load = true;
                               
                            break;
                    
                        case 'errorValidation': 
                                this.disabled=false;
                                this.load = true;
                               
                            break;
                    
                        default:
                                this.load = true;
                            break;
                    }
                    
                }
            })
        }
       
    }
}
</script>

