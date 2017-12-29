<template>
    <div>
        <div>
            <img class="img img-responsive img-circle z-depth-3" :src="'/img/fuerza-' +  operarioActivo.categoria.replace(/ /g,'-') + '.png'">
        </div>
        <div class="col-xs-8 col-sm-10 text-left form-group">
            <p class="text-uppercase text-truncate" v-text="operarioActivo.nombre"></p>
            <small v-if="operarioActivo.inicio">
                <i class="fa fa-clock-o" aria-hidden="true"></i> INICIO  {{operarioActivo.inicio}}
                <template v-if="operarioActivo.final"> - FINAL {{operarioActivo.final}}  </template>
            </small>
        </div>
        <div class="col-xs-2 col-sm-1">
            <button type="button" @click.prevent="removeItem(operarioActivo)" class="btn btn-just-icon btn-round btn-danger btn-simple">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</template>
<script>

export default {
  props:[
      'operarioActivo',
      'index',
  ],
  methods:{
    removeItem(data){
        let self = this;
        swal({
                html:`<h4 class="text-danger">Usted eliminará de la lista...</h4>
                    <h6 class="title text-truncate">`+ data.nombre +`</h4>
                    <img class="img img-responsive img-circle z-depth-3" src="/img/fuerza-` +  data.categoria.replace(/ /g,'-') + `.png" style="margin:0 auto;">
                    <h6>`+ data.categoria +`</h6>
                   `,
                
               // type: 'warning',
                showCancelButton: true,
                cancelButtonClass: 'btn btn-simple btn-danger',
                confirmButtonClass: 'btn btn-danger',
                confirmButtonText: '¡Eliminar!',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false
                }).then(function (result) {
                    self.$emit('rmOperarioActivo', self.index);
                    
            })
    }
  }

}
</script>

