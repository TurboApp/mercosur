<template>
  <div>
      <div v-if="supervisor > 0 ">
          <resume-maniobra :supervisor-id="supervisor" :servicio-id="datos.servicio_id"></resume-maniobra>
      </div>
      <div v-else>
          <select-supervisor :id="id" ></select-supervisor>
      </div>
  </div>
</template>
<script>

import EventBus from '../../event-bus.js';

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
      datosM :[],
    }
  },
  computed:{
    id(){
      return this.datos.id;
    },
    supervisor(){
      return this.datosM.supervisor_id;
    }
  },
  created(){
    this.EventBus();
  },
  mounted(){
    this.datosM = this.datos;
  },
  methods:{
    EventBus(){
        let self = this;
        EventBus.$on('supervisorSeleccionado', (data)=>{
            this.$set(self.datosM, 'coordinador_id', parseInt(data.coordinador_id));
            this.$set(self.datosM, 'supervisor_id', parseInt(data.supervisor_id));
            this.$set(self.datosM, 'status', data.status);
        });
    }
  }
}
</script>

