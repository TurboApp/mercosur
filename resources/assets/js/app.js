
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Card from './components/cards/Card.vue';
Vue.component('card', Card);

Vue.component('fg-input', require('./components/form/formGroupInput.vue'));
Vue.component('todo-list', require('./components/misselanius/todolist.vue'));
Vue.component('app-pagination', require('./components/misselanius/pagination.vue'));

 const app = new Vue({
     el: '#app',

 });
