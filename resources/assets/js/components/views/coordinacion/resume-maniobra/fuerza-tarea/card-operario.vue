<template>
    <div class="col-xs-3">
        <div class="card grey lighten-4" style="padding:12px 0; margin:0; margin-bottom:7px;" >
            <div class="col-xs-12">
                <div class="">
                    <img class="img img-responsive img-circle z-depth-3" :src="avatar">
                </div>
            </div>
            <div class="col-xs-12">
                <h4 class="title text-truncate text-center" :title="operario.nombre" v-text="operario.nombre"></h4>
                <h6 class="text-muted text-truncate text-center" :title="operario.categoria">
                    <span v-text="operario.categoria"></span>
                </h6>
            </div>
        </div> 
    </div>
</template>
<script>

export default {
    props:['operario','index'],
    data(){
        return {
        }
    },
    computed:{
        avatar(){
            let image = this.operario.categoria.replace(/ /g,'-');
            return '/img/fuerza-' + image + '.png';
        },
       
    },
    methods:{
        
    }
   
}
</script>


