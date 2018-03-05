<template>
    <div>
        <form-wizard  
            title="PROCESO DE SUPERVICIÓN DE MANIOBRA" 
            subtitle=""
            color="#3498db"
            :start-index="activeIndex"
            @on-change="onChange"
            v-if="avance < 100"
            >
            <template slot="step" slot-scope="props">
                <wizard-step :tab="props.tab"
                :transition="props.transition"
                :key="props.tab.title"
                :index="props.index">
                </wizard-step>
            </template>
            
            <!-- Tareas -->
            <tab-content v-bind:title="tareaTituloCorto(0)" v-bind:icon="tareaIcono(0)">
                <h2 class="text-center text-uppercase">
                    {{ tareaTituloLargo(0) }}
                </h2><hr/>
                <sub-tareas :subTareas="subTareas(0)" v-bind:tarea-id="tareaID(0)" :maniobra-id="maniobraId" :tarea-tipo="tareaTipo(0)"></sub-tareas>
            </tab-content>
            <tab-content v-bind:title="tareaTituloCorto(1)" v-bind:icon="tareaIcono(1)">
                <h2 class="text-center text-uppercase">
                    {{ tareaTituloLargo(1) }}
                </h2><hr>
                <sub-tareas :subTareas="subTareas(1)" v-bind:tarea-id="tareaID(1)" :maniobra-id="maniobraId" :tarea-tipo="tareaTipo(1)"></sub-tareas>
            </tab-content>
            <tab-content v-bind:title="tareaTituloCorto(2)" v-bind:icon="tareaIcono(2)">
                <h2 class="text-center text-uppercase">
                    {{ tareaTituloLargo(2) }}
                </h2><hr>
                <sub-tareas :subTareas="subTareas(2)" v-bind:tarea-id="tareaID(2)" :maniobra-id="maniobraId" :tarea-tipo="tareaTipo(2)"></sub-tareas>
            </tab-content>
            
            <tab-content v-bind:title="tareaTituloCorto(3)" v-bind:icon="tareaIcono(3)">
                <h2 class="text-center text-uppercase">
                    {{ tareaTituloLargo(3) }}
                </h2><hr>
                <sub-tareas :subTareas="subTareas(3)"  v-bind:tarea-id="tareaID(3)" :maniobra-id="maniobraId" :tarea-tipo="tareaTipo(3)"></sub-tareas>
            </tab-content>
            <tab-content v-bind:title="tareaTituloCorto(4)" v-bind:icon="tareaIcono(4)">
                <h2 class="text-center text-uppercase">
                    {{ tareaTituloLargo(4) }}
                </h2><hr>
                <div class="row">
                    <div class="col-sm-12 text-center" v-if="tiempo_maniobra != 'NaN:NaN:NaN'">
                        <h3 v-text="tiempo_maniobra"></h3>
                        <p>Tiempo</p>
                    </div>
                </div>
                <sub-tareas :subTareas="subTareas(4)"  v-bind:tarea-id="tareaID(4)" :maniobra-id="maniobraId" :tarea-tipo="tareaTipo(4)"></sub-tareas>
            </tab-content>
            <tab-content v-bind:title="tareaTituloCorto(5)" v-bind:icon="tareaIcono(5)">
                <h2 class="text-center text-uppercase">
                    {{ tareaTituloLargo(5) }}
                </h2><hr>
                <sub-tareas :subTareas="subTareas(5)" v-bind:tarea-id="tareaID(5)" :maniobra-id="maniobraId" :tarea-tipo="tareaTipo(5)"></sub-tareas>
            </tab-content>
            <tab-content v-bind:title="tareaTituloCorto(6)" v-bind:icon="tareaIcono(6)">
                <h2 class="text-center text-uppercase">
                    {{ tareaTituloLargo(6) }}
                </h2><hr>
                <sub-tareas :subTareas="subTareas(6)" v-bind:tarea-id="tareaID(6)" :maniobra-id="maniobraId" :tarea-tipo="tareaTipo(6)"></sub-tareas>
            </tab-content>
            
            <template slot="footer" slot-scope="props">
                
                <div class="wizard-footer-left" v-if="btnPrev">
                    <wizard-button class="text-uppercase"  v-if="props.activeTabIndex > 0 && !props.isLastStep " @click.native="props.prevTab()" :style="props.fillButtonStyle">
                        Anterior
                    </wizard-button>
                </div>
                <div v-if="btnNext">
                    
                    <div class="wizard-footer-right" v-if="!props.isLastStep">
                        <wizard-button  @click.native="props.nextTab()" 
                        class="wizard-footer-right text-uppercase" 
                        :style="props.fillButtonStyle">
                            Siguiente
                        </wizard-button>
                    </div>

                    <div v-else>
                        <div v-show="alertaFinalizar == 0" class="alert alert-warning ">
                            <div class="row">
                                <div class="col-sm-1">
                                    <i class="material-icons md-medium white-text" >warning</i>
                                </div>
                                <div class="col-sm-7">
                                    <span data-notify="message"> 
                                        <b class="text-uppercase">Advertencia</b>.<br/>
                                        Asegurese de guardar las firmas antes de finalizar la maniobra.
                                    </span>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <button type="button" @click="alertaLeida" class="btn btn-danger btn-round" >
                                        Entendido
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div v-show="alertaFinalizar == 1" class="wizard-footer-right">
                            <wizard-button @click.native="onComplete" class="wizard-footer-right finish-button text-uppercase" :style="props.fillButtonStyle">
                                {{props.isLastStep ? 'Finalizar' : 'Next'}}
                            </wizard-button>
                        </div>
                    </div>
                </div>
            </template>
        </form-wizard>
        <div v-else>
            <h3>Resumen de la maniobra</h3>
            <detalles-tarea v-for="(tarea, index) in tareas" 
                :datos = "tarea"
                :maniobra-id = "maniobraId"
                :auth-id = "0"
                :key = "index" />
        </div>    
    </div>
