<template>
    <card >
        <div class="row">
            <div class="col-md-12">  
                <div class="form-group">
                    <span class="twitter-typeahead">
                        <label for="lineaTransporte" class="control-label">Linea de transporte <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" :id="idlt" :name="name_linea_transporte(index)" v-model="transporte.lineaTranporte" required />
                        <input type="hidden" :name="name_id_linea_transporte(index)" v-model="transporte.id_linea_transporte" >
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">  
                <div class="form-group">
                    <label for="operadorUnidad" class="control-label">Nombre del operador <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" :name="name_nombre_operador(index)" v-model="transporte.nombre_operador" required maxlength="120" >   
                </div>
            </div>
            <div class="col-md-4">  
                <div class="form-group">
                    <label for="n_talon" class="control-label">No. de talon <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" :name="name_talon_embarque(index)" v-model="transporte.talon_embarque" maxlength="191" required>   
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="marcaVehiculo" class="control-label">Marca del Vehiculo <span class="text-danger">*</span></label>
                    <input type="text" :name="name_marca_vehiculo(index)" :id="idmv" class="form-control get-marca-vehiculo"  v-model="transporte.marca_vehiculo"  maxlength="191" required>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="placasTractor" class="control-label">Placas del tractor <span class="text-danger">*</span></label>
                    <input type="text" :name="name_placas_tractor(index)" class="form-control" v-model="transporte.placas_tractor" maxlength="191"  required>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="placasCaja" class="control-label">Placas de la caja <span class="text-danger">*</span></label>
                    <input type="text" :name="name_placas_caja(index)" class="form-control" v-model="transporte.placas_caja" maxlength="191" required>
                    <span class="material-input"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group ">
                    <label  for="tipoUnidad" class="control-label">Tipo de unidad <span class="text-danger">*</span></label>
                    <span class="twitter-typeahead">
                        <input type="text" class="form-control" :id="idtv" :name="name_tipo_unidad(index)" v-model="transporte.tipo_unidad" maxlength="191" required>
                    </span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Medida <span class="text-danger">*</span></label>
                    <select class="selectpicker" :name="name_medida_unidad(index)" data-style="select-with-transition" v-model="transporte.medida_unidad" title=" " required>
                        <option value="26 PIES" >26 PIES</option> 
                        <option value="35 PIES" >35 PIES</option> 
                        <option value="40 PIES" >40 PIES</option> 
                        <option value="45 PIES" >45 PIES</option> 
                        <option value="48 PIES" >48 PIES</option> 
                        <option value="53 PIES" >53 PIES</option>
                    </select>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="ejes" class="control-label">No. Ejes <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" :name="name_ejes(index)" v-model="transporte.ejes" min="1" max="20" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="cantidad" class="control-label">Cantidad <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" :name="name_cantidad(index)" v-model="transporte.cantidad" min="1" max="20" required>
                </div>
            </div>
        </div>
        <div slot="footer">
            <div class="row">
                <div class="col-md-12" v-if="index>0">
                    <button type="button" class="btn btn-danger btn-sm btn-simple " @click="remove">
                        <i class="material-icons">delete</i> Eliminar 
                    </button>
                </div>
            </div>
        </div>
    </card>
