<template>
    <div class="row">
        <div class="col-xs-8">
            <h3 v-text="title"></h3>    
            <p class="list-group-item-text text-muted" v-text="text"></p>
        </div>
        <div class="col-xs-4 text-right">
            <p class="form-group">
                <toggle-button :value="input" :color="'#2ECC40'" :sync="true" :height="25"
                    :labels="{checked: '<i class=\'fa fa-check\' ></i>', unchecked: ''}" 
                    @change="isCheck"/>
            </p>
        </div>
    </div>
</template>
<script>
import ToggleButton from './components/toogleButton.vue';
export default {
    components:{
        'toggle-button':ToggleButton,
    },
    props:{
        title:{
            type:String,
            required:true
            },
        text:{
            type:String,
            required:true
            },
        id:{
            type:[Number]
        },
        value:{
            type: [Number, String]
        }
    },
    data(){
        return{
            input:false
        }
    },
    mounted(){
        this.input = Boolean( Number( this.value ) );
    },
    methods:{
        isCheck(e){
            let token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            axios.post('/maniobra/subtarea/'+ this.id,{
                    inputType: 'check',
                    value:e.value,
                    _token: token 
                
            }).then(function(response){
               
            }).catch(function(error){
               
            });
        }
    }
}
</script>

