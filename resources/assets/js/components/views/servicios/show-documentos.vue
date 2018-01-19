<template>
  <div>
      <h3 class="title">Documentos</h3>
      <card>
          <template>
              <ul class="document-list">
                <li class="document-item" v-for="(documento, index) in documentos" :key="index">
                    <div v-if="documento.status > 0">
                        <span class="fa-stack fa-3x">
                            <i class="fa fa-circle text-primary fa-stack-2x"></i>
                            <i class="fa fa-file-text-o fa-stack-1x fa-inverse"></i>
                        </span>
                    </div>
                    <div v-else >
                        <span class="fa-stack fa-3x">
                            <i class="fa fa-circle text-success fa-stack-2x"></i>
                            <i class="fa fa-check fa-stack-1x fa-inverse"></i>
                        </span>
                    </div>
                    <div class="document-details">
                        <h4 class="text-truncate title" :title="documento.tipo_documento +' - '+ documento.documento">{{documento.tipo_documento + ' - ' + documento.num_documento }}</h4>
                        <p class="text-truncate-ln3">{{ documento.mercancia_descripcion }}</p>
                    </div>
                    
                </li>
              </ul>
          </template>
      </card> 
  </div>
</template>
<script>
export default {
   props:{
      documentos:{
        type: [Array, Object],

      }
  }
}
</script>

