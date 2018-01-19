<template>
    <div style="margin-top:2em;">
        <div v-if="supervisor.nombre">
            <div class="row" >
                <div class="col-md-12">
                    <div class="media" >
                        <div class="media-left" >
                            <img src="/img/supervisor.png"  class="img img-responsive img-circle " style="max-width:100px;">
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading title text-truncate" style="margin-top:.8em;" v-text="supervisor.nombre +' '+ supervisor.apellido"></h3>
                            <span class="text-uppercase text-muted" v-text="supervisor.user"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-xs-12">
                            <h3>Tareas</h3>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-xs-12">
                            <tarea-maniobra v-for="(tarea, index) in tareas" 
                                :datos="tarea"
                                :maniobraId="servicioId"
                                :key="index" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <ul class="list-inline">
                        <li>
                            <small>
                                <span class="label-default para-asignar" style="width:10px; height:10px; border-radius:50%; display:inline-block;"></span>
                                POR REALIZAR
                            </small>
                        </li>
                        <li>
                            <small>
                                <span class="label-info en-proceso" style="width:10px; height:10px; border-radius:50%; display:inline-block;"></span>
                                EN PROCESO
                            </small>
                        </li>
                        <li>
                            <small>
                                <span class="label-success finalizado" style="width:10px; height:10px; border-radius:50%; display:inline-block;"></span>
                                FINALIZADO
                            </small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div v-else >
            <p class="text-center lead text-muted">
                <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
            </p>
        </div>
        
    </div>
</template>
<script>
import tarea from './tarea-maniobra.vue';
export default {
    components:{
        'tarea-maniobra':tarea,
    },
    props:{
        supervisorId:{
            type: Number,
            required: true,
        },
        servicioId:{
            type: Number,
            required: true,
        }
    },
    data(){
        return {
             supervisor:{},
             tareas:{},
        }
    },
    created(){
        this.listenEvent();
    },
    mounted(){
        this.getSupervisor();
        this.getTarea();
    },
    methods:{
        getSupervisor(){
            let self = this;
            axios.get('/API/supervisor/' + this.supervisorId).then(function(response){
                self.supervisor = response.data;
            });
        },
        getTarea(){
            let self = this;
            axios.get('/API/supervision/getTareas/'+this.servicioId)
                .then(function (response) {
                    self.tareas = response.data;
            });
        },
        listenEvent(){
            let self = this;
            Echo.channel('maniobra-channel')
                .listen('ManiobraUpdate', (data) => {
                    if(self.servicioId == data.maniobra.servicio_id){
                        self.getTarea();
                    }
                });   
            Echo.channel('maniobra-channel')
                .listen('ManiobraInicio', (data) => {
                    if(self.servicioId == data.maniobra.servicio_id){
                        self.getTarea();
                    }
                });   
        }
    }
}
</script>
