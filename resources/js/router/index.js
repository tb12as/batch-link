import VueRouter from 'vue-router'

import Login from '../views/Login.vue';

import PasteIndex from '../views/Paste/Index.vue';
import PasteDetail from '../views/Paste/Detail.vue';

const routes = [
    {
        name: 'login',
        path:'/login',
        component: Login
    },
    {
        name: 'paste.index',
        path:'/home',
        component: PasteIndex
    },
    {
        name: 'paste.show',
        path:'/paste/:slug',
        component: PasteDetail
    }
]

export default new VueRouter({
    mode: 'history',
    routes: routes,
});