<template>
<div>
    <div class="row">
        <div class="col-md-12">
            <h2>Nueva Orden de Servicio</h2>
        </div>

        <div class="col-md-6 col-md-push-6">
            <div class="form-group">
                <p class="pull-right ">
                    <span >{{moment().format('dddd,').charAt(0).toUpperCase()+moment().format('dddd, D \\d\\e MMMM \\d\\e YYYY').slice(1)}}</span>   <br>
                </p>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-md-pull-6">
            <select v-model="form.tipoServicio" class="selectpicker" data-style="btn btn-primary btn-round " title="Tipo de servicio" data-size="7" @change="chgServicio"  required>
                <option :value="servicio" v-for="servicio in servicios" v-text="servicio"></option>
            </select>
        </div><!-- ./col -->
        <div class="col-md-3 col-sm-12 col-md-pull-6">
            <select  v-model="form.agente" class="selectpicker" data-style="btn btn-primary btn-round" title="Asignado a" data-size="7" required>
                    <option :value="agente.nombre" v-for="agente in agentes" v-text="agente.nombre"></option>
            </select>
        </div><!-- ./col -->
        
    </div><!-- ./row -->
    <card>
        <div class="row ">
            <div class="col-md-6 col-sm-12">
                <h3 v-text="form.tipoServicio"></h3>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="row form-horizontal">
                    <div class="col-sm-6 col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" title="Fecha">
                                <i class="fa fa-calendar "></i> Fecha
                            </span>
                            <input type="text" v-model="form.fecha" class="form-control datepicker">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-clock-o"></i> Hora
                            </span>
                            <input type="text" v-model="form.hora" class="form-control timepicker">
                        </div>
                    </div>
                </div><!-- ./form-horizontal  -->
            </div><!-- ./col -->
        </div><!-- ./row -->
        
        <div class="row">
            <div class="col-md-8">
                <div class="form-group label-floating">
		            <label class="control-label">Cliente</label>
                    <span class="twitter-typeahead">
		                <input id="busqueda_cliente" type="text" class="form-control search_cliente" v-model="form.cliente" name="cliente" required>
                    </span> 
	            </div>
            </div>    
            <div class="col-md-4">
                <div class="form-group label-floating" :class="{'is-focused':form.rfc}">
                    <label class="control-label" >RFC</label>
		            <span class="twitter-typeahead">
		                <input id="rfc_cliente" type="text" class="form-control" placeholder="RFC" v-model="form.rfc" required disabled>
                    </span> 
	            </div>
            </div>            
        </div>

        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="form-group label-floating">
                    <label class="control-label">Destinatario</label>
                    <span class="twitter-typeahead">
                        <input type="text" class="form-control search_destinatario" v-model="form.destinatario" required>
                    </span>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group label-floating">
                    <label class="control-label">País</label>
                    <div class="btn-group bootstrap-select show-tick">
                        <span class="twitter-typeahead">
                            <input type="text" class="form-control paises" v-model="form.pais" required>
                        </span>
                    </div>
                </div>
            </div>
            
        </div><!-- /row-->
        <card-collapse title="Este es un card">
            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.

        </card-collapse>
    </card> 
    
    
       
            <tabs icons>
                <tab name="Transporte" icon="local_shipping" :active="true">
                    <template v-if="form.tipoServicio=='Carga'">
                        <card bg-color="blue">
                            <template slot="title">Trasporte Destino</template> 
                            <form-transporte v-model="form.transporte.destino"></form-transporte>
                        </card>
                    </template>
                    <template v-else-if="form.tipoServicio=='Descarga'">
                        <card bg-color="blue">
                            <template slot="title">Transporte Cliente</template> 
                            <form-transporte v-model="form.transporte.cliente"></form-transporte>        
                        </card>
                    </template>
                    
                    <template v-else-if="form.tipoServicio=='Trasbordo'">
                        <card-tabs title="Datos de transporte:"  bg-color="blue">
                            <card-tab tab-title="Cliente" icon="person" :active="true">
                                <form-transporte v-model="form.transporte.cliente" legend="Transporte Cliente"></form-transporte>
                            </card-tab>
                            <card-tab tab-title="Destino" icon="perm_identity">
                                <form-transporte v-model="form.transporte.destino" legend="Trasporte Destino"></form-transporte>
                            </card-tab>
                        </card-tabs>
                    </template>

                </tab>
                <tab name="Documentación" icon="attach_file">
                    <card bg-color="blue">
                    <template slot="title">Documentos mercancia</template> 
                        <form-documento v-model="form.documento" legend="Este es un titulo"></form-documento>
                    </card>
                </tab>
            </tabs>
            {{form.documento}}
       
        <find-cliente v-model="form.cliente"></find-cliente>
        {{form}}

</div> 

</template>
<script>
import card from '../../cards/Card.vue';
import cardCollapse from '../../cards/Collapse.vue';
import cardsTabs from '../../cards/cardsTabs.vue';
import cardtab from '../../cards/cardTab.vue';
import tabs from '../../uiComponents/tabs.vue';
import tab from '../../uiComponents/tab.vue';
import formTransporte from './forms/transporte.vue';
import formDocumento from './forms/documentos.vue';
import axios from 'axios';
var moment = require('moment');

import findCliente from './forms/findCliente.vue';
require('moment/locale/es');
 
export default {
    components:{
        'card':card,
        'card-tabs':cardsTabs,
        'card-tab':cardtab,
        'card-collapse':cardCollapse,
        'tabs':tabs,
        'tab':tab,
        'form-transporte':formTransporte,
        'form-documento':formDocumento,
        'find-cliente':findCliente,
        
    },
    data(){
        return{
            moment: moment,
            form:{
                tipoServicio:'',
                agente:'',
                fecha:'',
                hora:'',
                cliente:'',
                rfc:'',
                destinatario:'',
                pais:'',
                transporte:{
                    cliente:{},
                    destino:{}
                },
                documento:{
                    controlDocumento:'1233'
                }
            },
            agentes:[],
            todayDate:'',
            servicios:['Descarga','Carga','Trasbordo','Otros servicios'],
            selected: 2,
            options: [
                { id: 1, text: 'Hello' },
                { id: 2, text: 'World' }
            ]
        }    
    },
    mounted(){
        //this.fecha = moment().format('LL');
        this.form.fecha= moment().format('DD/MM/YYYY');
        this.form.hora = moment().format('h:mm A');
        
        axios.get('/API/agentes').then((response) => this.agentes = response.data);
        
        const $selectpicker = $(this.$el).find('.selectpicker');
    

    //     $selectpicker
    //   .selectpicker()
    //   .on('changed.bs.select', () => this.$emit('changeWeek', this.options[$selectpicker.val()]));
    },

    methods:{
        chgServicio(){
            console.log("Cambia servicio: "+this.tipoServicio);
           
        },
        getResponse: function (response) {
            return response.data.items
        }

    },
    updated() {
        $(this.$el).find('.selectpicker').selectpicker('refresh');
    },

}
</script>
<style lang="scss">
</style>   

