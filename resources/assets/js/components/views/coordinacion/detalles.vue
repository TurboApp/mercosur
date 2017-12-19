<template>
  <div>
      <div v-if="datos.supervisor_id">
          <resume-maniobra :supervisor-id="datos.supervisor_id" :servicio-id="datos.servicio_id"></resume-maniobra>
      </div>
      <div v-else>
          <select-supervisor :id="id" ></select-supervisor>
      </div>
  </div>
</template>
<script>
import selectSupervisor from './select-supervisores/select-supervisor.vue';
import resumeManiobra from './resume-maniobra/detalles-maniobra.vue';
export default {
  components:{
    'select-supervisor':selectSupervisor,
    'resume-maniobra':resumeManiobra,
  },
  props:{
      datos:{
        type: [Array, Object],
        required:true
      },
  },
  data(){
    return {
     
    }
  },
  computed:{
    id(){
      return this.datos.id;
    }
  },
  mounted(){
    
  }
}
</script>

