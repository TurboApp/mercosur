<template>
    <div class="row"> 
            <div class="col-xs-12">
                <card>
                    <h3 class="text-center text-uppercase" v-text="title"></h3>
                    <div class="col-xs-12 text-center">
                        <p class="form-group text-muted" v-text="text"></p>
                        <div v-if="images.length > 0" class="clearfix">
                            <div v-for="(image, index) in images" :key="index" :class="colum" :style="styleColum">
                                <button type="button" @click.prevent="removeFoto(image.id, index)" class="btn btn-just-icon btn-simple btn-danger" style="position:absolute;top:-10px;right:10px;">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
                                <a :href="'/'+image.url" :data-lightbox="title" class="thumbnail" style="display:block; width:100%; height:100%;">
                                    <img class="img img-responsive img-thumbnail" :src="'/'+image.url" :alt="text" >
                                </a>
                            </div>
                            <upload v-if="limit > images.length" :url="urlUpload" :done="feedBack" image capture class="grey lighten-3" :class="colum" :style="styleColum">
                                <i class="material-icons md-36 text-muted">add_a_photo</i>
                            </upload>
                        </div>
                        <div v-else>
                            <upload :url="urlUpload" :done="feedBack" image capture class="grey lighten-3" :class="colum" :style="styleColum">
                                <i class="material-icons md-36 text-muted">add_a_photo</i>
                            </upload>
                        </div>
                    </div>
                </card>    
            </div>    
    </div>
</template>
<script>
import card from "./../../cards/Card.vue";
import upload from "./components/file-upload.vue";
export default {
    components:{
        'card':card,
        upload,
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
    mounted(){
        this.token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let self = this;
        axios.get('/maniobra/subtarea/photos/'+this.id)
            .then(function (response) {
                    self.images = response.data;
        });
    },
    computed:{
        urlUpload(){
            return '/maniobra/subtarea/'+ this.id + '?_token=' + this.token + '&inputType=photo';
        },
        colum(){
            switch(this.limit){
                case 1:
                    return 'col-xs-12 col-sm-8 col-sm-offset-2';
                    
                case 2:
                    return 'col-xs-6 col-sm-6';
                
                default:
                    return 'col-xs-6 col-sm-3';
            }
        },
        styleColum(){
            switch(this.limit){
                case 1:
                    return 'height:300px; margin-bottom:25px; overflow:hidden;';
                    
                case 2:
                    return 'height:280px; margin-bottom:25px; overflow:hidden;';
                    
                default:
                    return 'height:150px; margin-bottom:25px; overflow:hidden;';
                                    
            }
        }
    },
    methods:{
        feedBack(status, responseText, feedBack){
            this.images.push(JSON.parse( responseText ));
        },
        removeFoto(fotoId, index){
            let self=this;
            swal({
                title: '¿Está seguro de eliminar la foto?',
                text: "Usted no podra revertir esto",
                type: 'warning',
                showCancelButton: true,
                cancelButtonClass: 'btn btn-simple btn-danger',
                confirmButtonClass: 'btn btn-danger',
                confirmButtonText: '¡Eliminar!',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false
                }).then(function (result) {
                    axios.delete('/maniobras/subtarea/'+fotoId+'/destroy',{
                        params: {
                            inputType: 'photo',
                        }
                    }).then(function(response){
                        self.images.splice(index, 1);
                    });
            })
           
        },
    }
}
</script>

