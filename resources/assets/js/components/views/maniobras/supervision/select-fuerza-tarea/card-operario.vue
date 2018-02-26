<template>
    
    <a href @click.prevent="itemSelected(operario)" >
        <div class="card" :class="cardClass" style="padding:12px 0; margin:0; margin-bottom:7px;" >
            <div class="col-xs-2 col-sm-3">
                <div class="">
                    <img class="img img-responsive img-circle" :class="imgClass" :src="avatar">
                </div>
            </div>
            <div class="col-xs-10 col-sm-9">
                <div v-if="isLoading" class="pull-right">
                    <i class="fa fa-circle-o-notch fa-spin fa-fw text-warning"></i>
                </div>
                <h4 class="title text-truncate" :title="operario.nombre" v-text="operario.nombre" style="paddin:0;margin:0;"></h4>
                <h6 class="text-muted text-truncate" :title="operario.categoria" style="paddin:0;margin:0;">
                    <span v-text="operario.categoria"></span>
                    <!-- <i v-if="isLoading" class="fa fa-circle-o-notch fa-spin  fa-fw"></i> -->
                </h6>
            </div>
        </div> 
    </a>
    
</template>
<script>

export default {
    props:['operario','index','maniobraId'],
    data(){
        return {
            isActive:false,
            isLoading:false,
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
        this.token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        if(this.operario.status == 1){
            this.isActive = true;
        }else{
            this.isActive = false;
        }
    },
    methods:{
        itemSelected(data){
            let self = this;
            let estatus = !this.isActive ? "1" : "0";
            let update = !this.isActive ? "insertar" : "eliminar";
            this.isLoading = true;
            axios.patch(`/maniobras/fuerza-tarea/status/${this.operario.id}/${this.maniobraId}`,{
                    status: estatus,
                    _token:self.token
            }).then( function(fuerzaTarea){
                if(fuerzaTarea.status == 200){
                    console.log('fuerzaTarea.data.status');
                    console.log(fuerzaTarea.data.status);
                    console.log('estatus');
                    console.log(estatus);
                    if(fuerzaTarea.data.status === estatus){
                        axios.post(`/maniobras/produccion/${self.maniobraId}/${self.operario.id}`, {
                                _token:self.token,
                                tipo: update
                            }).then(function (produccion){
                                self.operario.status = fuerzaTarea.data.status;
                                if(fuerzaTarea.data.status==1){
                                    self.isActive = true;
                                }else{
                                    self.isActive = false;
                                }
                                self.isLoading = false;
                                self.$emit('select-operario', true)
                            });
                    }else{
                        self.$emit('select-operario', false)
                        self.isLoading = false;
                    }
                }else{
                    window.location.reload(true);
                }
            });
            
        },
        
    }
   
}
</script>


