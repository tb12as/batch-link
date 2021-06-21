import axios from "../../api";

const auth = {
  namespaced: true,
  state: {},

  mutations: {},

  actions: {
    async delete({ state }, hash) {
      await axios.delete("/api/link/" + hash);
    }
  }
};

export default auth;
