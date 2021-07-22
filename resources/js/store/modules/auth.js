import axios from "../../api";
import router from "../../router";

const auth = {
  namespaced: true,
  state: {
    status: false,
    isVerifiedUser: false,
    user: {}
  },

  mutations: {
    setUser(state, value) {
      state.user = value;
    },

    setStatus(state, value) {
      state.status = value;
    },

    setVerifiedUser(state, value) {
      state.isVerifiedUser = value;
    }
  },

  actions: {
    async login({ commit, dispatch, state }, credentials) {
      await axios.post("/login", credentials).then(() => {
        commit("setStatus", true);

        dispatch("getUser").then(() => {
          if (state.user.verified) {
            router.push({ name: "paste.index" });
          } else {
            router.push({ name: "verify" });
          }
        });
      });
    },

    async getUser({ commit }) {
      await axios
        .get("/api/user")
        .then(res => {
          commit("setUser", res.data);
          commit("setStatus", true);
          commit("setVerifiedUser", res.data.verified);
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
    },

    async changePassword({}, form) {
      await axios.put("user/password", form);
    },

    async resendEmail({ state, dispatch }) {
      dispatch("getUser");

      if (!state.user.verified) {
        await axios.post("/email/verification-notification");
      } else {
        router.push({ name: "paste.index" });
      }
    }
  }
};

export default auth;
