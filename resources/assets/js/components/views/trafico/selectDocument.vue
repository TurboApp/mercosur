<template>
    <div>
        <div v-if="!inputs.length">
            <div class="alert alert-warning alert-dismissible" role="alert">
                <strong>¡Atención!</strong> Debe de selecionar al menos un documento.
            </div>
            
            <input type="hidden" id="" :name="tipoDoc(0)" value="" />
            <input type="hidden" id="" :name="numeroDoc(0)" value="" />
            
        </div>
        <ul class="document-list">
            <li class="document-item" v-for="(doc,index) in documentos" :key="index">
                <div class="document-icon text-center">
                    <div v-if="doc.status>0">
                        <div class="document-icon text-center">
                            <a  href @click.prevent="select(doc)" >
                                <div v-if="!doc.isActive">
                                    <span class="fa-stack fa-3x">
                                        <i class="fa fa-circle text-warning fa-stack-2x"></i>
                                        <i class="fa fa-file-text-o fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div v-else >
                                    <span class="fa-stack fa-3x">
                                        <i class="fa fa-circle text-success fa-stack-2x"></i>
                                        <i class="fa fa-check fa-stack-1x fa-inverse"></i>
                                    </span>
                                    
                                </div>
                            </a>
                        </div>
                    </div>
                    <div v-else>
                        <div class="document-icon text-center">
                            <span class="fa-stack fa-3x">
                                <i class="fa fa-circle text-success fa-stack-2x"></i>
                                <i class="fa fa-file-text-o fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="document-details">
                    <h4 class="text-truncate title">{{ doc.tipo_documento }} - {{ doc.num_documento }}</h4>
                    <p class="text-truncate-ln4">{{ doc.mercancia_descripcion }}</p>
                </div>
            </li>  
        </ul>
        <div v-for="(input, index) in inputs" :key="index">
            <input type="hidden" id="" :name="padreDoc(index)" v-model="input.id" />
            <input type="hidden" id="" :name="tipoDoc(index)" v-model="input.tipo_documento" />
            <input type="hidden" id="" :name="numeroDoc(index)" v-model="input.num_documento" />
            <input type="hidden" id="" :name="descDoc(index)" v-model="input.mercancia_descripcion" />
        </div>
    </div>
</template>
<script>

import card from '../../cards/Card.vue';


export default {
    components:{
        'card':card,
    },
    props:{
        data:{
            type:[Array, Object],
            required:true,
        },
    },
    data(){
        return{
            documentos:[],
            inputs:[],
        }
    },
    
    mounted(){
        this.documentos=this.data;
        this.documentos.forEach(function(doc){
             if(doc.status){
                 doc.isActive=false;
             }   
        });
        //$(document).find('.btn-next').prop('disabled',true);
    },
    
    methods:{
        
        select(e){
            let index=this.documentos.indexOf(e);
            console.log(e.isActive);
            if(!e.isActive){
                this.addInput(e);
                this.documentos[index].isActive=true;
                
            }else{
                this.rmInput(e);
                this.documentos[index].isActive=false;
            }
        },

        addInput(input){
             this.inputs.push(input);   
             $(document).find('.btn-next').prop('disabled',false);
        },   

        rmInput(e){
            let index=this.inputs.indexOf(e);
            this.inputs.splice( index , 1 );
            if(!this.inputs.length){
                $(document).find('.btn-next').prop('disabled',true);
            }
        },

        padreDoc(indice){
            return 'documento['+(indice)+'][documento_padre]';
        },
        tipoDoc(indice){
            return 'documento['+(indice)+'][tipo_documento]';
        },
        numeroDoc(indice){
            return 'documento['+(indice)+'][num_documento]';
        },
        descDoc(indice){
            return 'documento['+(indice)+'][mercancia_descripcion]';
        },
            
    },
    
}
</script>

