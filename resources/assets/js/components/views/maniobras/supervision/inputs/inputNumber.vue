<template>
    <div class="row">
        <div class="col-xs-12">
            <h4 v-text="title"></h4>    
        </div>
        <div class="col-xs-12" >
            <div class="form-group" :class="classSuccess">
                <input type="number" v-model="input" @blur="guardar" min="1" class="form-control input-lg" :placeholder="text">
                 <span class="form-control-feedback" v-if=" classSuccess == 'has-success'  ">
                    <i class="material-icons">done</i>
                </span>
            </div>
        </div>
    </div>
</template>
<script>
export default {
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
            type:[String, Number]
        }
    },
    data(){
        return{
            input:''
        }
    },
     computed:{
        classSuccess(){
            if(this.input){
                return 'has-success';
            }
        }
    },
    mounted(){
        this.input = this.value;
    },
    methods:{
        guardar(){
            let self = this;
            let token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            axios.post('/maniobra/subtarea/'+ this.id,{
                    inputType: 'text',
                    value:self.input,
                    _token: token 
            }).then(function(response){
                
            }).catch(function(error){
               
            });
            
        }
    }
}
</script>

