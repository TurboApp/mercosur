<template>
    <div>
        
        <form-wizard @on-complete="onComplete" 
            title="Este es un titulo personlaizado" 
            subtitle="Este es un subtitulo personalizado"
            next-button-text="Siguiente"
            back-button-text="Anterior"
            finish-button-text="Finalizar"
            color="#3498db"
            >
            <tab-content v-for="(tarea, index) in tareas" :title="tarea.titulo_corto" :icon="tarea.icono" :key="index">
                <h2 v-text="tarea.titulo_largo" class="text-center text-uppercase"></h2>
                <hr>
                <sub-tareas :tarea-id="tarea.id"></sub-tareas>
            </tab-content>
        </form-wizard>
    </div>
</template>
<script>
import FormWizard from './components/FormWizard.vue';
import TabContent from './components/TabContent.vue';
import subTareas from './subTareas.vue';
export default {
    components: {
        'form-wizard':FormWizard,
        'tab-content':TabContent,
        'sub-tareas' : subTareas,
    },
    props:{
        maniobraId:{
            type: [Number, String],
            required: true, 
        },
    },
    data(){
        return {
            tareas:[]
        }
    },
    mounted(){
        console.log(this.maniobraId);
        let self = this;
        axios.get('/API/supervision/getTareas/'+this.maniobraId)
            .then(function (response) {
                self.tareas = response.data;
                console.log(response.data);
        });
    },
    methods:{
        onComplete(){
            console.log('completado');
        }
    }
}
</script>

    