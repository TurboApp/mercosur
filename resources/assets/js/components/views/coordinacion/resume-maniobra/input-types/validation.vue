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
                    <div class="col-sm-6 text-center red lighten-4" style="padding:15px 0;">
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
                    <div class="col-sm-6 text-center light-green accent-1" style="padding:15px 0;">
                        <h6>Todo estabien puede proseguir con la maniobra</h6>
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
                    <i class="fa fa-cog fa-spin fa-lg fa-fw"></i>
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
        let self = this;
        this.isValid = this.value;
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
                        this.disabled = false;
                        this.load = true;
                    break;
            
                case 'okValidation':
                        EventBus.$emit('okValidation', data);
                        this.disabled = true;
                        this.load = true;
                    break;
            
                case 'errorValidation': 
                        EventBus.$emit('errorValidation', data);
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
                        // if(response.data.tarea_id == self.tareaId){
                        //     self.disabled = true;
                        //     self.isValid='okValidation';
                        // }
                    });
            });
        },
        error(){
            let self = this;
            axios.post('/maniobra/subtarea/'+ this.id,{
                inputType: 'validation',
                value:'errorValidation',
                _token: this.token 
            }).then(function(response){
                // if(response.data.tarea_id == self.tareaId){
                //     self.disabled=true;
                //     self.isValid='errorValidation';
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
                                self.isValid = 'onValidation';
                                self.disabled = false;
                                self.load = true;

                            break;
                            case 'okValidation':
                                    self.disabled = true;
                                    //self.load = true;
                                    self.isValid= 'okValidation';
                                break;
                        
                            case 'errorValidation': 
                                    self.disabled=true;
                                    
                                    self.isValid= 'errorValidation';
                                break;
                        
                            default:
                                    self.load = true;
                                break;
                        }
                    }
                });   
        }
    }
}
</script>

