import Vue from "vue";

export default {
  namespaced: true,
  state: {
    items: []
  },
  mutations: {
    clearItems(state) {
      state.items = [];
    },
    loadItems(state, data) {
      state.items = data;
      console.log(data);
    }
  },
  actions: {
    loadItems(store, payLoad) {
      store.commit("clearItems");
      const options = {
        headers: {
          //"X-CSRF-TOKEN": `${payLoad.password}`,
          Authorization: `${payLoad.login} ${payLoad.password}`,
          Accept: "application/json"
        }
      };
      //console.log(payLoad, options);
      Vue.http
        .post("login.php", payLoad, options)
        .then(response => {
          console.log(response);
          return response.json();
        })
        .then(data => {
          console.log(data);
          store.commit("loadItems", data);
        });
    }
    //GET
    /*loadItems(store, payLoad) {
      store.commit("clearItems");
      const options = {
        params: payLoad,
        headers: {
          //"X-CSRF-TOKEN": `${payLoad.password}`,
          Authorization: `${payLoad.login} ${payLoad.password}`,
          Accept: "application/json"
        }
      };
      console.log(payLoad, options);
      Vue.http
        .get("login.php", options)
        .then(response => {
          console.log(response);
          return response.json();
        })
        .then(data => {
          console.log(data);
          store.commit("loadItems", data);
        });
    }*/
  }
};
