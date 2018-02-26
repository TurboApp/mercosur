<template>
   <div>
        <template>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h3 class="text-uppercase" v-text="title"></h3>
                    <span v-text="text"></span>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-12">
                    <div class="search-sup-wrapper">
                        <label >
                            <span v-show="!searching">
                                <i class="fa fa-search fa-lg" aria-hidden="true"></i>
                            </span>
                            <span v-show="searching">
                                <i class="fa fa-circle-o-notch fa-spin fa-lg fa-fw"></i>
                            </span>
                        </label>
                        <input class="search-sup-input" v-model="operario" @keyup="searchOperario" type="text" placeholder="Operario..." autofocus>   
                    </div>
                </div>
            </div>
            <div class="row">
                <div v-if="operarios.length == 0">
                    <p class="text-center lead">
                        <i class="fa fa-circle-o-notch fa-spin fa-lg fa-fw text-muted"></i>
                        <span class="sr-only">Loading...</span> Cargando...
                    </p>
                </div>
                
                <div class="col-xs-12 col-sm-6 col-md-4" v-for="(operario, index) in operarios" :key="index">
                    <card-operario  
                        :operario="operario" :index="index" :maniobraId="maniobraId"
                        @select-operario="selectOperario"
                        >
                    </card-operario>
                </div>
            </div>

           
        </template>       
        
    </div> 
</template>
<script>

import Card from './../../../../cards/Card.vue';
import CardTab from './../../../../cards/cardsTabs.vue';
import cardOperario from './card-operario.vue';
//import cardOperarioActivo from './card-operario-activo.vue';
//import operarioActivo from './operarioActivo.vue';
import EventBus from './../../../../event-bus';
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
  //      'card-operario-activo':cardOperarioActivo,
  //      'operario-activo':operarioActivo,
        'card':Card,
        'card-tab':CardTab,
    },
    data(){
        return {
            operarios:[],
            operario:'',
            searching:false,
            token:'',
            timeout:null,
            lengthActivos:0,
            lengthInactivos:0,
        }
    },
    created(){
        //Este evento se ejecuata cuando empieza la tarea de proceso de maniobra
        // EventBus.$on('iniciarProduccionOperarios', ()=>{
        //     let self = this;
        //     this.operarios.forEach(element => {
        //         //Agrega el registro en produccion de fuerza de tarea
        //         if( element.status == 1 && element.coordinacion_id == self.maniobraId ){
        //             axios.post('/maniobras/produccion/'+self.maniobraId+'/'+element.id, {
        //                 _token:this.token,
        //                 tipo:"iniciar"
        //             })
        //             .then(function(response){
        //                 //console.log(response.data);
        //             });
        //         }
        //     });
        // });
    },
    mounted(){
        this.token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        this.cargarOperarios();
    },
    methods:{
        cargarOperarios(){
            let self = this;
            axios.all([
                self.getOperariosActivos(self.maniobraId),
                self.getOperariosInactivos()
            ]).then(axios.spread( function ( operariosActivos, operariosInactivos ){
                if( ( operariosActivos.status + operariosInactivos.status ) !== 400 )
                {
                    window.location.reload(true);
                }else{
                    let lista = _.concat(operariosInactivos.data, operariosActivos.data);
                    lista = _.uniqBy(lista, 'id');
                    self.operarios = _.sortBy( lista, [ function(i){ return i.id } ]);
                    let activos = 0;
                    let inactivos = 0;
                    self.operarios.forEach(function(operario){
                        if(operario.status == 1){
                            activos = activos + 1;
                        }else{
                            inactivos = inactivos + 1;
                        }    
                    });
                    self.lengthActivos = activos;
                    self.lengthInactivos = inactivos;
                }
            }));

            
        },
        searchOperario(e){
            clearTimeout(this.timeout);
            let self = this;
            self.operarios=[];
            this.searching=true;
            this.timeout = setTimeout(function(){
                axios.all([
                self.filterOperarios(e.target.value),
                self.getOperariosActivos(self.maniobraId)
            ]).then(axios.spread(function ( filterOperarios, operariosActivos ){
                if( ( filterOperarios.status + operariosActivos.status) !== 400 ){
                    window.location.reload(true);
                }else{
                    let lista = _.concat(operariosActivos.data, filterOperarios.data);
                    lista = _.uniqBy(lista, 'id');
                    self.operarios = _.sortBy(lista, [function(i){ return i.id }]);
                    self.searching = false;
                }
                
            }));    
                // axios.get('/maniobra/operarios/'+e.target.value)
                //     .then(function (operariosInactivos) 
                //     {
                //         axios.get('/maniobra/operariosActivos/'+self.maniobraId).then(function (operariosActivos) 
                //             {
                //                 let lista = _.concat(operariosActivos.data, operariosInactivos.data);
                //                 lista = _.uniqBy(lista, 'id');
                //                 self.operarios = _.sortBy(lista, [function(i){ return i.id }]);
                //             }
                //         );  
                //         self.searching = false;
                //     }
                // );    
            }, 500);
        },
        selectOperario(isActive){
            let self = this;
            if(!isActive){
                alert("Lo sentimos pero el operario que trata de selecionar ya fue activado");
                window.location.reload(true);
            }
        },
       
        getOperariosInactivos(){
            return axios.get('/maniobra/operarios/');
        },
        getOperariosActivos(maniobra){
            return axios.get('/maniobra/operariosActivos/'+maniobra);
        },
        filterOperarios(filter){
            return axios.get('/maniobra/operarios/'+filter);
        }
    }
}
</script>
<style lang="scss">
    .fade-enter-active, .fade-leave-active {
        transition: all 1s;
    }
    .fade-enter, .fade-leave-to /* .list-leave-active below version 2.1.8 */ {
        opacity: 0;
        transform: translateY(30px);
    }

</style>


