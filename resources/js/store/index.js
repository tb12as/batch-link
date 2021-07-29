import Vue from "vue";
import Vuex from "vuex";
// import router from "../router";

import AuthModule from "./modules/auth";
import PasteModule from "./modules/pastes";
import LinkModule from "./modules/links";
import BookmarkModule from "./modules/bookmark";

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    isNotFound: false,
    pasteNotFound: false,
    appUrl: process.env.MIX_BASE_URL,
  },
  mutations: {
    setNotFound(state, value) {
      state.isNotFound = value;
    },
    
    setPasteNotFound(state, value) {
      state.pasteNotFound = value;
    }
  },
  actions: {},
  modules: {
    auth: AuthModule,
    paste: PasteModule,
    link: LinkModule,
    bookmark: BookmarkModule,
  }
});

export default store;
