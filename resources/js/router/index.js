import VueRouter from "vue-router";

import Login from "../views/Login.vue";

import PasteIndex from "../views/Paste/Index.vue";
import PasteDetail from "../views/Paste/Detail.vue";
import PasteCreate from "../views/Paste/Create.vue";
import PasteEdit from "../views/Paste/Edit.vue";

import auth from "../store/modules/auth";

const routes = [
  {
    name: "login",
    path: "/login",
    component: Login,
    meta: {
      loginPage: true
    }
  },
  {
    name: "paste.index",
    path: "/paste",
    component: PasteIndex,
    meta: {
      requiresAuth: true
    }
  },
  {
    name: "paste.show",
    path: "/paste/:slug/d",
    component: PasteDetail,
    meta: {
      requiresAuth: true
    }
  },
  {
    name: "paste.create",
    path: "/paste/create",
    component: PasteCreate,
    meta: {
      requiresAuth: true
    }
  },
  {
    name: "paste.edit",
    path: "/paste/:slug/edit",
    component: PasteEdit,
    meta: {
      requiresAuth: true
    }
  }
];

const router = new VueRouter({
  mode: "history",
  routes: routes
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!auth.state.status) {
      next({
        path: "/login",
        query: { redirect: "/paste" }
      });
    } else {
      next();
    }
  } else if (to.matched.some(record => record.meta.loginPage)) {
    if (auth.state.status) {
      next({
        path: "/paste"
      });
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router;
