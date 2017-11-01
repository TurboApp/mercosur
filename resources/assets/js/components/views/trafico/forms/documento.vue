<template>
<card-collapse :title="title">
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="form-group">
                    <label class="col-md-4 control-label">Tipo de documento</label>
                    <div class="col-md-8">
                        <select class="selectpicker" :name="tipoDoc" data-style="select-with-transition"  title=" " required>
                            <option value="Factura" >Factura</option> 
                            <option value="Remision">Remision</option> 
                            <option value="Preguia">Preguia</option> 
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="form-group">
                    <label class="col-md-4 control-label">No. documento</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" :name="numeroDoc" value="" required>  
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-md-2 control-label">Descripción</label>
            <div class="col-md-10">
                <textarea :name="descDoc" class="form-control"></textarea>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <label for="listaEmpaque" class="col-md-2 control-label">Lista de empaque</label>
        <div class="col-md-10">
            <input type="file" :name="listEmpaque" accept="application/pdf">
            <p class="help-block">Lista de empaque</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn bnt-sm btn-danger btn-simple" @click="remove(indice)">
                <i class="material-icons">delete</i> Eliminar documento
            </button>
        </div>
    </div>
</card-collapse>
</template>
<script>
import cardCollapse from '../../../cards/Collapse.vue';
export default {
    components:{
        'card-collapse':cardCollapse
    },
    props:['index'],
    data(){
        return{
            indice:0
        }
    },
    mounted(){
        this.indice=this.index;
    },
    computed:{
        title(){
            return 'Documento '+(this.indice+2);
        },
        tipoDoc(){
            return 'documento['+(this.indice+1)+'][tipoDocumento]';
        },
        numeroDoc(){
            return 'documento['+(this.indice+1)+'][nDocumento]';
        },
        descDoc(){
            return 'documento['+(this.indice+1)+'][descripcionDocumento]';
        },
        listEmpaque(){
            return 'documento['+(this.indice+1)+'][listaEmpaque]';
        }
    },
    methods:{
        remove(i){
            this.$emit('remove',i);
        }
    },
    updated() {
        $(this.$el).find('.selectpicker').selectpicker('refresh');
    },
}
</script>

