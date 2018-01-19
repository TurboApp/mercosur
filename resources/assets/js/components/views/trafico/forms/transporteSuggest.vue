<template>
    <input 
    type="text" 
    class="form-control" 
    :id="id"
    @input="updateValue($event.target.value)"
    required>
</template>    
<script>
var Bloodhound = require('typeahead.js')
//import EventBus from '../../../event-bus.js';
export default {
    name:'transporte-suggest',
    props: {
      value: {
        type: String,
        default: ''
      },
      name: {
        type: String,
        default: ''
      },
      placeholder: {
        type: String,
        default: ''
      },
      
    },
    data(){
        var id =  'transporte-suggestion' + parseInt(Math.random() *100000);
        return {
            id,
        }
    },
    mounted(){
        this.init_typeahead();
    },
    created() {
        //EventBus.$on('remove', this.$delete(this));
    },
    methods:{
        updateValue: function (value) {
            this.$emit('input', value)
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

            $(document).find('#'+self.id).typeahead({
            
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
            let ltransporteSelected='';
            let ltransporte=function(eventObject, suggestionObject, suggestionDataset){
               ltransporteSelected=suggestionObject.nombre;
                $('#'+self.id).parent().next('.transporte-id').val(suggestionObject.id);
                $('#'+self.id).closest('div.form-group').removeClass('has-error');
                
            };
                $('#'+self.id).on('typeahead:selected', ltransporte);
                $('#'+self.id).on('typeahead:autocompleted', ltransporte);
                $('#'+self.id).on('typeahead:change', function($e,data){
                if(data !== ltransporteSelected){
                   console.log(data);
                    $('#'+self.id).parent().next('.transporte-id').val('');
                    $('#'+self.id).closest('div.form-group').addClass('has-error');
                    
                    $('#'+self.id).closest('div.form-group').addClass('has-error');
                }
            });
        },

        
       
    },

    
}
</script>