<template>
   <div>
        <template>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h3 class="text-uppercase" v-text="title"></h3>
                    <span v-text="text"></span>
                </div>
            </div>
            <div class="row">
                <div style="position:relative;">
                    <button type="button" class="btn btn-success btn-round btn-just-icon" @click="showActivos">
                        <i class="material-icons" v-if="!showList">add</i>
                        <i class="material-icons" v-else>remove</i>
                    </button>
                </div> 
                <!-- <transition name="fade"> -->
                    <div :class="hideCol">
                        <card style="height:835px;" >
                            <template slot="title">Inactivos </template>
                            <span v-text="operarios.length"></span> Operarios inactivos
                            
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

                            <div class="row" style="position:relative;">
                                <div v-if="operarios.length > 0"  style="height:670px; overflow-y:scroll; ">
                                    <!-- <transition-group name="fade"> -->
                                        <card-operario v-for="(operario, index) in operarios" :key="index" 
                                            :operario="operario" :index="index" 
                                            @select-operario="addOperario"
                                            @remove-select-operario="rmselectOperario">
                                        </card-operario>
                                    <!-- </transition-group> -->
                                </div>
                                <div v-else class="text-center">
                                    <h3>No hay datos que mostrar</h3>
                                </div>
                            </div>

                        </card>
                    </div>
                <!-- </transition> -->
                <!-- <transition  name="fade"> -->
                    <div :class="resizeCol">
                        <card style="height:835px;">
                            <template slot="title">Activos</template>
                            <p>
                            <span v-text="operariosActivos.length"></span> Operarios activos
                            </p>
                            <div class="row">
                                <div v-if="operariosActivos.length > 0"  style="height:742px; overflow-y:scroll;">
                                    <transition-group name="fade">
                                        <card-operario-activo v-for="(operarioActivo, index) in operariosActivos" :key="index" 
                                            :operarioActivo="operarioActivo" :index="index" 
                                            @remove-select-operario="rmselectOperario">
                                        </card-operario-activo>
                                    </transition-group>
                                </div>
                                <div v-else class="text-center">
                                    <p class="text-muted">Aun no se ha seleccionado ningun operario</p>
                                </div>
                            </div>
                        
                        </card>
                    </div>
                <!-- </transition> -->
            </div>
        </template>       
        
    </div> 
</template>
<script>

import Card from './../../../../cards/Card.vue';
import CardTab from './../../../../cards/cardsTabs.vue';
import cardOperario from './card-operario.vue';
import cardOperarioActivo from './card-operario-activo.vue';
import operarioActivo from './operarioActivo.vue';
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
        'card-operario-activo':cardOperarioActivo,
        'operario-activo':operarioActivo,
        'card':Card,
        'card-tab':CardTab,
    },
    data(){
        return {
            operarios:[],
            operario:'',
            searching:false,
            showList:false,
            operariosActivos:[],
            hideCol:'hidden',
            resizeCol:'col-sm-6 col-sm-offset-3',
            token:'',
        }
    },
    created(){
        //Este evento se ejecuata cuando empieza la tarea de proceso de maniobra
        EventBus.$on('iniciarProduccionOperarios', ()=>{
            let self = this;
            this.operariosActivos.forEach(element => {
                //Agrega el registro en produccion de fuerza de tarea
                axios.post('/maniobras/produccion/'+self.maniobraId+'/'+element.id, {
                    _token:this.token,
                    tipo:"iniciar"
                })
                .then(function(response){
                    //console.log(response.data);
                });
            });
        });
    },
    mounted(){
        this.token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        this.cargarOperarios();
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
        cargarOperarios(){
            let self = this;
            axios.get('/maniobra/operarios/')
                .then(function (response) 
                {
                    self.operarios = response.data;
                }
            );    
        },
        searchOperario(e){
            let self = this;
            this.searching=true;
            axios.get('/maniobra/operarios/'+e.target.value)
                .then(function (response) 
                {
                    self.operarios = response.data;
                    self.searching = false;
                }
            );    
        },
        addOperario(operario){
            let self= this;
            //Cambia el status a la fuerza de tarea
            self.operarios.splice(operario, 1);
            axios.patch('/maniobras/fuerza-tarea/status/'+operario.id+'/'+this.maniobraId,{
                    status: "1",
                    _token:this.token
            }).then(function(response){
                self.operariosActivos.push(response.data);
                self.cargarOperarios();
            });
            //Agrega el registro en produccion de fuerza de tarea
            axios.post('/maniobras/produccion/'+this.maniobraId+'/'+operario.id, {
                _token:this.token,
                tipo:"insertar"
            })
            .then(function(response){
                console.log(response.data);
            });
        },
        rmselectOperario(index){
            let self = this;
            let operario = this.operariosActivos[index];
            // Cambia el status de la fuerza de tarea
            axios.patch('/maniobras/fuerza-tarea/status/'+operario.id+'/0',{
                    status: "0",
                    _token:this.token
            }).then(function(response){
                self.operariosActivos.splice(index, 1);
                self.cargarOperarios();
            });
            // Elimina el registro en produccion de la fuerza de tarea
            axios.post('/maniobras/produccion/'+this.maniobraId+'/'+operario.id, {
                _token:this.token,
                tipo:"eliminar"
            })
            .then(function(response){
                console.log(response.data);
            });
        },
       
        showActivos(){
            this.showList=!this.showList;
            if(this.showList){
                this.hideCol='col-sm-6 show';
                this.resizeCol="col-sm-6 col-sm-offset-0";
            }else{
                this.hideCol='hidden';
                this.resizeCol="col-sm-6 col-sm-offset-3";
            }
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


