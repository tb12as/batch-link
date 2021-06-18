import { Store } from "vuex";
import axios from "../../api";

const paste = {
  namespaced: true,
  state: {
    needLoad: true,
    pastes: [],
    singlePaste: {}
  },

  mutations: {
    setPaste(state, value) {
      state.pastes = value;
    },

    setSinglePaste(state, value) {
      state.singlePaste = value;
    },

    setNeedLoad(state, value) {
      state.needLoad = value;
    },

    pushNew(state, value) {
      state.pastes.reverse();
      state.pastes.push(value);
      state.pastes.reverse();
    },

    deletePaste(state, slug) {
      let index = state.pastes.findIndex(e => e.slug == slug);
      state.pastes.splice(index, 1);
    }
  },

  actions: {
    async get({ commit, state }) {
      if (state.needLoad) {
        await axios.get("/api/paste").then(res => {
          commit("setPaste", res.data.pastes);
          commit("setNeedLoad", false);
        });
      }
    },

    async detail({ commit }, slug) {
      await axios
        .get("/api/paste/" + slug)
        .then(res => {
          commit("setSinglePaste", res.data);
        })
        .catch(err => {});
    },

    async save({ commit }, form) {
      await axios.post("/api/paste/", form).then(res => {
        commit("pushNew", res.data);
      });
    },

    async delete({ commit }, slug) {
      await axios.delete("/api/paste/" + slug).then(res => {
        commit("deletePaste", res.data.slug);
      });
    }
  }
};

export default paste;
