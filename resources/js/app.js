require('./bootstrap');

import './navbar.js';
import router from './router';

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);
Vue.config.productionTip = false;

import App from './components/App.vue'

new Vue({
    el: '#app',
    components: { App },
    router
});
