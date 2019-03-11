import Vue from "vue";
export default {
  namespaced: true,
  state: {
    resultMes: false
  },
  getters: {
    resultMes(state) {
      return state.resultMes;
    }
  },
  mutations: {
    setResultMes(state, mes) {
      state.resultMes = mes;
    }
  },
  actions: {
    clearMes(store) {
      store.commit("setResultMes", false);
      //console.log("rating.js actions:clearMes()", store.state.resultMes);
    },
    sendRating(store, payload) {
      //console.log("rating.js actions:sendRating() payload", payload);
      Vue.http
        .post("rating.php", payload)
        .then(response => {
          //console.log("rating.js actions:sendRating() response", response);
          return response.json();
        })
        .then(data => {
          store.commit("setResultMes", data.resultMes);
          //console.log("rating.js actions:sendRating() data.resultMes", data.resultMes);
          setTimeout(_ => store.dispatch("clearMes"), 2000);
        });
    }
  }
};
