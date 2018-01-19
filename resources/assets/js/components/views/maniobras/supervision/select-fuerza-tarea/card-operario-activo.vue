<template>
        
    <a href @click.prevent="itemSelected(operarioActivo)" >
        <div class="card  light-green accent-1" style="padding:12px 0; margin:0; margin-bottom:7px;" >
            <div class="col-xs-2 col-sm-3">
                <div class="">
                    <img class="img img-responsive img-circle z-depth-3" :src="avatar">
                </div>
            </div>
            <div class="col-xs-10 col-sm-9">
                <h4 class="title text-truncate" :title="operarioActivo.nombre" v-text="operarioActivo.nombre"></h4>
                <h6 class="text-muted text-truncate" :title="operarioActivo.categoria">
                    <span v-text="operarioActivo.categoria"></span>
                </h6>
            </div>
        </div> 
    </a>
    
</template>
<script>

export default {
    props:['operarioActivo','index'],
    data(){
        return {
          
        }
    },
    computed:{
        avatar(){
            let image = this.operarioActivo.categoria.replace(/ /g,'-');
            return '/img/fuerza-' + image + '.png';
        },
       
    },
    methods:{
        itemSelected(data){
            this.$emit('remove-select-operario',  this.index)
        }
    }
   
}
</script>


