<template>
    <div class="form-horizontal">
        <legend>{{legend}}</legend>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <label class="col-sm-3 label-on-left">Tipo Documento</label>
                    <div class="col-md-9">
                        <div class="btn-group bootstrap-select" > 
                            <select class="selectpicker" data-style="select-with-transition" ref="tipodoc" :value="value.tipoDoc" @change="update"  >
                                <option value="Factura">Factura</option>
                                <option value="Nota Remision">Nota de Remición</option>
                                <option value="Preguia">Preguia</option>    
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 label-on-left">Control Documento</label>
                    <div class="col-md-8">
                        <div class="form-group label-floating is-empty">
                            <input type="text" class="form-control" ref="controldoc" :value="value.control" @input="update" >
                            <span class="help-block">Ingrese el numero de control del documento</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <label class="col-md-2 label-on-left">Descripción Documento</label>
                    <div class="col-md-10">
                        <div class="form-group label-floating is-empty">
                            <input type="text" class="form-control" ref="descripciondoc" :value="value.descripcion" @input="update">
                            <span class="help-block">Ingrese Descripción del Documento</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                

                <upload-lista-empaque></upload-lista-empaque>
                
                

            </div>
        </div>
    </div>
</template>
<script>
import listaEmpaque from './file-upload.vue';
export default {
    name:'form-documento',
    components:{
       'upload-lista-empaque':listaEmpaque
    },
    
    props:['legend','value'],
    mounted(){
        console.log(this.value);
        console.log(this.legend);
    },
    methods:{
        update(){
            this.$emit('input',{
                tipoDoc:  this.$refs.tipodoc.value,
                control:   this.$refs.controldoc.value,
                descripcion:   this.$refs.descripciondoc.value,
                file:  this.$refs.filedoc.value
            });
        },
        
    }
}
</script>
<style lang="scss">
.file-uploads {
  font-size: 18px;
  padding: .6em;
  font-weight: bold;
  border: 1px solid #888;
  background: #f3f3f3
}

</style>