</template>

<script>
import FormWizard from './../../ui/FormWizard.vue';
import WizardButton from './../../ui/WizardButton.vue';
import WizardStep from './../../ui/WizardStep.vue';
import TabContent from './../../ui/TabContent.vue';
import subTareas from './supervision/subTareas.vue';
import EventBus from './../../event-bus';

import detallesTarea from './../coordinacion/resume-maniobra/tarea-maniobra.vue';

var moment = require('moment');

export default {
    components: {
        'form-wizard':FormWizard,
        'wizard-step':WizardStep,
        'wizard-button':WizardButton,
        'tab-content':TabContent,
        'sub-tareas' : subTareas,
        'detalles-tarea':detallesTarea,
    },
    props:{
        tareas:{
            type:[Object, Array],
            required:true,
        },
        servicioId:{
            type: [Number, String],
            required: true, 
        },
        maniobraId:{
            type: [Number, String],
            required: true, 
        },
        activeIndex:{
            type:Number,
            default: 0,
        },
        avanceTotal:{
            type:Number,
            required:true
        },
    },
    data(){
        return {
            //tareas:[],
            btnNext:false,
            btnPrev:false,
            validation:false,
            avance:this.avanceTotal,
            tiempo_maniobra:'',
            inicio_maniobra:'',
            alertaFinalizar:0,
            currentIndex:this.activeIndex,
            token:'',
        }
    },
    
    mounted(){
        //console.log('parent');
        //console.log(this.$parent.$parent.$parent.tareas);
        //this.currentIndex = this.activeIndex;
        //this.avance = this.avance_total;
        this.token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        if(this.activeIndex == 0){
            this.procesoManiobra(0,this.tareas[0].id);
        }
        this.indiceActivo(this.activeIndex);
    },
    
    created(){
        let self = this;
        //this.avance = this.avanceTotal; 
        
        /** 
        * Estos eventos son emitidos desde los componentes 
        * [coordinacion/validation,maniobra/validation]
        */
        Echo.channel('maniobra-channel')
                .listen('ManiobraTareaValidacion', (data) => {
                    console.log(data);
                    if(data.validation.tarea_id == self.tareas[self.currentIndex].id ){
                        if(data.validation.value == 'onValidation')
                        {
                            this.btnPrev=false;
                            this.btnNext=false;
                        }
                        else if(data.validation.value == 'errorValidation')
                        {
                            this.validation = false;
                            this.btnNext = false;
                            this.btnPrev = true;
                        }
                        else if(data.validation.value == 'okValidation')
                        {
                            this.btnNext = true;
                            this.validation = true;
                            this.btnPrev = false;    
                        }
                        else{
                            window.location.reload(true);
                        }
                    }
                });   
    },
   
    methods:{
        onComplete(){
            let self = this;
            axios.post(`/procesoManiobraFin/${self.maniobraId}`,{
                _token: self.token 
            }).then(function (response) {
               window.location.reload(true);
            }).catch(function (error){
                alert("Ups. ocurrio un problema a la hora de ejecutar un proceso\nSi el error continua por favor llamar al administrador")
                console.log(error);  
                window.location.reload(true);
            });
        },
        onChange(prevIndex, nextIndex){
            this.currentIndex = nextIndex;
            this.steps(nextIndex, prevIndex);
        },
        // avanceUpdate(index, avance){
        //     let self = this;
        //     return  axios.post(`/maniobra/avance/update/${self.maniobraId}/${avance}/${index}`,{
        //                 _token: self.token 
        //             });
        // },
        // tareaInicio(tarea){
        //     let self = this;
        //     return axios.post('/maniobra/tarea/inicio/'+tarea,{
        //                 _token: self.token 
        //             });
        // },
        // tareaFin(tarea){
        //     let self = this;
        //     return axios.post('/maniobra/tarea/fin/'+tarea,{
        //                 _token: self.token 
        //             });
        // },
        // activarOperarios(){
        //     let self = this;
        //     return  axios.post(`/maniobras/produccion/inicar/${self.maniobraId}`,{
        //                 _token: self.token 
        //             });
        // },
        // operariosLibres(){
        //     let self = this;
        //     return axios.get('/maniobras/fuerzaTarea/free/'+this.maniobraId,{
        //                 _token: self.token 
        //             });
        // },
        indiceActivo(indice){
            let self = this;
            let nextIndex = indice;
            let prevIndex = indice - 1;
            this.steps(nextIndex, prevIndex);
            if(indice === 2) // Tarea 3: 
            { 
                axios.get('/API/supervision/getSubTareas/'+this.tareas[2].id)
                    .then(function (response) {
                            if( response.data[0].value == "onValidation" ){
                                self.btnPrev = false;
                                self.btnNext = false;
                            }else if(response.data[0].value == "okValidation"){
                                self.btnPrev = false;
                                self.btnNext = true;
                            }else if(response.data[0].value == "errorValidation"){
                                self.btnPrev = true;
                                self.btnNext = false;
                            }
                            else {
                                self.btnPrev = true;
                                self.btnNext = false;
                            }
                    });   
            }
            else if( indice === 4 ){
                this.tiempoManiobra(this.tareas[4].id);
            }
            else if( indice === 5 ) // Tarea 6: 
            {
                axios.get('/API/supervision/getSubTareas/'+this.tareas[5].id)
                    .then(function (response) {
                        if( response.data[0].value == "onValidation" ){
                            self.btnPrev = false;
                            self.btnNext = false;
                        }else if(response.data[0].value == "okValidation"){
                            self.btnPrev = false;
                            self.btnNext = true;
                        }else if(response.data[0].value == "errorValidation"){
                            self.btnPrev = true;
                            self.btnNext = false;
                        }
                        else {
                            self.btnPrev = true;
                            self.btnNext = false;
                        }
                });   
                       
            }
        
        },
        tiempoManiobra(tarea){
             return axios.get('/maniobra/tarea/'+tarea);
        },
        // terminoManiobra(){
        //     let self = this;
        //     //Aqui se cambia elestatus de la maniobra tambien se libera al supervisor
        //     axios.post('/coordinacion/maniobra/fin/'+this.maniobraId)
        //     .then(function (response) {
        //         self.avance = response.data.avance_total;
        //         self.tareaFin(this.tareas[6].id);
        //         window.location.reload(true);
        //     });
        // },
        procesoManiobra(index,tareaId){
            let self = this;
            axios.post(`/proceso-maniobra/${this.maniobraId}/${tareaId}/${index}`,{
                        _token: self.token 
                    })
                .then(function (response){
                    if(response.status !== 200 ){
                        window.location.reload(true);
                    }
                }).catch(function (error){
                    console.log(error);  
                    window.location.reload(true);
                });
        },
        procesoManiobraCompact(index,tareaId){
            let self = this;
            return axios.post(`/proceso-maniobra/${this.maniobraId}/${tareaId}/${index}`,{
                        _token: self.token 
                    });
        },    
        steps(nextIndex, prevIndex){
            let self = this;
            switch (nextIndex) {
                case 0: // Tarea 1: Revision
                            //this.procesoManiobra(0,this.tareas[0].id);
                            this.btnNext = true;    
                    break;
                case 1: // Tarea 2: Anexos fotograficos
                            this.procesoManiobra(1,this.tareas[1].id);
                            this.btnNext = true;    
                            this.btnPrev = true;    
                    break;
                case 2: // Tarea 3: 
                            this.procesoManiobra(2,this.tareas[2].id);
                            if(this.validation){
                                this.btnPrev = false;
                            }
                            this.btnNext = false;
                    break;
                case 3: // Tarea 4: Fuerza de tarea 
                            this.procesoManiobra(3,this.tareas[3].id);
                            this.btnPrev = false; 
                            this.btnNext = true;   
                    break;
                case 4: // Tarea 5: Proceso de maniobra
                            axios.all([
                                    this.procesoManiobraCompact( 4, this.tareas[4].id ),
                                    this.tiempoManiobra( this.tareas[4].id )
                                ]).then(axios.spread(function (proceso, tiempo){
                                    //tiempo maniobra
                                    let eventTime = moment(tiempo.data.inicio);
                                    let currentTime = moment();
                                    let diffTime = currentTime.diff(eventTime);
                                    let duration = moment.duration(diffTime, 'milliseconds');
                                    let interval = 1000;
                                    setInterval(function(){
                                        duration = moment.duration(duration + interval, 'milliseconds');
                                        if(duration.days()){
                                            self.tiempo_maniobra = duration.days() + ":" + duration.hours() + ":" + duration.minutes() + ":" + duration.seconds();
                                        }else{
                                            self.tiempo_maniobra = duration.hours() + ":" + duration.minutes() + ":" + duration.seconds();
                                        }
                                    }, interval);
                                })).catch(function (error){
                                    console.log(error);  
                                    window.location.reload(true);
                                });
                            
                            this.btnPrev = true; 
                            this.btnNext = true; 
                    break;
                case 5: // Tarea 6: 
                            this.procesoManiobra(5,this.tareas[5].id);
                            
                            this.btnNext=false;
                    break;
                case 6: // Tarea 7: Finalización
                            this.procesoManiobra(6,this.tareas[6].id);
                            this.btnPrev=false;
                            this.btnNext=true;
                    break;
            }
        },
        alertaLeida(){
            this.alertaFinalizar=1;
        },
        //ATRIBUTOS TABS
        tareaTituloCorto(i){
            return this.tareas[i].titulo_corto;
        },
        tareaTituloLargo(i){
            return this.tareas[i].titulo_largo;
        },
        tareaIcono(i){
            return this.tareas[i].icono;
        },
        tareaID(i){
            return this.tareas[i].id;
        },
        tareaTipo(i){
            return this.tareas[i].tipo;
        },
        subTareas(i){
            return this.tareas[i].sub_tareas;
        },
    }
}
</script>
