<template>
    
    <a href @click.prevent="itemSelected(operario)" >
        <div class="card" :class="cardClass" style="padding:12px 0; margin:0; margin-bottom:7px;" >
            <div class="col-xs-2 col-sm-3">
                <div class="">
                    <img class="img img-responsive img-circle" :class="imgClass" :src="avatar">
                </div>
            </div>
            <div class="col-xs-10 col-sm-9">
                <h4 class="title text-truncate" :title="operario.nombre" v-text="operario.nombre" style="paddin:0;margin:0;"></h4>
                <h6 class="text-muted text-truncate" :title="operario.categoria" style="paddin:0;margin:0;">
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
            isActive:false,
            
        }
    },
    computed:{
        avatar(){
            let image = this.operario.categoria.replace(/ /g,'-');
            return '/img/fuerza-' + image + '.png';
        },
        imgClass(){
            if(!this.isActive){
                return 'img-gray';
            }else{
                return 'z-depth-3';
            }
        },
        cardClass(){
            if(!this.isActive){
                return 'grey lighten-2';
            }else{
                return 'light-green accent-1';
            }
        }
    },
    mounted(){
        if(this.operario.status == 1){
            this.isActive = true;
        }else{
            this.isActive = false;
        }
    },
    methods:{
        itemSelected(data){
            this.isActive = !this.isActive;
            if(this.isActive){
                this.operario.status = 1;
            }else{
                this.operario.status = 0;
            }
            console.log(this.operario.status);
            this.$emit('select-operario', this.operario, this.isActive)
        }

    }
   
}
</script>


