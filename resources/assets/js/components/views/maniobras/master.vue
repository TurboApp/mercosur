<template>
    <div>
        <card :class="datos.servicio.tipo" style="padding-bottom:0;">
            <template>
                <div class="row">
                    <div class="col-md-8">
                            <h6>Numero de servicio <span v-text="datos.servicio.numero_servicio"></span></h6>
                            <h1 class="title white-text" v-text="datos.servicio.tipo"></h1>
                    </div>
                    <div class="col-md-4">
                        <div class="row" v-if="datos.inicio_maniobra">
                            <div class="col-xs-12">
                                <h6 style="margin:0;">
                                    <i class="fa fa-hourglass-start" aria-hidden="true"></i>
                                    <span v-text="datos.inicio_maniobra"></span> 
                                </h6>
                            </div>
                            <div class="col-xs-12 text-center" v-if="!datos.termino_maniobra">
                                <h1 style="margin:0;" v-text="generalTimer"></h1>
                                <small class="">Tiempo transcurrido</small>
                            </div>
                            <div class="col-xs-12" v-else>
                                <h6 style="margin:0;">
                                    <i class="fa fa-hourglass-end" aria-hidden="true"></i>
                                    <span v-text="datos.termino_maniobra"></span> 
                                </h6>
                                <div class="text-center">
                                    <h1 style="margin:0;" v-text="generalTimer"></h1>
                                    <small class=""><i class="fa fa-clock-o" aria-hidden="true"></i> Duración</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress progress-line-success" data-toggle="tooltip" data-placement="top" :title="avanceTotal+'%'" style="margin-bottom:0;margin-top:15px;">
                    <div class="progress-bar progress-bar-success" role="progressbar" :aria-valuenow="avanceTotal" aria-valuemin="0" aria-valuemax="100" :style="'width: '+ avanceTotal + '%;'">
                        <span class="sr-only" v-text="avanceTotal+'% Complete'"></span>
                    </div>
                </div>
                <div v-if="avanceTotal > 0" class="text-center white-text"><small v-text="avanceTotal + '%'"></small></div>
            </template>
        </card>

        <tabs >
             <tab name="Supervisión" >
                <proceso-supervision :maniobra-id="datos.servicio_id" :active-index="datos.indice_activo" :avance-total="datos.avance_total" :maniobra-tipo = "datos.servicio.tipo"></proceso-supervision>
            </tab>
            <tab name="Datos generales">
                <coordinacion-datosgenerales :datosGenerales="datosGenerales()"></coordinacion-datosgenerales>
            </tab>
            <tab name="Transportes">
                <coordinacion-transportes :transportes="datos.servicio.transportes"></coordinacion-transportes>
            </tab>
            <tab name="Documentos">
                <coordinacion-documentos :documentos="datos.servicio.documentos"></coordinacion-documentos>
            </tab>
            <tab name="Archivos">
                <coordinacion-archivos :archivos="datos.servicio.archivos"></coordinacion-archivos>
            </tab>
        </tabs> 
       
    </div>
</template>
<script>
import EventBus from './../../event-bus.js';
import card from '../../cards/Card.vue';
import tabs from '../../ui/nav/tabs.vue';
import tab from '../../ui/nav/tab.vue';
import supervision from './proceso-supervision.vue';
import coordinacionDatosGenerales from './../servicios/show-datos-generales.vue';
import coordinacionTransportes from './../servicios/show-transportes.vue';
import coordinacionDocumentos from './../servicios/show-documentos.vue';
import coordinacionArchivos from './../servicios/show-archivos.vue';

var moment = require('moment');
//import moment from'vue-momnt';

