<template>
   <div>
       <template>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning alert-with-icon">
                        <i class="material-icons" data-notify="icon" >warning</i>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                        </button>
                        <span data-notify="message"> 
                            <b>Aun no se le ha asignado un supervisor</b> 
                        </span>
                    </div>
                </div>
            </div>
        </template>
        <template>
            <div class="row">
                <div class="col-md-12">
                    <div class="search-sup-wrapper">
                        <label >
                            <span v-show="!searching">
                                <i class="fa fa-search fa-lg" aria-hidden="true"></i>
                            </span>
                            <span v-show="searching">
                                <i class="fa fa-circle-o-notch fa-spin fa-lg fa-fw"></i>
                            </span>
                        </label>
                        <input class="search-sup-input" v-model="supervisor" @keyup="search" type="text" placeholder="Supervisor...">   
                    </div>
                </div>
            </div>
            <div class="row">
                <div v-if="supervisores.length > 0">
                    <transition-group name="fade">
                        <card-supervisor v-for="(supervisor, index) in supervisores" :key="index" :supervisor="supervisor" :index="index" @select-supervisor="addSupervisor(supervisor)"></card-supervisor>
                    </transition-group>
                </div>
                <div v-else class="text-center">
                    <h3>No hay datos que mostrar</h3>
                </div>
            </div>
        </template>
    </div> 
</template>
<script>
import cardSupervisor from './card-supervisor.vue';
import EventBus from '../../../event-bus.js';
export default {
    props:['id'],
    components:{
        'card-supervisor':cardSupervisor,

    },
    data(){
        return {
            supervisores:[],
            supervisor:'',
            searching:false,
        }
    },
    mounted(){
        let self = this;
        axios.get('/API/supervisores/')
            .then(function (response) 
            {
                self.supervisores = response.data;
            }
        );    
    },
    methods:{
        search(e){
            let self = this;
            this.searching=true;
            axios.get('/API/supervisores/'+e.target.value)
                .then(function (response) 
                {
                    self.supervisores = response.data;
                    self.searching=false;
                }
            );    
        },
        addSupervisor(data){
            let self= this;
            swal({
                showCancelButton: true,
                html: `
                    <img class="z-depth-4 img img-circle img-resposive" src="`+ data.url_avatar.replace('public/','/storage/') +`" onerror='this.onerror = null; this.src="/img/supervisor.png"' style="max-width:120px;margin:0 auto;">
                    <h3 class="title">`+ data.nombre +' '+ data.apellido +`</h3>
                    <h6 class="text-muted text-uppercase">`+ data.user +`</h6>
                `,
                allowOutsideClick: false,
                allowEscapeKey:false,
                cancelButtonClass: 'btn btn-simple btn-primary',
                confirmButtonClass: 'btn btn-primary',
                confirmButtonText: 'Agregar',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false
                })
                .then(function () {
                   axios.get('/API/coordinacion/servicio/agregar_supervisor/'+ self.id +'/'+ data.id)
                        .then(function (response) {
                            EventBus.$emit('actialuzarDatos',response.data);
                    });
                   
            }).catch(swal.noop);//End swal
   
        }
    }
}
</script>
<style lang="scss">
    .fade-enter-active, .fade-leave-active {
        transition: all 1s;
    }
    .face-enter, .fade-leave-to /* .list-leave-active below version 2.1.8 */ {
        opacity: 0;
        transform: translateY(30px);
    }
</style>


