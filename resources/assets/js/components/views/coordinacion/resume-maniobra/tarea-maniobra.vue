<template>
    <div>
        <card class="cardTaksShowInfo" style="margin:10px 0; position: relative;">
            <div class="container-fluid">
                <div class="row collapseInfo" @click="showInfo" style="padding:15px 20px;">
                    <div class="col-xs-2 col-sm-1">
                        <span :class="statusIcon">
                            <i class="fa fa-circle fa-stack-2x "></i>
                            <i class="fa-stack-1x fa-inverse" :class="datos.icono"></i>
                        </span>
                    </div>
                    <div class="col-xs-10 col-sm-11 ">
                        <h4 v-text="datos.titulo_corto" style="margin:3px 0;"></h4>
                        <h6 v-text="datos.titulo_largo" style="margin:3px 0;"></h6>
                    </div>
                </div>
                <transition name="fade">
                    <div class="row" v-if="show" style="padding:15px 20px;">
                        <hr>
                        <div class="col-xs-12">
                            <subtareas-maniobra :tarea-id="datos.id" :maniobra-id="maniobraId" />
                        </div>
                    </div>
                </transition>
            </div>
        </card>
    </div>
</template>
<script>
import card from './../../../cards/Card.vue';
import subtareas from './subtarea-maniobra.vue';
export default {
    components:{
        'card':card,
        'subtareas-maniobra':subtareas,
    },
    props:{
        datos:{
            type: Object,
            required: true,            
        }
    },
    data(){
        return{
            show:false, 
            maniobraId:''
        }
    },
    mounted(){
        this.maniobraId = this.$parent.$parent.$options.propsData.datos.servicio_id;
    },
    computed:{
        statusIcon(){
            let estatus ='text-muted';
            if(this.datos.status == 'finalizado' ){
                estatus ='text-success';
            }
            else if(this.datos.status == 'en proceso'){
                estatus ='text-warning';
            }

            return 'fa-stack fa-2x ' + estatus;
        }
    },
    methods:{
        showInfo(){
           this.show = !this.show;     
        },
        getSubtareas(){
            
        }
    }
}
</script>
<style lang="scss">
.cardTaksShowInfo{
    .card-content{
        padding:0;
    }
    .collapseInfo:active{
        background:#eeeeee;
    }
}

</style>
