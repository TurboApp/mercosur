<template>
<div>
    <div>
        <card v-for="(doc,index) in documentos" :key="index">
            <template slot="title">{{tituloDocumento(doc.tipo,doc.nombre)}}</template>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Tipo de documento <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select class="selectpicker" :name="tipoDoc(index)" data-style="select-with-transition" v-model="doc.tipo" @change="change" title=" " required>
                                    <option value="FACTURA" >FACTURA</option> 
                                    <option value="REMISIÓN">REMISIÓN</option> 
                                    <option value="PREGUIA">PREGUIA</option> 
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Numero <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" :name="nombreDoc(index)" v-model="doc.nombre" value="" maxlength="191" required>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label">Descripción</label>
                    <div class="col-md-10">
                        <textarea class="form-control" v-model="doc.descripcion" :name="descDoc(index)"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" v-if="index>0">
                    <button type="button" class="btn btn-danger btn-sm btn-simple" @click="deleteForm(index)">
                        <i class="material-icons">delete</i> Eliminar 
                    </button>
                </div>
            </div>
        </card>
        <div class="row">
            <div class="col-md-12 text-right" >
                <button type="button" class="btn btn-primary btn-simple" @click="addDoc">
                    <i class="material-icons">add_box</i> Agregar Documento
                </button>
            </div>
        </div>
    </div>
</div>
</template>
<script>
import cardCollapse from '../../cards/Card.vue';
import inputFile from '../../uiComponents/inputFile.vue';
import EventBus from '../../event-bus.js';

export default {
    components:{
        'card-collapse':cardCollapse,
        'input-file':inputFile,
        
    },
    data(){
        return{
            documentos:[
                {
                tipo:'',
                nombre:'',
                descripcion:'',
                archivo:''
            }
            ],
   
            newFile:[],
            files:[],
    
        }
    },
    
    methods:{
        addDoc(){
            this.documentos.push({
                tipo:'',
                nombre:'',
                descripcion:''
            });
          
            
        },
        deleteForm(index){
            this.documentos.splice( index , 1 )
            
            if(this.documentos.length<1){
                this.addDoc();
            }
        },
        getFile(e){
            this.newFile=e;
        },
        change(e){
            console.log('Entra');
        
            $(this).valid();
            $(this).siblings( ".btn" ).removeClass('btn-danger');
            $(this).siblings( ".select-with-transition" ).removeClass('error_selectpicker');
            $(this).closest( ".form-group" ).removeClass('has-error');
        
        },    
       
        tipoDoc(indice){
            return 'documento['+(indice)+'][tipo_documento]';
        },
        nombreDoc(indice){
            return 'documento['+(indice)+'][num_documento]';
        },
        descDoc(indice){
            return 'documento['+(indice)+'][mercancia_descripcion]';
        },
        
        tituloDocumento(tipo,nombre){
            let titulo;
            titulo = tipo + ' - ' + nombre;
            if(titulo===' - '){
                titulo = "Documento";
            }
            return titulo;    
        }

       
    },
    computed:{
    },
    updated() {
        
        $(this.$el).find('.selectpicker').selectpicker('refresh');
    },
}
</script>

