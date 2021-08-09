import VueRouter from "vue-router";

import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import Verify from "../views/VerifyEmail.vue";

import NotFound from "../views/NotFound.vue";

import PasteIndex from "../views/Paste/Index.vue";
import PasteDetail from "../views/Paste/Detail.vue";
import PasteCreate from "../views/Paste/Create.vue";
import PasteEdit from "../views/Paste/Edit.vue";

import ChangePassword from "../views/ChangePassword.vue";
import Bookmarks from "../views/Bookmark.vue";

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
    name: "verify",
    path: "/email-verification",
    component: Verify,
    meta: {
      requiresAuth: true,
      mustVerified: false
    }
  },
  {
    name: "paste.index",
    path: "/my-batch",
    component: PasteIndex,
    meta: {
      requiresAuth: true,
      mustVerified: true
    }
  },
  {
    name: "paste.show",
    path: "/my-batch/:slug/d",
    component: PasteDetail,
    meta: {
      requiresAuth: true,
      mustVerified: true
    }
  },
  {
    name: "paste.create",
    path: "/my-batch/create",
    component: PasteCreate,
    meta: {
      requiresAuth: true,
      mustVerified: true
    }
  },
  {
    name: "paste.edit",
    path: "/my-batch/:slug/edit",
    component: PasteEdit,
    meta: {
      requiresAuth: true,
      mustVerified: true
    }
  },
  {
    name: "bookmark",
    path: "/bookmarks",
    component: Bookmarks,
    meta: {
      requiresAuth: true,
      mustVerified: true
    }
  },
  {
    name: "change.password",
    path: "/change-password",
    component: ChangePassword,
    meta: {
      requiresAuth: true,
      mustVerified: true
    }
  }
];

const router = new VueRouter({
  // linkActiveClass: 'is-active',
  linkExactActiveClass: "is-active",
  mode: "history",
  routes: routes
});

router.beforeEach((to, from, next) => {
  const requireAuthAndVerified = to.matched.some(
    record => record.meta.requiresAuth && record.meta.mustVerified
  );
  const isNotVerifiedUserPage = to.matched.some(
    record => !record.meta.mustVerified
  );
  const isGuestPage = to.matched.some(record => record.meta.loginPage);

  if (requireAuthAndVerified) {
    if (!auth.state.status) {
      next({
        path: "/login"
      });
    } else if (!auth.state.isVerifiedUser) {
      if (to.name == "verify") {
        next();
      } else {
        next({
          name: "verify"
        });
      }
    } else {
      next();
    }
  } else if (isGuestPage) {
    auth.state.status ? next({ name: "paste.index" }) : next();
  } else if (isNotVerifiedUserPage) {
    if (auth.state.status && auth.state.isVerifiedUser) {
      next({ name: "paste.index" });
    } else if (!auth.state.status) {
      next({ name: "login" });
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router;
