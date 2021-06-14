import VueRouter from 'vue-router'

import Login from '../views/Login.vue';
import Paste from '../views/Paste/Index.vue';

const routes = [
    {
        name: 'login',
        path:'/login',
        component: Login
    },
    {
        name: 'paste.index',
        path:'/home',
        component: Paste
    }
]

export default new VueRouter({
    mode: 'history',
    routes: routes,
});