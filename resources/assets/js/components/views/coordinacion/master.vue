<template>
<div>
    <div v-if="isLoad > 9">
        <card :class="datos.servicio.tipo" style="padding-bottom:0;">
        <template>
                <div class="row">
                    <div class="col-md-8">
                        <h6>Numero de servicio <span v-text="datos.servicio.numero_servicio"></span></h6>
                        <h1 class="title white-text" v-text="datos.servicio.tipo"></h1>
                        <h6 v-html="showEstatus()"></h6>
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
                <div class="progress progress-line-success" data-toggle="tooltip" data-placement="top" :title="datos.avance_total+'%'" style="margin-bottom:0;margin-top:15px;">
                    <div class="progress-bar progress-bar-success" role="progressbar" :aria-valuenow="datos.avance_total" aria-valuemin="0" aria-valuemax="100" :style="'width: '+datos.avance_total+'%;'">
                        <span class="sr-only" v-text="datos.avance_total+'% Complete'"></span>
                    </div>
                </div>
                <div v-if="datos.avance_total > 0" class="text-center white-text"><small v-text="datos.avance_total+'%'"></small></div>
        </template>
        </card>


        <tabs >
            <tab name="Detalles" :active="true">
                <coordinacion-detalles :datos="datos"></coordinacion-detalles>
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
    <div v-else>
        <p class="text-center">
            <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
            <span class="sr-only">Loading...</span>
            <div class="text-center">Cargando...</div>
        </p>

    </div>
</div>
</template>
<script>
import EventBus from '../../event-bus.js';

import card from '../../cards/Card.vue';
import tabs from '../../ui/nav/tabs.vue';
import tab from '../../ui/nav/tab.vue';

import coordinacionDetalles from './detalles.vue';
import coordinacionDatosGenerales from './../servicios/show-datos-generales.vue';
import coordinacionTransportes from './../servicios/show-transportes.vue';
import coordinacionDocumentos from './../servicios/show-documentos.vue';
import coordinacionArchivos from './../servicios/show-archivos.vue';

var moment = require('moment');

export default {
    components:{
        'card':card,
        'tabs':tabs,
        'tab':tab,
        'coordinacion-detalles': coordinacionDetalles,
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
        return{
            generalTimer:'',
        }
    },
    mounted(){
       this.maniobra();
    },
    created(){
        EventBus.$on('actialuzarDatos', (data)=>{
            this.datos.coordinador_id=data.coordinador_id; 
            this.datos.supervisor_id=data.supervisor_id; 
            this.datos.status=data.status;
        });
    },
    computed:{
        avancePorcentage(){
            return this.datos.avanace_total + '%';
        },
        isLoad(){
            let i=0;
            for(var key in this.datos){
                i++;

            }
            return i;
        }
    },
    methods:{
        maniobra(){
            let self = this;
            if(this.datos.inicio_maniobra){
            let inicio_maniobra = this.datos.inicio_maniobra;
            this.datos.inicio_maniobra = moment(this.datos.inicio_maniobra).format('D/MM/YY, HH:mm:ss');
            if(!this.datos.termino_maniobra)
            {
                let eventTime = moment(inicio_maniobra);
                let currentTime = moment();
                let diffTime = currentTime.diff(eventTime);
                let duration = moment.duration(diffTime, 'milliseconds');
                let interval = 1000;
                setInterval(function(){
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

        }
            

        },
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
        
        showEstatus(){
            let estatus=this.datos.status;
            let clase = this.datos.status.replace(" ", "-").toLowerCase();
            switch (estatus) {
                case "PARA ASIGNAR": case "Para Asignar": case "para asignar":
                    return '<span style="padding:5px;" class=" '+ clase +'"><i class="fa fa-clock-o" aria-hidden="true"></i> '+estatus+'</span>'    
                
                case "ASIGNADO": case "Asignado": case "asignado":
                    return '<span style="padding:5px;" class="'+ clase +'"><i class="fa fa-user-o" aria-hidden="true"></i> '+estatus+'</span>'    

                case "EN PROCESO": case "En proceso": case "en proceso":
                    return '<span style="padding:5px;" class="'+ clase +'"><i class="fa fa-play" aria-hidden="true"></i> '+estatus+'</span>'    
                    
                case "EN PAUSA": case "En pausa": case "en pasua":
                    return '<span style="padding:5px;" class="'+ clase +'"><i class="fa fa-pause" aria-hidden="true"></i> '+estatus+'</span>'    
                    
                case "FINALIZADO": case "Finalizado": case "finalizado":
                    return '<span style="padding:5px;" class="'+ clase +'"><i class="fa fa-check" aria-hidden="true"></i> '+estatus+'</span>'    
                    
                case "CANCELADO": case "Cancelado": case "cancelado":
                    return '<span style="padding:5px;" class="'+ clase +'"><i class="fa fa-ban" aria-hidden="true"></i> '+ estatus +'</span>'    
                    
            }

        }
    }
}
</script>

