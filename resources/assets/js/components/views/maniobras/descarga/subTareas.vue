<template>
    <div>
        <div class="list-group list-task">
            
            <subtarea-element v-for="(subtarea, index) in subTareas" 
                class="list-group-item list-task-item"
                :key="subtarea.id" 
                :input-type="subtarea.inputType"
                :id="subtarea.id"
                :title="subtarea.subtarea"
                :help-text="subtarea.texto_ayuda"
                />
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
            required: true
        }
    },
    data(){
        return {
            subTareas:[]
        }
    },
    mounted(){
        console.log(this.maniobraId);
        let self = this;
        axios.get('/API/supervision/getSubTareas/'+this.tareaId)
            .then(function (response) {
                self.subTareas = response.data;
                console.log(response.data);
        });
    },
    methods:{
        
    }
}
</script>
