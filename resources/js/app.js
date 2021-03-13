
import Vue from 'vue'
import App from './App.vue';
import routes from './router/router'
import axios from 'axios';

require('./bootstrap');

window.Vue = require('vue');

Vue.router = routes

const app = new Vue({
    router: Vue.router,
    el: '#app',
    render: h => h(App)
});
