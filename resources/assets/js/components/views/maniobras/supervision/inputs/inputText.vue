<template>
    <div class="row">
        <div class="col-xs-12">
            <h3 v-text="title"></h3>    
        </div>
        <div class="col-xs-12">
            <p class="form-group">
                <input type="text" v-model="input" @blur="guardar" class="form-control input-lg" :placeholder="text">
            </p>
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

