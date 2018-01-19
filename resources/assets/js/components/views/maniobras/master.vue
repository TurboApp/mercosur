<template>
    <div>
        <card :class="datosM.servicio.tipo" style="padding-bottom:0;">
            <template>
                <div class="row">
                    <div class="col-md-8">
                        <h6>Numero de servicio <span v-text="datos.servicio.numero_servicio"></span></h6>
                        <h1 class="title white-text" v-text="datos.servicio.tipo"></h1>
                    </div>
                    <div class="col-md-4">
                        <div class="row" v-if="datosM.inicio_maniobra">
                            <div class="col-xs-12">
                                <h6 style="margin:0;">
                                    Inicio.
                                    <span v-text="datosM.inicio_maniobra"></span> 
                                </h6>
                            </div>
                            <div class="col-xs-12 text-center" v-if="!datosM.termino_maniobra">
                                <h1 style="margin:0;" v-text="generalTimer"></h1>
                                <small class="">Tiempo transcurrido</small>
                            </div>
                            <div class="col-xs-12" v-else>
                                <h6 style="margin:0;">
                                    Fin.
                                    <span v-text="datosM.termino_maniobra"></span> 
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
                <proceso-supervision 
                    :maniobra-id="datos.servicio_id" 
                    :active-index="datos.indice_activo" 
                    :avance-total="avanceTotal" 
                    :maniobra-tipo = "datos.servicio.tipo"
                   >
                </proceso-supervision>
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
            intervalTimer:'',
            datosM:{},
            avanceTotal:0,
        }
    },
    created(){
        let self = this;
        this.datosM = this.datos;
        this.EventBus();
    },
    mounted(){
        this.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        this.avanceTotal = this.datos.avance_total;
        this.inicioManiobra();
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
        inicioManiobra(){
            let self = this;
            axios.post('/coordinacion/maniobra/inicio/'+this.datos.servicio_id,{
                _token: self.token 
            }).then(function (response) {
                let inicio_maniobra = response.data.inicio_maniobra;
                if(typeof response.data.inicio_maniobra == 'object' ){
                    inicio_maniobra = response.data.inicio_maniobra.date;
                }
                self.datosM.inicio_maniobra = moment(inicio_maniobra).format('D/MM/YY, HH:mm:ss');
                if(!self.datosM.termino_maniobra){
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
                    let hora_termino = moment(self.datosM.termino_maniobra);
                    let diff = hora_termino.diff(inicio_maniobra); 
                    let duration = moment.duration(diff, 'milliseconds');
                    if(duration.days()){
                        self.generalTimer = duration.days() + ":" + duration.hours() + ":" + duration.minutes() + ":" + duration.seconds();
                    }else{
                        self.generalTimer = duration.hours() + ":" + duration.minutes() + ":" + duration.seconds();
                    }
                    self.datosM.termino_maniobra = moment(self.datosM.termino_maniobra).format('D/MM/YY, HH:mm:ss');
                }
            });
        },
        EventBus(){
            let self = this;
            Echo.channel('maniobra-channel')
                .listen('ManiobraUpdate', (data) => {
                    if(self.datos.id == data.maniobra.id)
                    {
                        self.avanceTotal = parseInt(data.maniobra.avance_total);
                    }
                });   
            EventBus.$on('termino-maniobra', (data) => {
                    console.log(data);
                    if(self.datos.id == data.id)
                    {
                        self.$set(self.datosM, 'termino_maniobra', moment(data.termino_maniobra.date).format('D/MM/YY, HH:mm:ss'));
                        clearInterval(self.intervalTimer);
                    }
            });
        },
        
    }
}
</script>

    