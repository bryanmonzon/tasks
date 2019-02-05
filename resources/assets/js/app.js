import user from './mixins/user'
import pluralize from './mixins/pluralize'

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./forms/bootstrap');

window.Vue = require('vue');
window.Bus = new Vue()


require('./filters')
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('tasks-component', require('./components/TasksComponent.vue'));

Vue.mixin(user)
Vue.mixin(pluralize)

const app = new Vue({
    el: '#app'
});
