import { get } from "lodash";
import axios from "../../api";
import router from "../../router";

const bookmarks = {
  namespaced: true,
  state: {
    bookmarks: []
  },

  mutations: {
    setBookmarks(state, value) {
      state.bookmarks = value;
    }
  },

  actions: {
    async get({ commit }) {
      await axios.get("/api/bookmarks").then(res => {
        commit("setBookmarks", res.data.data);
      });
    },

    async detach({}, paste_id) {
      await axios.delete("/api/bookmarks/" + paste_id);
    }
  }
};

export default bookmarks;
