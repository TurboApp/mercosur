
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

// import VueRouter from 'vue-router';
// Vue.use(VueRouter);


require('vue2-animate/dist/vue2-animate.min.css');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('card', require('./components/cards/Card.vue'));
Vue.component('card-collapse', require('./components/cards/Collapse.vue'));


//trafico
// import Trafico from './components/views/trafico/nuevoTrafico.vue';
// Vue.component('app-trafico', Trafico);

// import formTransporte from './components/views/trafico/forms/transporte.vue';
// Vue.component('form-transporte', formTransporte);

//Transportes
import transportesList from './components/views/servicios/transportes.vue';
Vue.component('transportes-list', transportesList);
import transporteForm from './components/views/servicios/transporte-form.vue';
Vue.component('transporte-form', transporteForm);

// import transporteSuggest from './components/views/trafico/forms/transporteSuggest.vue';
// Vue.component('transporte-suggest', transporteSuggest);
//import formDocumento from './components/views/trafico/forms/documentos.vue';

//Servicio
//import servicioNuevo from './components/views/servicios/create.vue';
//Vue.component('servicio-nuevo', servicioNuevo);

//Documentos

Vue.component('add-document', require('./components/views/trafico/addDocument.vue'));

Vue.component('select-document', require('./components/views/trafico/selectDocument.vue'));
Vue.component('form-documento', require('./components/views/trafico/forms/documento.vue'));


Vue.component('panel-coordinacion', require('./components/views/coordinacion/master.vue'));
Vue.component('maniobra-tareas', require('./components/views/maniobras/master.vue'));

Vue.component('notificaciones-app', require('./components/views/notificaciones/master.vue'));
Vue.component('dropdown-notification', require('./components/views/notificaciones/dropdownNotificationList.vue'));

Vue.prototype.$http = require('axios');

import EventBus from './components/event-bus';

var vm = new Vue({
    el: '#app',
    data(){
        return {
            auth:{}
        }
    },
    created(){
       this.loadDatos();
       
    },
    mounted(){
        this.notificaciones();
        this.eventValidation();
    },
    methods:{
        loadDatos(){
            let self = this;
            axios.get('/API/auth').then(function (response) {
               self.auth = response.data;
            });
        },
        eventValidation(){
            Echo.channel('maniobra-channel')
                .listen('ManiobraTareaValidacion', (data) => {
                    //recibe el evento
                    EventBus.$emit('validationEvent', data );
                });   
        },
        notificaciones(){
            let self = this;
            Echo.channel('notification-channel')
            
                .listen('notificaciones', (data) => {
                    console.log(data);
                    if(self.auth.id == data.notify.receptor_id){
                        EventBus.$emit('notificaciones');

                        $.notify({
                            icon: "notifications_none",
                            message: '<h4>'+data.notify.titulo+'</h4>'+data.notify.mensaje
                        },{
                            type: data.notify.type,
                            timer: 4000,
                            placement: {
                                from: 'top',
                                align: 'right'
                            }
                        });

                        Push.create(data.notify.titulo, {
                            body: data.notify.mensaje,
                            icon: data.notify.url_icon,
                            link: data.notify.url,
                            timeout: 8000,
                            onClick: function () {
                                window.focus();
                                this.close();
                            }
                        });

                    }
                });   
        }
    }
});



