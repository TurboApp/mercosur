<template>
    <div>
        <div class="list-group list-task" v-if="subTareas.length > 0">
            <div v-if="tareaTipo=='doble'">
                <tabs css-class="nav-justified">
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
                        :auth-id="authId"
                        :value="subtarea.value"
                        :index="index"
                        /> 
                </div>
            </div>
            <!-- <subtarea-element v-for="(subtarea, index) in subTareas" 
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
                />  -->
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
import tabs from '../../../ui/nav/tabs.vue';
import tab from '../../../ui/nav/tab.vue';
export default {
    components:{
        'tabs':tabs,
        'tab':tab,
        'subtarea-element':subtarea,
    },
    props:{
        tareaId:{
            type:[Number, String],
            required: true
        },
        tareaTipo:{
            type:String,
            required:false
        },
        maniobraId:{
            type:[Number, String],
            required: true
        },
        
        authId:{
            type:Number,
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
                    self.subTareas = response.data;
            });    
        },
    }
}
</script>
