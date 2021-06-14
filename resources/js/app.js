require("./bootstrap");

import Vue from "vue";
import VueRouter from "vue-router";

import "./navbar.js";
import router from "./router";
import store from "./store";

import App from "./components/App.vue";

Vue.use(VueRouter);

Vue.config.productionTip = false;

store.dispatch("auth/getUser");

new Vue({
  el: "#app",
  components: { App },
  router,
  store
});
