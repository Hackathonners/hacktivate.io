import GlobalEvents from 'vue-global-events'
import vClickOutside from 'v-click-outside'

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

Vue.use(vClickOutside);
Vue.component(GlobalEvents);
Vue.component('searchable-input', require('./components/SearchableInput.vue'));
Vue.component('team-members', require('./components/TeamMembers.vue'));

const app = new Vue({
    el: '#app'
});

/**
 * Include Landing Page scripts
 */
require('./landing');
