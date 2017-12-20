<template>
    <div class="row">
        <div class="col-xs-12" v-if="load">
            <card class="text-center">
                <p class="form-group text-muted" v-text="text"></p>
                <p>
                    <button 
                        type="button" 
                        class="btn btn-warning btn-lg" 
                        v-text="title"
                        @click="validar"
                        :disabled="disabled"
                        >
                    </button>  
                </p>
                <p>    
                    <button type="button" v-if="disabled" class="btn btn-success btn-lg" 
                        @click="validado"
                        >
                        Validado
                    </button>          
                </p>
                <p>    
                    <button type="button" v-if="disabled" class="btn btn-danger btn-lg" 
                        @click="error"
                        >
                        Validado
                    </button>          
                </p>
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
import card from "./../../cards/Card.vue";
import EventBus from './../../event-bus.js';
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
        }
    },
    mounted(){
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
                        this.load = true;
                    break;
            }
        },
        validar()
        {
            let self = this;
            axios.post('/maniobra/subtarea/'+ this.id,{
                    inputType: 'vlidation',
                    value:'onValidation',
                    _token: this.token 
            }).then(function(response){
                EventBus.$emit('onValidation');
                self.disabled=true;
            });
        },
        validado(){
            let self = this;
            axios.post('/maniobra/subtarea/'+ this.id,{
                    inputType: 'validation',
                    value:'okValidation',
                    _token: this.token 
            }).then(function(response){
                EventBus.$emit('okValidation');
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
                self.disabled=false;
            });
        },
    }
}
</script>

