<template>
    <div class="row">
        <div class="col-xs-12" v-if="load">
            <div v-if="isValid=='okValidation'">
                <p class="text-center lead text-muted">
                    La validación fue realizada satisfactoriamente
                </p>
            </div>
            <div v-else-if="isValid=='onValidation'">
                <p class="text-center lead text-muted" style="padding:15px 0;">
                    Verifique si las actividades anteriores fueron realizadas correctamente
                </p>
                <div class="row"> 
                    <div class="col-sm-6 text-center">
                        <h6>Ups, hay un error, enviar a correción</h6>
                        <button type="button" 
                            class="btn btn-danger btn-round btn-lg" 
                            @click="error"
                            :disabled="disabled"
                            >
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i> 
                            Error
                        </button>          
                    </div>
                    <div class="col-sm-6 text-center">
                        <h6>Todo estabien puede proseguir con la siguiente tarea</h6>
                        <button type="button" 
                            class="btn btn-success btn-round btn-lg" 
                            @click="validado"
                            :disabled="disabled"
                            >
                            <i class="fa fa-check" aria-hidden="true"></i> 
                            Proseguir
                        </button>          
                    </div>
                </div>
            </div>
            <div v-else-if="isValid=='errorValidation'" class="">
                <p class="text-muted lead text-center">
                    En espera de la rectificacción...
                </p>
            </div>
            <div v-else class="">
                <p class="text-muted lead text-center">
                    No hay nada que validar...
                </p>
            </div>

            
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
            isValid:'',
        }
    },
    
    created(){
        this.EventBus();
    },
    mounted(){
        console.log(this.$parent.$parent.$parent.$parent.$options);
        let self = this;
        this.isValid = this.value;
        this.token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        this.init();
        console.log(this.value);
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
            let self=this;
            let data={
                maniobraId:this.maniobraId,
                tareaId:this.tareaId    
            };
            swal({
                title: '¿Está seguro de validar?',
                text: "Ya no se podrán realizar correcciones",
                type: 'warning',
                showCancelButton: true,
                cancelButtonClass: 'btn btn-danger',
                confirmButtonClass: 'btn btn-success',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false
                }).then(function (result) {
                    axios.post('/maniobra/subtarea/'+ self.id,{
                        inputType: 'validation',
                        value:'okValidation',
                        _token: self.token 
                    }).then(function(response){
                        EventBus.$emit('okValidation', data );
                        self.disabled = true;
                    });
            })

            
            
        },
        error(){
            let self = this;
            let data={
                maniobraId:this.maniobraId,
                tareaId:this.tareaId    
            };
            axios.post('/maniobra/subtarea/'+ this.id,{
                inputType: 'validation',
                value:'errorValidation',
                _token: this.token 
            }).then(function(response){
                EventBus.$emit('errorValidation', data );
                self.disabled=true;
            });
        },
        EventBus(){
            let self = this;
            EventBus.$on('validationEvent', (data)=>{
                if(data.validation.id == self.id){
                    self.isValid = data.validation.value;
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

