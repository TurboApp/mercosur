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
            <!-- <tab-content  v-for="(tarea, index) in tareas" 
                :title="tarea.titulo_corto" 
                :icon="tarea.icono"  
                :key="index" 
                >
                <h2 v-text="tarea.titulo_largo" class="text-center text-uppercase"></h2>
                <hr>
                <sub-tareas  :tarea-id="tarea.id" :maniobra-id="maniobraId" :maniobra-tipo="maniobraTipo"></sub-tareas>
            </tab-content> -->
            <!-- Tareas -->
            <tab-content :title="tareas[0].titulo_corto" :icon="tareas[0].icono">
                <h2 v-text="tareas[0].titulo_largo" class="text-center text-uppercase"></h2><hr>
                <sub-tareas  :tarea-id="tareas[0].id" :maniobra-id="maniobraId" :maniobra-tipo="maniobraTipo"></sub-tareas>
            </tab-content>
            <tab-content :title="tareas[1].titulo_corto" :icon="tareas[1].icono">
                <h2 v-text="tareas[1].titulo_largo" class="text-center text-uppercase"></h2><hr>
                <sub-tareas  :tarea-id="tareas[1].id" :maniobra-id="maniobraId" :maniobra-tipo="maniobraTipo"></sub-tareas>
            </tab-content>
            <tab-content :title="tareas[2].titulo_corto" :icon="tareas[2].icono">
                <h2 v-text="tareas[2].titulo_largo" class="text-center text-uppercase"></h2><hr>
                <sub-tareas  :tarea-id="tareas[2].id" :maniobra-id="maniobraId" :maniobra-tipo="maniobraTipo"></sub-tareas>
            </tab-content>
            <tab-content :title="tareas[3].titulo_corto" :icon="tareas[3].icono">
                <h2 v-text="tareas[3].titulo_largo" class="text-center text-uppercase"></h2><hr>
                <sub-tareas  :tarea-id="tareas[3].id" :maniobra-id="maniobraId" :maniobra-tipo="maniobraTipo"></sub-tareas>
            </tab-content>
            <tab-content :title="tareas[4].titulo_corto" :icon="tareas[4].icono">
                <h2 v-text="tareas[4].titulo_largo" class="text-center text-uppercase"></h2><hr>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h3 v-text="tiempo_maniobra"></h3>
                        <p>Tiempo</p>
                    </div>
                </div>
                <sub-tareas  :tarea-id="tareas[4].id" :maniobra-id="maniobraId" :maniobra-tipo="maniobraTipo"></sub-tareas>
            </tab-content>
            <tab-content :title="tareas[5].titulo_corto" :icon="tareas[5].icono">
                <h2 v-text="tareas[5].titulo_largo" class="text-center text-uppercase"></h2><hr>
                <sub-tareas  :tarea-id="tareas[5].id" :maniobra-id="maniobraId" :maniobra-tipo="maniobraTipo"></sub-tareas>
            </tab-content>
            <tab-content :title="tareas[6].titulo_corto" :icon="tareas[6].icono">
                <h2 v-text="tareas[6].titulo_largo" class="text-center text-uppercase"></h2><hr>
                <sub-tareas  :tarea-id="tareas[6].id" :maniobra-id="maniobraId" :maniobra-tipo="maniobraTipo"></sub-tareas>
            </tab-content>

            <template slot="footer" slot-scope="props">
                <div class="wizard-footer-left" v-if="btnPrev">
                    <wizard-button class="text-uppercase"  v-if=" props.activeTabIndex > 0 && !props.isLastStep " @click.native="props.prevTab()" :style="props.fillButtonStyle">
                        Anterior
                    </wizard-button>
                </div>
                <div class="wizard-footer-right" v-if="btnNext">
                    <wizard-button v-if="!props.isLastStep" @click.native="props.nextTab()" 
                    class="wizard-footer-right text-uppercase" 
                    :style="props.fillButtonStyle">
                        Siguiente
                    </wizard-button>

                    <wizard-button v-else @click.native="onComplete" class="wizard-footer-right finish-button text-uppercase" :style="props.fillButtonStyle">
                        {{props.isLastStep ? 'Finalizar' : 'Next'}}
                    </wizard-button>
                </div>
            </template>
        </form-wizard>
        <div v-else>
            El servicio ha sido completado
        </div>    
    </div>
