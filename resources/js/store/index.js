import Vue from "vue";
import Vuex from "vuex";
// import router from "../router";

import AuthModule from "./modules/auth";
import PasteModule from "./modules/pastes";
import LinkModule from "./modules/links";

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    isNotFound: false,
  },
  mutations: {
    setNotFound(state, value) {
      state.isNotFound = value;
    }
  },
  actions: {},
  modules: {
    auth: AuthModule,
    paste: PasteModule,
    link: LinkModule
  }
});

export default store;
