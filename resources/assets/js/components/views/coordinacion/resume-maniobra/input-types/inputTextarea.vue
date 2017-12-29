<template>
    <div class="row">
        <div class="col-xs-12">
            <h4 v-text="title"></h4>    
        </div>
        <div class="col-xs-12">
            <p>
                <textarea  class="form-control input-lg" disabled v-text="val"></textarea>
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
            val:''
        }
    },
    created(){
        this.val = this.value;
        this.listenEvent();
    },
    mounted(){
        
    },
    methods:{
        listenEvent()
        {
            let self = this;
            Echo.channel('maniobra-channel')
                .listen('SubtareaUpdate', (data) => {
                    if(self.id == data.subtarea.id)
                    {
                        self.val = data.subtarea.value;
                    }
                }); 
        }
    }
}
</script>