</template>
<script>
import FormWizard from './components/FormWizard.vue';
import WizardButton from './components/WizardButton.vue';
import WizardStep from './components/WizardStep.vue';
import TabContent from './components/TabContent.vue';
import subTareas from './subTareas.vue';
import EventBus from './../../event-bus.js';

var moment = require('moment');

export default {
    components: {
        'form-wizard':FormWizard,
        'wizard-step':WizardStep,
        'wizard-button':WizardButton,
        'tab-content':TabContent,
        'sub-tareas' : subTareas,
    },
    props:{
        maniobraId:{
            type: [Number, String],
            required: true, 
        },
        maniobraTipo:{
            type: String,
            required: true, 
        },
        activeIndex:{
            type:Number,
            default: 0,
        },
        avanceTotal:{
            type:Number,
            required:true
        }
    },
    data(){
        return {
            tareas:[],
            btnNext:false,
            btnPrev:false,
            validation:false,
            avance:0,
            tiempo_maniobra:'',
            inicio_maniobra:'',
        }
    },
    
    mounted(){
        let self = this;
        axios.get('/API/supervision/getTareas/'+this.maniobraId)
            .then(function (response) {
                self.tareas = response.data;
                self.tareaInicio(self.tareas[0].id);
                self.indiceActivo(self.activeIndex);
        });
        this.avance = this.avanceTotal; 
    },
    created(){
        EventBus.$on('onValidation', ()=>{
            this.btnPrev=false;
        });
        EventBus.$on('okValidation', ()=>{
            this.validation=true;
            this.btnNext=true;
        });
        EventBus.$on('errorValidation', ()=>{
            this.validation=false;
            this.btnNext=false;
            this.btnPrev=true;
        });
        $(window).on("load",function() {
            $(".loader").fadeOut("slow");
        })
    },
    /*
        NOTAS:....
        * AL hacer cambio de tabs se debe alctualizar los siguientes campos en la tabla -coordinations- [avance_total, indice_activo].
        * Se tieque hacer eventos con EvenBus para actualizar el objeto datos de master.vue para mostrar el avance en tiempo real
        * Se deben actualizar el tiempo de las tareas el inicio y el final (sobretodo la tarea de "proceso de maniobra")
        - Checar cuando se termina la session cuando se hace una peticion desde axios a la base de datos
        - Checar la fuerza de trabajo (Produccion de operarios)
        - Se debe mandar a imprimir en PDF Guardar el archivo en los archivos y mandarlo a imprimir
        * validate status si esta validando que se desabilite
        *se debe de realizar una funcion que habilite/deshabilite los botones btnNext y bntPrev segun donde se activo el indice
    */
    methods:{
        onComplete(){
            this.avanceUpdate(0,100);
            this.tareaFin(this.tareas[6].id);
            this.terminoManiobra();
            alert('completado');
        },
        onChange(prevIndex, nextIndex){
            switch (nextIndex) {
                case 0: // Tarea 1: Revision
                            this.btnNext = true;    
                            this.btnPrev = true;    
                    break;
                case 1: // Tarea 2: Anexos fotograficos
                            if( prevIndex === 0 ){
                                this.avanceUpdate( 1 , 5 );
                                this.tareaFin(this.tareas[0].id);
                                this.tareaInicio(this.tareas[1].id);
                            }
                            this.btnNext = true;    
                            this.btnPrev = true;    
                    break;
                case 2: // Tarea 3: Validacion
                            if( prevIndex === 1 ){
                                this.avanceUpdate( 2 , 10 );
                                this.tareaFin(this.tareas[1].id);
                                this.tareaInicio(this.tareas[2].id);
                            }    
                            if(this.validation){
                                this.btnPrev = false;
                            }
                            this.btnNext = false;
                    break;
                case 3: // Tarea 4: Fuerza de tarea 
                            if( prevIndex === 2 ){
                                this.avanceUpdate( 3 , 15 );
                                this.tareaFin(this.tareas[2].id);
                                this.tareaInicio(this.tareas[3].id);
                            }
                            this.btnPrev = false; 
                            this.btnNext = true;   
                    break;
                case 4: // Tarea 5: Proceso de maniobra
                            if( prevIndex === 3 ){
                                this.avanceUpdate(4 , 20);
                                this.tareaFin(this.tareas[3].id);
                                this.tareaInicio(this.tareas[4].id);
                                this.tiempoManiobra(this.tareas[4].id);
                                EventBus.$emit('iniciarProduccionOperarios');
                            }
                            this.btnPrev = true; 
                            this.btnNext = true; 
                    break;
                case 5: // Tarea 6: Validacion
                            if( prevIndex === 4 ){
                                this.avanceUpdate(5,90);
                                this.tareaInicio(this.tareas[5].id);
                            }
                            this.btnNext=false;
                    break;
                case 6: // Tarea 7: Finalización
                            if(prevIndex === 5 ){
                                this.avanceUpdate(6,95);
                                this.tareaFin(this.tareas[4].id);
                                this.tareaFin(this.tareas[5].id);
                                this.tareaInicio(this.tareas[6].id);
                            }
                            this.btnPrev=false;
                    break;
            }
        },
        avanceUpdate(index, avance){
            let self = this;
            axios.post('/maniobra/avance/update/'+this.maniobraId+'/'+avance+'/'+index)
                .then(function (response) {
                    EventBus.$emit('avaceTotalManiobra', response.data.avance_total);
                    self.avance = response.data.avance_total;
            });
        },
        tareaInicio(tarea){
            let self = this;
            axios.post('/maniobra/tarea/inicio/'+tarea)
                .then(function (response) {
                    return response.data.inicio;
            });
        },
        tareaFin(tarea){
            let self = this;
            axios.post('/maniobra/tarea/fin/'+tarea)
                .then(function (response) {
                    return response.data.final;
            });
        },
        indiceActivo(indice){
            switch (indice) {
                case 0: // Tarea 1: Revision
                        this.btnNext = true;    
                        this.btnPrev = true;    
                    break;
                case 1: // Tarea 2: Anexos fotograficos
                        this.btnNext = true;    
                        this.btnPrev = true;    
                    break;
                case 2: // Tarea 3: Validacion
                        axios.get('/API/supervision/getSubTareas/'+this.tareas[2].id)
                            .then(function (response) {
                                if( response.data === "onValidation" ){
                                    this.btnPrev = false;
                                    this.btnNext = false;
                                }else if(response.data === "okValidation"){
                                    this.btnPrev = false;
                                    this.btnNext = true;
                                }else if(response.data === "errorValidation"){
                                    this.btnPrev = true;
                                    this.btnNext = false;
                                }
                        });   
                    break;
                case 3: // Tarea 4: Fuerza de tarea 
                        this.btnPrev = false; 
                        this.btnNext = true;   
                    break;
                case 4: // Tarea 5: Proceso de maniobra
                        this.btnPrev = true; 
                        this.btnNext = true; 
                    break;
                case 5: // Tarea 6: Validacion
                        this.btnNext=false;
                    break;
                case 6: // Tarea 7: Finalización
                        this.btnPrev=false;
                    break;
            }
        },
        tiempoManiobra(tarea){
            let self = this; 
             axios.get('/maniobra/tarea/'+tarea)
                .then(function (response) {
                    let eventTime = moment(response.data.inicio);
                    let currentTime = moment();
                    let diffTime = currentTime.diff(eventTime);
                    let duration = moment.duration(diffTime, 'milliseconds');
                    let interval = 1000;
                    setInterval(function(){
                        duration = moment.duration(duration + interval, 'milliseconds');
                        if(duration.days()){
                            self.tiempo_maniobra = duration.days() + ":" + duration.hours() + ":" + duration.minutes() + ":" + duration.seconds();
                            return self.tiempo_maniobra;
                        }else{
                            self.tiempo_maniobra = duration.hours() + ":" + duration.minutes() + ":" + duration.seconds();
                            return self.tiempo_maniobra;
                        }
                    }, interval);
            });
        },
        terminoManiobra(){
            //Aqui se cambia elestatus de la maniobra tambien se libera al supervisor
            axios.post('/coordinacion/maniobra/fin/'+this.maniobraId)
            .then(function (response) {
                EventBus.$emit('termino-maniobra', response.data);
            });
        }
    }
}
</script>

    