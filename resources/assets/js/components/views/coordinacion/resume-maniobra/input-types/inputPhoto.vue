<template>
    <div class="row"> 
        <div class="col-xs-12">
            <card>
                <h3 class="text-center text-uppercase" v-text="title"></h3>
                <div class="col-xs-12 text-center">
                    <div v-if="images.length > 0">
                        <div v-for="(image, index) in images" :key="index" :class="colum" :style="styleColum">
                            <a :href="'/'+image.url" :data-lightbox="title" class="thumbnail" style="display:block; width:100%; height:100%;">
                                <img class="img img-responsive img-thumbnail" :src="'/'+image.url" :alt="text" >
                            </a>
                        </div>
                    </div>
                    <div v-else>
                        <p class="lead text-muted">Aun no se han agregado fotos</p>
                    </div>
                </div>
            </card>    
        </div>    
    </div>
</template>
<script>
import card from "./../../../../cards/Card.vue";
export default {
    components:{
        'card':card,
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
        limit:{
            type:Number,
            default:1
        }
    },
    data(){
        return {
            images:[],
            token:'',
        }
    },
    created(){
        this.listenEvent();
    },
    mounted(){
        this.token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let self = this;
        axios.get('/maniobra/subtarea/photos/'+this.id)
            .then(function (response) {
                    self.images = response.data;
        });
    },
    computed:{
        colum(){
            switch(this.images.length){
                 case 0:
                case 1:
                    return 'col-xs-12 col-sm-10 col-sm-offset-1';
                    
                //case 2:
                default:
                    return 'col-xs-12 col-sm-6';
                // case 1:
                //     return 'col-xs-12 col-sm-6 col-sm-offset-3';
                    
                // case 2:
                //     return 'col-xs-6 col-sm-6';
                
                // default:
                //     return 'col-xs-6 col-sm-3';
            }
        },
        styleColum(){
            switch(this.images.length){
                 case 0:
                case 1:
                    return 'height:350px; margin-bottom:25px; overflow:hidden;';
                    
                //case 2:
                default:
                    return 'height:280px; margin-bottom:25px; overflow:hidden;';
                // case 1:
                //     return 'height:300px; margin-bottom:25px; overflow:hidden;';
                    
                // case 2:
                //     return 'height:280px; margin-bottom:25px; overflow:hidden;';
                    
                // default:
                //     return 'height:150px; margin-bottom:25px; overflow:hidden;';
                                    
            }
        }
    },
    methods:{
        listenEvent()
        {
            let self = this;
            Echo.channel('maniobra-channel')
                .listen('SubtareaUpdate', (data) => {
                    if(self.id == data.subtarea.subtarea_id)
                    {
                        self.images.push(data.subtarea);
                    }
                }); 
             Echo.channel('maniobra-channel')
                .listen('ManiobraRemovePhoto', (data) => {
                    if(self.id == data.photo.subtarea_id)
                    {
                        axios.get('/maniobra/subtarea/photos/'+self.id)
                            .then(function (response) {
                                    self.images = response.data;
                        });
                    }
                }); 
        }
    }
}
</script>