</template>
<script>
import card from '../../cards/Card.vue';
import transporteSuggest from '../trafico/forms/transporteSuggest';
var Bloodhound = require('typeahead.js');
export default {
    components:{
        'card':card,
        'transporte-suggest': transporteSuggest
    },
    name:'transporte-form',
    props : {
        transporte:{
            type:Object,
        },
        index:{
            type:Number,
        },
		tipo: {
            type: String,
            default:'origen'
        },
    },
    data(){
        return {
            idlt:'ts-'+parseInt(Date.now()),
            idmv:'gmv-'+parseInt(Date.now()),
            idtv:'gtv-'+parseInt(Date.now()),
        }
    },
    //created(){
        //idtl= 'ts-'+parseInt(Date.now());
    //},
    
    mounted(){
        this.init_typeahead();
        this.getMarcaVehiculo();
        this.getTipoVehiculo();
    },
    methods:{
        remove(){
            this.$emit('remove','this.index');
        },
        //nombres de campos     
        name_linea_transporte(indice){
            return '[linea_transporte]['+ indice +']';
        },
        name_id_linea_transporte(indice){
            return 'transporte['+ (indice) +']['+ this.tipo +'][linea_transporte_id]';
            
        }, 
        name_nombre_operador(indice){
            return 'transporte['+ indice +']['+this.tipo+'][nombre_operador]';
        },
        name_talon_embarque(indice){
            return 'transporte['+indice+']['+this.tipo+'][talon_embarque]';
        },
        name_marca_vehiculo(indice){
            return 'transporte['+indice+']['+this.tipo+'][marca_vehiculo]';
        },
        name_placas_tractor(indice){
            return 'transporte['+indice+']['+this.tipo+'][placas_tractor]';
        },
        name_placas_caja(indice){
            return 'transporte['+indice+']['+this.tipo+'][placas_caja]';    
        },
        name_tipo_unidad(indice){
            return 'transporte['+indice+']['+this.tipo+'][tipo_unidad]';
        },
        name_medida_unidad(indice){
            return 'transporte['+indice+']['+this.tipo+'][medida_unidad]';
        },
        name_ejes(indice){
            return 'transporte['+indice+']['+this.tipo+'][ejes]';
        },
        name_cantidad(indice){
            return 'transporte['+indice+']['+this.tipo+'][cantidad]';
        },  

        tipoVehiculo(index){
            return 'tipoVehiculo'+index;
        },

        
        init_typeahead(){
            var self =  this;
            let getDataTransportes = new Bloodhound({
                remote: {
                    url: '/find/transporte?q=%QUERY%',
                    wildcard: '%QUERY%'
                },
                datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
                queryTokenizer: Bloodhound.tokenizers.whitespace
            });
            
            getDataTransportes.initialize();

            $(document).find('#'+self.idlt).typeahead({
                hint: true,
                highlight: true,
                limit:8,
            }, {
                display: 'nombre',
                source: getDataTransportes.ttAdapter(),
                name: 'transportes',
                templates: {
                    empty:function(){
                        return '<h4 class="text-danger"> &nbsp;<i class="fa fa-exclamation-circle" aria-hidden="true"></i> La busqueda no obtuvo ningun resultado.</h4>';
                    },
                    suggestion: function (data) {
                        return '<p>' + data.nombre + ' ( '+ data.nombre_corto +' )' + '</p>';
                    }
                }
            });
            
            let ltransporte=function(eventObject, suggestionObject, suggestionDataset){
                self.transporte.lineaTranporte=suggestionObject.nombre;
                self.transporte.id_linea_transporte=suggestionObject.id;
                //$('#'+self.idlt).closest('div.form-group').removeClass('has-error');
                //$(document).find('.btn-next').prop('disabled',false);
                
            };
                $('#'+self.idlt).on('typeahead:selected', ltransporte);
                $('#'+self.idlt).on('typeahead:autocompleted', ltransporte);
                $('#'+self.idlt).on('typeahead:change', function($e,data){
                if(data !== self.transporte.lineaTranporte){
                    self.transporte.id_linea_transporte='';
                    $('#'+self.idlt).closest('div.form-group').addClass('has-error');
                    $(document).find('.btn-next').prop('disabled',true);
                }
            });
        },

        getMarcaVehiculo(){
            var self =  this;
            var marcasV = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('marca'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: '/data/marcavehiculos.json',
                
            });
            // Initializing the typeahead with remote dataset without highlighting
            $( '#'+self.idmv ).typeahead({
            hint: true,
            highlight: true,
            minLength: 0,
            }, {
                lmit:8,
                name: 'marca',
                display:'marca',
                source: marcasV,
                templates: {
                    suggestion: function (data) {
                        return '<p><span  class="icon-m-v '+ data.icono +'"></span><span class="marca-vehiculo">' + data.marca + '</span></p>';
                    }
                }
            });

            let marcatransporte=function(eventObject, suggestionObject, suggestionDataset){
                self.transporte.marca_vehiculo=suggestionObject.marca;
            };
            
            $('#'+self.idmv).on('typeahead:selected', marcatransporte);
            $('#'+self.idmv).on('typeahead:autocompleted', marcatransporte);
        },

        getTipoVehiculo(){
            var self =  this;
            var tipoV = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('tipo'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: '/data/tipovehiculos.json',
                
            });
            // Initializing the typeahead with remote dataset without highlighting
            $('#'+self.idtv).typeahead({
            hint: true,
            highlight: true,
            minLength: 0,
            }, {
                lmit:8,
                name: 'tipoVehiculo',
                display:'tipo',
                source: tipoV,
                templates: {
                    suggestion: function (data) {
                        return '<p><span class="tt-dataset">' + data.tipo + '</span></p>';
                    }
                }
            });
            
            let tipotransporte=function(eventObject, suggestionObject, suggestionDataset){
                self.transporte.tipo_unidad=suggestionObject.tipo;
            };
            
            $('#'+self.idtv).on('typeahead:selected', tipotransporte);
            $('#'+self.idtv).on('typeahead:autocompleted', tipotransporte);
        },

    },

    updated() {
        $(this.$el).find('.selectpicker').selectpicker('refresh');
    },

}
</script>

