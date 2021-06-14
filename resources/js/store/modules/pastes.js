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
    }
  }
};

export default paste;
