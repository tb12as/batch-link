import VueRouter from "vue-router";

import Login from "../views/Login.vue";
import Register from "../views/Register.vue";

import NotFound from "../views/NotFound.vue";

import PasteIndex from "../views/Paste/Index.vue";
import PasteDetail from "../views/Paste/Detail.vue";
import PasteCreate from "../views/Paste/Create.vue";
import PasteEdit from "../views/Paste/Edit.vue";

import ChangePassword from "../views/ChangePassword.vue";

import auth from "../store/modules/auth";

const routes = [
  {
    path: "*",
    component: NotFound,
    name: "not.found"
  },
  {
    name: "login",
    path: "/login",
    component: Login,
    meta: {
      loginPage: true
    }
  },
  {
    name: "register",
    path: "/sign-up",
    component: Register,
    meta: {
      loginPage: true
    }
  },
  {
    name: "paste.index",
    path: "/my-batch",
    component: PasteIndex,
    meta: {
      requiresAuth: true
    }
  },
  {
    name: "paste.show",
    path: "/my-batch/:slug/d",
    component: PasteDetail,
    meta: {
      requiresAuth: true
    }
  },
  {
    name: "paste.create",
    path: "/my-batch/create",
    component: PasteCreate,
    meta: {
      requiresAuth: true
    }
  },
  {
    name: "paste.edit",
    path: "/my-batch/:slug/edit",
    component: PasteEdit,
    meta: {
      requiresAuth: true
    }
  },
  {
    name: "change.password",
    path: "/change-password",
    component: ChangePassword,
    meta: {
      requiresAuth: true
    }
  },
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
        path: "/login"
      });
    } else {
      next();
    }
  } else if (to.matched.some(record => record.meta.loginPage)) {
    if (auth.state.status) {
      next({
        name: "paste.index"
      });
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router;
