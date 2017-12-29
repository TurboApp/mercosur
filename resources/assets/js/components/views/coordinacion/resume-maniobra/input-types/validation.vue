<template>
    <div class="row">
        <div class="col-xs-12" v-if="load">
            <card >
                <div class="row"> 
                    <div class="col-sm-6 text-center">
                        <button type="button" 
                            class="btn btn-success btn-lg" 
                            @click="validado"
                            :disabled="disabled"
                            >
                            Valido 
                        </button>          
                    </div>
                    <div class="col-sm-6 text-center">
                        <button type="button" 
                            class="btn btn-danger btn-lg" 
                            @click="error"
                            :disabled="disabled"
                            >
                            Error
                        </button>          
                    </div>
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
import EventBus from './../../../../event-bus.js';
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
            disabled:true,
            load:false,
            estado:'',
            token:'',
        }
    },
    created(){
        this.EventBus();
    },
    mounted(){
        let self = this;
        this.token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        this.init();
    },
    methods:{
        init()
        {
            switch (this.value) {
                case 'onValidation':
                        this.disabled = false;
                        this.load = true;
                    break;
            
                case 'okValidation':
                        this.disabled = true;
                        this.load = true;
                    break;
            
                case 'errorValidation': 
                        this.disabled=true;
                        this.load = true;
                    break;
            
                default:
                        this.disabled=true;
                        this.load = true;
                    break;
            }
        },
       
        validado(){
            let self = this;
            axios.post('/maniobra/subtarea/'+ this.id,{
                    inputType: 'validation',
                    value:'okValidation',
                    _token: this.token 
            }).then(function(response){
                EventBus.$emit('okValidation');
                self.disabled = true;
            });
        },
        error(){
            let self = this;
            axios.post('/maniobra/subtarea/'+ this.id,{
                inputType: 'validation',
                value:'errorValidation',
                _token: this.token 
            }).then(function(response){
                EventBus.$emit('errorValidation');
                self.disabled=true;
            });
        },
        EventBus(){
            let self = this;
            EventBus.$on('validationEvent', (data)=>{
                if(data.validation.id == self.id){
                    switch (data.validation.value) {
                        case 'onValidation':
                                this.disabled = false;
                                this.load = true;
                            break;
                    
                        case 'okValidation':
                                this.disabled = true;
                                this.load = true;
                                
                            break;
                    
                        case 'errorValidation': 
                                this.disabled=true;
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

