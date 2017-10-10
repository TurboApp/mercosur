
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

require('vue2-animate/dist/vue2-animate.min.css');



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Card from './components/cards/Card.vue';
Vue.component('card', Card);
Vue.component('card-tabs', require('./components/cards/cardsTabs.vue'));
Vue.component('card-tab', require('./components/cards/cardTab.vue'));
Vue.component('card-collapse', require('./components/cards/Collapse.vue'))

Vue.component('fg-input', require('./components/form/formGroupInput.vue'));
Vue.component('tab', require('./components/uiComponents/tabs.vue'));
Vue.component('input-file', require('./components/uiComponents/inputFile.vue'));
Vue.component('todo-list', require('./components/misselanius/todolist.vue'));
Vue.component('app-pagination', require('./components/misselanius/pagination.vue'));

//trafico
import Trafico from './components/views/trafico/nuevoTrafico.vue';
import formTransporte from './components/views/trafico/forms/transporte.vue';
//import formDocumento from './components/views/trafico/forms/documentos.vue';


import addDocument from './components/views/trafico/addDocument.vue';
Vue.component('app-trafico', Trafico);
Vue.component('form-transporte', formTransporte);

Vue.component('add-document', addDocument);

Vue.component('form-documento', require('./components/views/trafico/forms/documento.vue'));


Vue.filter('formatSize', function(size) {
    if (size > 1024 * 1024 * 1024 * 1024) {
      return (size / 1024 / 1024 / 1024 / 1024).toFixed(2) + ' TB';
    } else if (size > 1024 * 1024 * 1024) {
      return (size / 1024 / 1024 / 1024).toFixed(2) + ' GB';
    } else if (size > 1024 * 1024) {
      return (size / 1024 / 1024).toFixed(2) + ' MB';
    } else if (size > 1024) {
      return (size / 1024).toFixed(2) + ' KB';
    }
    return size.toString() + ' B';
  });

  Vue.prototype.$http = require('axios');
 var vm = new Vue({
     el: '#app',
    
 });


