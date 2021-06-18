import VueRouter from "vue-router";

import Login from "../views/Login.vue";

import PasteIndex from "../views/Paste/Index.vue";
import PasteDetail from "../views/Paste/Detail.vue";
import PasteCreate from "../views/Paste/Create.vue";

const routes = [
  {
    name: "login",
    path: "/login",
    component: Login
  },
  {
    name: "paste.index",
    path: "/paste",
    component: PasteIndex
  },
  {
    name: "paste.show",
    path: "/paste/:slug/d",
    component: PasteDetail
  },

  {
    name: "paste.create",
    path: "/paste/create",
    component: PasteCreate
  }
];

export default new VueRouter({
  mode: "history",
  routes: routes
});
