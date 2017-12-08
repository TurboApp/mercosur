<template>
<div>
      <h3 class="title">Archivos</h3>
      <card>
        <template>
        <ul class="files-list">
            <li class="file-item" v-for="(archivo, index) in archivos" :key="index">
                    <a :href="'/'+archivo.url" target="_blank">
                        <div class="file-icon">
                            <div v-if="archivo.extension === 'xls' || archivo.extension === 'xlsx'">
                                <img src="/img/iconos/xls.svg">
                            </div>
                            <div v-else-if="archivo.extension === 'docx' || archivo.extension === 'doc'">
                                <img src="/img/iconos/doc.svg">
                            </div>
                            <div v-else-if="archivo.extension === 'ppt' || archivo.extension === 'pptx'">
                                <img src="/img/iconos/ppt.svg">
                            </div>
                            <div v-else-if="archivo.extension === 'pdf' ">
                                <img src="/img/iconos/pdf.svg">
                            </div>
                            <div v-else>
                                <img :src="'/'+archivo.url" style="padding:auto 15px;">
                            </div>
                        </div>

                        <div class="file-details">
                            <h6 class="file-name text-truncate"><b>{{ archivo.nombre }}</b></h6>
                            <span class="file-size">{{ archivo.size }}</span>
                            <span class="file-minetype text-truncate-ln4">{{ archivo.minetype }}</span>
                        </div>
                    </a>
                </li>
        </ul>
    </template>
</card>

  </div>
</template>
<script>
import axios from 'axios';
export default {
    props:{
      archivos:{
        type: [Array, Object],
      }
    },
    data(){
        return{
        
        }
    },
    mounted(){
        
    },
    methods:{
        
    }
}
</script>

