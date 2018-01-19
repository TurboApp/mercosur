<template>
    <div>
        <div v-if="maniobraTipo=='Trasbordo'">
            Trasbordo
        </div>
        <div v-else>
            <div class="list-group list-task">
                <subtarea-element v-for="(subtarea, index) in subTareas" 
                    class="list-group-item list-task-item"
                    :key="subtarea.id" 
                    :input-type="subtarea.inputType"
                    :limit="subtarea.limit"
                    :id="subtarea.id"
                    :title="subtarea.subtarea"
                    :help-text="subtarea.texto_ayuda"
                    :maniobra-id="maniobraId"
                    :value="subtarea.value"
                    :index="index"
                    /> 
            </div>
        </div>
    </div> 
</template>
<script>
import subTareaElement from './subTareaElement.vue';

export default {
    components: {
        'subtarea-element': subTareaElement
    },
    props:{
        tareaId:{
            type:[Number, String],
        },
        maniobraId:{
            type:[Number, String],
            required: true
        },
        maniobraTipo:{
            type: String,
            required: true
        },
       
    },
    data(){
        return {
            subTareas:[]
        }
    },
    mounted(){
        let self = this;
        axios.get('/API/supervision/getSubTareas/'+this.tareaId)
            .then(function (response) {
                self.subTareas = response.data;
        });

    },
    methods:{
        
    }
}
</script>
