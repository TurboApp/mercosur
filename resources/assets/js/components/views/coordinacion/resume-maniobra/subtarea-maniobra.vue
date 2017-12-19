<template>
    <div>
        <div class="list-group list-task" v-if="subTareas.length > 0">
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
        <div v-else >
            <p class="text-center text-muted">
                <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
            </p>
        </div>
    </div>
</template>
<script>
import subtarea from './subtarea-element.vue';
export default {
    components:{
        'subtarea-element':subtarea,
    },
    props:{
        tareaId:{
            type:[Number, String],
            required: true
        },
        maniobraId:{
            type:[Number, String],
            required: true
        },
       
    },
    data(){
        return{
            subTareas:[]
        }
    },
    mounted(){
        this.getSubtareas();
    },
    methods:{
        getSubtareas(){
            let self = this;
            axios.get('/API/supervision/getSubTareas/'+this.tareaId)
                .then(function (response) {
                    console.log(response.data);
                    self.subTareas = response.data;
            });    
        }
    }
}
</script>