export default {
    components: {
        'card':card,
        'tabs':tabs,
        'tab':tab,
        'proceso-supervision':supervision,
        'coordinacion-datosgenerales': coordinacionDatosGenerales,
        'coordinacion-documentos': coordinacionDocumentos,
        'coordinacion-archivos': coordinacionArchivos,
        'coordinacion-transportes': coordinacionTransportes,
    },
    props:{
        datos:{
            type:[Object, Array],
            required:true,
        },
        
    },
    data(){
        return {
            generalTimer:'',
            token:'',
            avanceTotal:0,
            intervalTimer:'',
        }
    },
    created(){
        let self = this;
        EventBus.$on('avaceTotalManiobra', (avance)=>{
            this.$set(this.datos, 'avance_total', parseInt(avance));
            this.avanceTotal = parseInt(avance);
        });
        EventBus.$on('termino-maniobra', (data) => {
            this.$set(this.datos, 'termino_maniobra', moment(data.termino_maniobra).format('D/MM/YY, HH:mm:ss'));
            this.$set(this.datos, 'inicio_maniobra', moment(data.inicio_maniobra).format('D/MM/YY, HH:mm:ss'));
            let hora_inicio = moment(data.inicio_maniobra);
            let hora_termino = moment(data.termino_maniobra);
            let diff = hora_termino.diff(hora_inicio); 
            let duration = moment.duration(diff, 'milliseconds');
            if(duration.days()){
                this.generalTimer = duration.days() + ":" + duration.hours() + ":" + duration.minutes() + ":" + duration.seconds();
            }else{
                this.generalTimer = duration.hours() + ":" + duration.minutes() + ":" + duration.seconds();
            }
            clearInterval(this.intervalTimer);
        });

    },
    mounted(){
        let self = this;
        let token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        axios.post('/coordinacion/maniobra/inicio/'+this.datos.servicio_id,{
            _token: token 
        }).then(function (response) {
                let inicio_maniobra = response.data.inicio_maniobra;
                self.datos.inicio_maniobra = moment(self.datos.inicio_maniobra).format('D/MM/YY, HH:mm:ss');
                if(!self.datos.termino_maniobra){
                    let eventTime = moment(inicio_maniobra);
                    let currentTime = moment();
                    let diffTime = currentTime.diff(eventTime);
                    let duration = moment.duration(diffTime, 'milliseconds');
                    let interval = 1000;
                    self.intervalTimer = setInterval(function(){
                        duration = moment.duration(duration + interval, 'milliseconds');
                        if(duration.days()){
                            self.generalTimer = duration.days() + ":" + duration.hours() + ":" + duration.minutes() + ":" + duration.seconds();
                        }else{
                            self.generalTimer = duration.hours() + ":" + duration.minutes() + ":" + duration.seconds();
                        }
                    }, interval);
                }else{
                    let hora_inicio = moment(inicio_maniobra);
                    let hora_termino = moment(self.datos.termino_maniobra);
                    let diff = hora_termino.diff(hora_inicio); 
                    let duration = moment.duration(diff, 'milliseconds');
                    if(duration.days()){
                        self.generalTimer = duration.days() + ":" + duration.hours() + ":" + duration.minutes() + ":" + duration.seconds();
                    }else{
                        self.generalTimer = duration.hours() + ":" + duration.minutes() + ":" + duration.seconds();
                    }
                    self.datos.termino_maniobra = moment(self.datos.termino_maniobra).format('D/MM/YY, HH:mm:ss');
                }
        });
        this.avanceTotal = this.datos.avance_total;
    },
    methods:{
        datosGenerales(){
            return {
               datos : {
                    fecha : moment(this.datos.servicio.fecha_recepcion).format('DD/MM/YYYY') + ' - ' + this.datos.servicio.hora_recepcion,
                    cliente: this.datos.servicio.cliente.nombre_corto + ' - ' + this.datos.servicio.cliente.nombre,
                    agente: this.datos.servicio.agente.nombre_corto + ' - ' + this.datos.servicio.agente.nombre,
                    destino: this.datos.servicio.destino,
                    observaciones: this.datos.servicio.observaciones
               } 
            }
        },
    }
}
</script>

    