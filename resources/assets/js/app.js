
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

require('vue2-animate/dist/vue2-animate.min.css');



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('card', require('./components/cards/Card.vue'));

// Vue.component('card-collapse', require('./components/cards/Collapse.vue'))

// Vue.component('card-tabs', require('./components/cards/cardsTabs.vue'));
// Vue.component('card-tab', require('./components/cards/cardTab.vue'));

// Vue.component('fg-input', require('./components/form/formGroupInput.vue'));
 //Vue.component('tabs', require('./components/uiComponents/tabs.vue'));
 //Vue.component('tab', require('./components/uiComponents/tab.vue'));
// Vue.component('input-file', require('./components/uiComponents/inputFile.vue'));
// Vue.component('todo-list', require('./components/misselanius/todolist.vue'));
// Vue.component('app-pagination', require('./components/misselanius/pagination.vue'));

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
import addDocument from './components/views/trafico/addDocument.vue';
Vue.component('add-document', addDocument);
import selectDocument from './components/views/trafico/selectDocument.vue';
Vue.component('select-document', selectDocument);
Vue.component('form-documento', require('./components/views/trafico/forms/documento.vue'));



Vue.component('panel-coordinacion', require('./components/views/coordinacion/master.vue'));
Vue.component('maniobra-tareas', require('./components/views/maniobras/master.vue'));


Vue.prototype.$http = require('axios');

var vm = new Vue({
    el: '#app',
});



