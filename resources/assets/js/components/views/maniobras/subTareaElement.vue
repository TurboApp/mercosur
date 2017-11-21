<template>
    <div>
        <div class="row" v-if="inputType == 'check'">
            <div class="col-xs-8">
                <h3 class="title" v-text="title"></h3>    
                <p class="list-group-item-text text-muted" v-text="helpText"></p>
            </div>
            <div class="col-xs-4 text-right">
                <p class="form-group">
                    <toggle-button :value="false" :color="'#2ECC40'" :sync="true" :height="25"
                    :labels="{checked: '<i class=\'fa fa-check\' ></i>', unchecked: ''}" 
                    @change="alerta"/>
                </p>
            </div>
        </div>
        <div class="row" v-else-if="inputType == 'text'">
            <div class="col-xs-12">
                <h3 class="title" v-text="title"></h3>    
                <span class="list-group-item-text text-muted" v-text=""></span>
            </div>
            <div class="col-xs-12">
                <p class="form-group">
                    <input type="text" class="form-control input-lg" :placeholder="helpText">
                </p>
            </div>
        </div>

    </div>
</template>
<script>
import ToggleButton from './components/toogleButton.vue';
export default {
    components:{
        'toggle-button':ToggleButton
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
            type:String
        }
    },
    data(){
        return{

        }
    },
    methods:{
        alerta(){
            console.log("Se ejecuta el evento");
        }
    }
}
</script>
