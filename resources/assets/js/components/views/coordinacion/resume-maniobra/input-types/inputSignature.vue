<template>
    <div class="row"> 
        <div class="col-xs-12" >
            <card class="grey lighten-4" style="padding-bottom:2.5rem;">
                <h3 class="text-center text-uppercase" v-text="title"></h3>
                <div class="col-xs-12 text-center">
                    <div v-if="!image">
                        <p class="lead text-muted">Aun no hay nada que mostrar</p>
                    </div>
                    <div v-else>
                        <div class="row">
                            <div class="col-xs-12 col-md-6 col-md-offset-3">
                                <img  class="img img-responsive img-thumbnail" :src="image" :alt="text">
                            </div>
                        </div>
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
    },
    data(){
        return {
            token:'',
            image:'',
        }
    },
    mounted(){
        //this.token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let self = this;
        axios.get('/maniobra/subtarea/firma/'+this.id+'/'+this.title)
            .then(function (response) {
                if(response.data.value){
                    self.image ='/' + response.data.value;
                }
        });
    },
    methods:{
    }
}
</script>

