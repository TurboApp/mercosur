<template>
    <div>
        <form-wizard  
            title="PROCESO DE SUPERVICIÓN DE MANIOBRA" 
            subtitle=""
            color="#3498db"
            :start-index="activeIndex"
            @on-change="onChange"
            >
            <template slot="step" scope="props">
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

            <template slot="footer" scope="props">
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
        }
    },
    data(){
        return {
            tareas:[{
                titulo_corto:'',
            },
            {
                titulo_corto:'',
            }
            ],
            btnNext:true,
            btnPrev:true,
            validation:false,
        }
    },

    
    mounted(){
        let self = this;
        axios.get('/API/supervision/getTareas/'+this.maniobraId)
            .then(function (response) {
                self.tareas = response.data;
        });

        this.indiceActivo(this.activeIndex);
       
    },
    created(){
        EventBus.$on('onValidation', ()=>{
            console.log("evento onValidation");
            this.btnPrev=false;
        });
        EventBus.$on('okValidation', ()=>{
            console.log('Evento okValidation');
            this.validation=true;
            this.btnNext=true;
            
        });
        EventBus.$on('errorValidation', ()=>{
            console.log('Evento errorValidation');
            this.validation=false;
            this.btnNext=false;
            this.btnPrev=true;
            
        });
    },
    /*
        NOTAS:....
        - AL hacer cambio de tabs se debe alctualizar los siguientes campos en la tabla -coordinations- [avance_total, indice_activo].
        - Se tieque hacer eventos con EvenBus para actualizar el objeto datos de master.vue para mostrar el avance en tiempo real
        - Se deben actualizar el tiempo de las tareas el inicio y el final (sobretodo la tarea de "proceso de maniobra")
        *se debe de realizar una funcion que habilite/deshabilite los botones btnNext y bntPrev segun donde se activo el indice
    */
    methods:{
        onComplete(){
            alert('completado');
        },
        onChange(prevIndex, nextIndex){
            switch (nextIndex) {
                case 0: // Tarea 1: Revision
                            
                            this.btnNext = true;    
                            this.btnPrev = true;    
                        
                    break;
                case 1: // Tarea 2: Anexos fotograficos
                            
                            this.btnNext = true;    
                            this.btnPrev = true;    
                        
                    break;
                case 2: // Tarea 3: Validacion
                        if(this.validation){
                            this.btnPrev = false;
                        }
                        this.btnNext = false;
                    break;
                case 3: // Tarea 4: Fuerza de tarea 
                        
                        this.btnPrev = false; 
                        this.btnNext = true;   
                        
                    break;
                case 4: // Tarea 5: Proceso de maniobra
                        this.btnPrev = true; 
                        this.btnNext = true; 
                        EventBus.$emit('iniciarProduccionOperarios');
                    break;
                case 5: // Tarea 6: Validacion
                        this.btnNext=false;
                    break;
                case 6: // Tarea 7: Finalización
                        this.btnPrev=false;
                    break;
            }
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
                        if(this.validation){
                            this.btnPrev = false;
                        }
                        this.btnNext = false;
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

        onLoading(e){
            console.log(e);
        },

       
        
    }
}
</script>

    