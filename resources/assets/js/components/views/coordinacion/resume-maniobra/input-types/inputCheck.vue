<template>
    <div class="row">
        <div class="col-xs-8">
            <h4 v-text="title"></h4>    
        </div>
        <div class="col-xs-4 text-right">
            <div v-if="val == 1">
                Si
            </div>
            <div v-else>
                No
            </div>
        </div>
    </div>
</template>
<script>
export default {
    components:{

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
            input:false,
            token:'',
            val:''
        }
    },
    created(){
        this.val = this.value;
        this.listenEvent();
    },
    mounted(){
        this.input = Boolean( Number( this.value ) );
        this.token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
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

