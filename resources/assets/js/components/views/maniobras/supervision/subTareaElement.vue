<template>
    <div>
        <div  v-if="inputType == 'check'">
            <input-check :title="title" :text="helpText" :id="id" :value="value"></input-check>
        </div>
       
        <div v-else-if="inputType == 'text'">
            <input-text :title="title" :text="helpText" :id="id" :value="value"></input-text>
        </div>
        <div v-else-if="inputType == 'select'">
            <input-select :title="title" :text="helpText" :id="id" :value="value" :options="options"></input-select>
        </div>
        <!-- <div v-else-if="inputType == 'ckeckList'">
            
            <input-checklist :title="title" :text="helpText" :id="id" :value="value" :options="options"></input-checklist>
        </div> -->
        <div v-else-if="inputType == 'number'">
            <input-number :title="title" :text="helpText" :id="id" :value="value"></input-number>
        </div>
        <div v-else-if="inputType == 'textarea'">
            <input-textarea :title="title" :text="helpText" :id="id" :value="value"></input-textarea>
        </div>
        <div v-else-if="inputType == 'photos'">
            <input-photo :title="title" :text="helpText" :id="id" :limit="limit"></input-photo>
        </div>
        <div v-else-if="inputType == 'draw'">
            <input-signature :title="title" :text="helpText" :id="id"></input-signature>
        </div>
        <div v-else-if="inputType == 'component-fuerzatarea'">
            <fuerza-tarea :title="title" :text="helpText" :id="id" :maniobra-id="maniobraId"></fuerza-tarea>
        </div>
        <div v-else-if="inputType == 'button-validation'">
            <button-validation :title="title" :text="helpText" :id="id" :maniobra-id="maniobraId" :tarea-id="tareaID"  :value="value"></button-validation>
        </div>
        
    </div>
</template>
<script>

import inputPhoto from './inputs/inputPhoto.vue';
import inputSignature from './inputs/inputSignature.vue';
import inputCheck from './inputs/inputCheck.vue';
import inputText from './inputs/inputText.vue';
import inputSelect from './inputs/inputSelect.vue';
// import inputCheckList from './inputs/inputCheckList.vue';
import inputNumber from './inputs/inputNumber.vue';
import inputTextArea from './inputs/inputTextarea.vue';
import fuerzaTarea from './select-fuerza-tarea/select-operarios.vue';
import validacion from './inputs/validation.vue';

export default {
    components:{
        'input-check': inputCheck,
        // 'input-checklist': inputCheckList,
        'input-text': inputText,
        'input-select': inputSelect,
        'input-number': inputNumber,
        'input-textarea': inputTextArea,
        'input-photo': inputPhoto,
        'input-signature': inputSignature,
        'fuerza-tarea': fuerzaTarea,
        'button-validation': validacion,
    },
    props:{
        inputType:{
            type: String,
            required:true,
        },
        id:{
            type:[Number, String],
            required:true
        },
        title:{
            type:String,
            required:true
        },
        helpText:{
            type: String
        },
        value:{
            type: [Number, String]
        },
        index:{
            type:[Number, String]
        },
        maniobraId:{
            type:[Number, String]
        },
        limit:{
            type:Number,
        },
        options:{
            type:String,
        }
    },
    data(){
        return{
           
        }
    },
    computed:{
        tareaID(){
            return this.$parent.$options.propsData.tareaId;
        }
    },
    methods:{
       
                
    },
  
  
}
</script>
