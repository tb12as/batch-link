import { Store } from "vuex";
import axios from "../../api";

const paste = {
  namespaced: true,
  state: {
    needLoad: true,
    pastes: [],
    singlePaste: {},
    pageNow: null
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
      state.pastes.data.reverse();
      state.pastes.data.push(value);
      state.pastes.data.reverse();
    },

    deletePaste(state, slug) {
      let index = state.pastes.data.findIndex(e => e.slug == slug);
      state.pastes.data.splice(index, 1);
    },

    setPageNow(state, value) {
      state.pageNow = value;
    }
  },

  actions: {
    async get({ commit, state }) {
      if (state.needLoad) {
        await axios.get("/api/paste").then(res => {
          commit("setPaste", res.data);
          commit("setNeedLoad", false);
        });
      }
    },

    async paginateOnChange({ commit }, url) {
      if (url) {
        const page = url.split("?")[1];
        await axios.get("/api/paste?" + page).then(res => {
          commit("setPaste", res.data);
          commit("setPageNow", page);
        });
      }
    },

    async detail({ commit }, slug) {
      await axios.get("/api/paste/" + slug).then(res => {
        commit("setSinglePaste", res.data);
      });
    },

    async save({ commit }, form) {
      await axios.post("/api/paste/", form).then(res => {
        commit("pushNew", res.data);
      });
    },

    async getUpdateData({ commit }, slug) {
      await axios.get(`/api/paste/${slug}?action=update`).then(res => {
        commit("setSinglePaste", res.data);
      });
    },

    async update({ commit }, form) {
      await axios.patch("/api/paste/" + form.slug, form).then(res => {
        commit("setNeedLoad", true);
      });
    },

    async delete({ dispatch, state, commit }, slug) {
      commit("setNeedLoad", true);

      await axios.delete("/api/paste/" + slug).then(() => {
        if (!state.pageNow || (state.pageNow && state.pastes.data.length < 2)) {
          dispatch("get");
          commit("setPageNow", null);
        } else {
          dispatch("paginateOnChange", `t?${state.pageNow}`);
        }
      });
    }
  }
};

export default paste;
