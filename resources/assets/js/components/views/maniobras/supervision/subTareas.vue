<template>
    <div>
        <div v-if="tareaTipo=='doble'">
            <tabs css-class="nav-justified tab-space">
                <tab name="Nacional" >
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
                            :options="subtarea.options"
                            :index="index"
                            v-if="subtarea.tipo_transporte=='N'"
                            /> 
                    </div> 
                </tab>
                <tab name="Centroaméricano">
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
                            :options="subtarea.options"
                            :index="index"
                            v-if="subtarea.tipo_transporte=='C'"
                            /> 
                    </div> 
                </tab>
            </tabs> 
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
                    :options="subtarea.options"
                    :index="index"
                    /> 
            </div>
        </div>
        <!-- <div class="text-center">
            <button class="btn amber lighten-3 btn-round">
                <i class="material-icons">message</i> Observaciones
            </button>
        </div> -->
    </div> 
</template>
<script>
import subTareaElement from './subTareaElement.vue';
import tabs from '../../../ui/nav/tabs.vue';
import tab from '../../../ui/nav/tab.vue';
export default {
    components: {
        'tabs':tabs,
        'tab':tab,
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
        tareaTipo:{
            type: String,
            default: 'single'
        },
        subTareas:{
            type:[Array, Object],
            //required: true
        }
       
    },
    data(){
        return {
            //subTareas:[]
        }
    },
    mounted(){
        let self = this;
        axios.get('/API/supervision/getSubTareas/'+self.tareaId)
            .then(function (response) {
                //self.subTareas = response.data;
        });

    },
    methods:{
        
    }
}
</script>
