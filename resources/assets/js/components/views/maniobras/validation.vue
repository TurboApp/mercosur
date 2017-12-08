<template>
    <div class="row">
        <div class="col-xs-12">
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
        }
    },
    data(){
        return{
            disabled:false,
        }
    },
    methods:{
        validar(){
            this.disabled=true;
            EventBus.$emit('onValidation');
        },
        validado(){
            this.disabled=false;
            EventBus.$emit('okValidation');
        },
        error(){
            this.disabled=false;
            EventBus.$emit('errorValidation');
        },
    }
}
</script>

