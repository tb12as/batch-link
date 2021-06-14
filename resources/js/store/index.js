import Vue from "vue";
import Vuex from "vuex";
// import router from "../router";

import AuthModule from "./modules/auth";

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {},
  mutations: {},
  actions: {},
  modules: {
    auth: AuthModule
  }
});

export default store;
