<template>
   <div>
        <template>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h3 class="text-uppercase" v-text="title"></h3>
                </div>
            </div>
            <div class="row">
                <card >
                    <div class="row">
                        <div v-if="operariosActivos.length > 0" >
                            <card-operario v-for="(operario, index) in operariosActivos" :key="index" 
                                :operario="operario" :index="index" 
                            >
                            </card-operario>
                        </div>
                        <div v-else class="text-center">
                            <p class="text-muted lead">Aun no se ha seleccionado ningun operario</p>
                        </div>
                    </div>
                </card>
            </div>
        </template>       
    </div> 
</template>
<script>
import Card from './../../../../cards/Card.vue';
import cardOperario from './card-operario.vue';
export default {
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
    components:{
        'card-operario':cardOperario,
        'card':Card,
    },
    data(){
        return {
            operariosActivos:[],
            token:'',
        }
    },
    mounted(){
        this.token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        this.cargarOperariosActivos()
    },
    methods:{
        cargarOperariosActivos(){
            let self = this;
            axios.get('/maniobra/operariosActivos/'+this.maniobraId)
                .then(function (response) 
                {
                    self.operariosActivos = response.data;                    
                }
            );   
        },
    }
}
</script>
<style lang="scss">
    

</style>


