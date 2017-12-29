<template>
    <div class="row"> 
        <div class="col-xs-12" >
            <card class="grey lighten-4" style="padding-bottom:2.5rem;">
                <h3 class="text-center text-uppercase" v-text="title"></h3>
                <div class="col-xs-12 text-center">
                    <p class="form-group text-muted" v-text="text"></p>
                    <div v-if="!image">
                        <vueSignature 
                            @signatureSave="guardar"
                            >
                        </vueSignature>
                    </div>
                    <div v-else>
                        <div class="row">
                            <div class="col-xs-12 col-md-6 col-md-offset-3">
                                <button type="button" @click.prevent="removeSignature" class="btn btn-just-icon btn-simple btn-danger" style="position:absolute;top:-10px;right:10px;">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
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
import vueSignature from "./../../../../ui/vue-signature.vue";
export default {
    components:{
        'card':card,
        vueSignature,
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
            option:{
                penColor:"rgb(0, 0, 0)"
            },
            image:'',
        }
    },
    mounted(){
        this.token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let self = this;
        axios.get('/maniobra/subtarea/firma/'+this.id+'/'+this.title)
            .then(function (response) {
                    if(response.data.value){
                        self.image ='/' + response.data.value;
                    }
               
        });
    },
    
    methods:{
        guardar(e){
            let self = this;
            
            let formData = new FormData();
            formData.append('file', e);
            //let config = { headers: { 'Content-Type':'application/json' } };
            axios.post('/maniobra/subtarea/'+ this.id + '?_token=' + this.token + '&inputType=firma&name='+this.title, formData)
                .then(function (response) {
                    self.image = e;
            });
        },
        removeSignature(){
            let self=this;
            swal({
                title: '¿Está seguro de eliminar la firma?',
                text: "Usted no podra revertir esto",
                type: 'warning',
                showCancelButton: true,
                cancelButtonClass: 'btn btn-simple btn-danger',
                confirmButtonClass: 'btn btn-danger',
                confirmButtonText: '¡Eliminar!',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false
                }).then(function (result) {
                    axios.delete('/maniobras/subtarea/'+self.id+'/destroy',{
                        params: {
                            inputType: 'signature',
                        }
                    }).then(function(response){
                        self.image='';
                    });
            })
           
        },
    }
}
</script>

