<template>
    <div class="row">
        <div class="col-xs-8 col-sm-9 col-md-10">
            <h4 v-text="title"></h4>    
        </div>
        <div class="col-xs-4 col-sm-3 col-md-2">
            Aqui van el check list
               <!-- <select 
                    class="selectpicker"
                    v-model="input"
                    @change="guardar"
                    :data-style = "input == 'Seleccione' ? 'btn btn-round' : 'btn btn-round btn-success' "  
                    :title="input"
                    >
                        <option v-for="(option, index) in selectOptions" 
                                :key = "index"
                                :value = "option"
                                v-text="option"
                                >
                        </option> 
                </select> -->
            
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
            type:String,
        },
        options:{
            type:String
        },
        
    },
    data(){
        return{
            input:this.value,
            selectOptions:[],
        }
    },
    created(){
        this.input = !this.value ? 'Seleccione' : this.value;
    },
    mounted(){
        this.splitOptions();
    },
    methods:{
        splitOptions(){
            this.selectOptions = this.options.split(',');
        },
        guardar(){
            let self = this;
            
            
            
            // let token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            // axios.post('/maniobra/subtarea/'+ this.id,{
            //         inputType: 'select',
            //         value:self.input,
            //         _token: token 
            // }).then(function(response){
            // });
            
        },
       
        
    },
    updated() {
        
    },
}
</script>

