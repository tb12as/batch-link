import axios from "../../api";

const auth = {
  namespaced: true,
  state: {
    status: false,
    user: {}
  },

  mutations: {
    setUser(state, value) {
      state.user = value;
    },

    setStatus(state, value) {
      state.status = value;
    }
  },

  actions: {
    async login({ commit }, credentials) {
      await axios.post("/login", credentials).then(res => {
        commit("setStatus", true);
      });
    },

    async getUser({ commit }) {
      await axios
        .get("/user")
        .then(res => {
          commit("setUser", res.data);
          commit("setStatus", true);
        })
        .catch(err => {
          if (err.response.status === 401) {
            commit("setStatus", false);
          }
        });
    },

    async logout({ commit }) {
      await axios.post("/logout").then(res => {
        commit("setUser", {});
        commit("setStatus", false);
      });
    },

    async register({ commit, dispatch }, form) {
      await axios.post("/register", form).then(res => {
        commit("setStatus", true);

        dispatch("getUser");
      });
    }
  }
};

export default auth;
