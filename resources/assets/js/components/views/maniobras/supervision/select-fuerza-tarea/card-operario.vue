<template>
    
    <a href @click.prevent="itemSelected(operario)" >
        <div class="card blue-grey lighten-5" style="padding:12px 0; margin:0; margin-bottom:7px;" >
            <div class="col-xs-2 col-sm-3">
                <div class="">
                    <img class="img img-responsive img-circle z-depth-3" :src="avatar">
                </div>
            </div>
            <div class="col-xs-10 col-sm-9">
                <h4 class="title text-truncate" :title="operario.nombre" v-text="operario.nombre"></h4>
                <h6 class="text-muted text-truncate" :title="operario.categoria">
                    <span v-text="operario.categoria"></span>
                </h6>
            </div>
        </div> 
    </a>
    
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
        itemSelected(data){
      
                this.$emit('select-operario', this.operario)
            
        }
    }
   
}
</script>


