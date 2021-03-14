
import Vue from 'vue'
import App from './App.vue';
import routes from './routes/routes'
import { Plugin } from 'vue-fragment'
import { VuejsDatatableFactory } from 'vuejs-datatable';
//import axios from 'axios';

require('./bootstrap');
window.Vue = require('vue');
Vue.router = routes

Vue.use(Plugin)
Vue.use( VuejsDatatableFactory );

const app = new Vue({
    router: Vue.router,
    el: '#app',
    render: h => h(App)
});
