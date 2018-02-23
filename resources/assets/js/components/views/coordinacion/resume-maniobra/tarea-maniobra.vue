<template>
    <div>
        <card class="cardTaksShowInfo" style="margin:10px 0; position: relative;">
            <div class="container-fluid">
                <div class="row collapseInfo" @click="showInfo" style="padding:15px 20px;">
                    <div class="col-xs-2 col-sm-1">
                        <span :class="statusIcon">
                            <i class="fa fa-circle fa-stack-2x "></i>
                            <i class="fa-stack-1x fa-inverse" :class="datos.icono"></i>
                        </span>
                    </div>
                    <div class="col-xs-6 col-sm-8 ">
                        <h4 v-text="datos.titulo_corto" style="margin:3px 0;"></h4>
                        <h6 v-text="datos.titulo_largo" style="margin:3px 0;"></h6>
                    </div>
                    <div class="col-xs-4 col-sm-3">
                        <div class="text-center">
                            <h4 v-html="tareaDuracion(datos.inicio, datos.final)"></h4>
                            <small><i class="fa fa-clock-o" aria-hidden="true"></i>
                            Duración</small>
                        </div>
                    </div>

                </div>
                <transition name="fade">
                    <div class="row" v-if="show" style="padding:15px 20px;">
                        <hr>
                        <div class="col-xs-12">
                            <subtareas-maniobra 
                                :tarea-id="datos.id" 
                                :tarea-tipo="datos.tipo" 
                                :maniobra-id="maniobraId" 
                                :auth-id="authId" />
                        </div>
                    </div>
                </transition>
            </div>
        </card>
    </div>
</template>
<script>
var moment = require('moment');
import card from './../../../cards/Card.vue';
import subtareas from './subtarea-maniobra.vue';
import EventBus from './../../../event-bus.js';
export default {
    components:{
        'card':card,
        'subtareas-maniobra':subtareas,
    },
    props:{
        datos:{
            type: Object,
            required: true,            
        },
        maniobraId:{
            type:Number,
            reruired:true,
        },
        authId:{
            type:Number,
            reruired:true,
        }
    },
    data(){
        return{
            show:false, 
            
        }
    },
    
    computed:{
        statusIcon(){
            let estatus ='text-muted';
            if(this.datos.status == 'finalizado' ){
                estatus ='text-success';
            }
            else if(this.datos.status == 'en proceso'){
                estatus ='text-warning';
            }

            return 'fa-stack fa-2x ' + estatus;
        }
    },
    methods:{
        showInfo(){
           this.show = !this.show;     
        },
        tareaDuracion(inicio, final){
            if(!inicio || !final){
                return '...';
            }    
            let hora_inicio = moment(inicio);
            let hora_termino = moment(final);
            let diff = hora_termino.diff(inicio); 
            let duration = moment.duration(diff, 'milliseconds');
            if(duration.days()){
                return duration.days() + " : " + duration.hours() + ": " + duration.minutes() + ":" + duration.seconds() + '<small>Dias.</small>';
            }else if(duration.hours() == 0 && duration.minutes() == 0){
                return duration.hours() + ":" + duration.minutes() + " <small>Hrs.</small> " +  duration.seconds() + "<small>S.</small>";
            }
            else{
                return duration.hours() + ":" + duration.minutes() + " <small>Hrs.</small>";
            }
        }
    }
}
</script>
<style lang="scss">
.cardTaksShowInfo{
    .card-content{
        padding:0;
    }
    .collapseInfo:active{
        background:#eeeeee;
    }
}

</style>
