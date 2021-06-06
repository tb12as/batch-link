import VueRouter from 'vue-router'

import Login from '../views/Login.vue';

const routes = [
    {
        name: 'login',
        path:'/login',
        component: Login
    }
]

export default new VueRouter({
    mode: 'history',
    routes: routes,
});