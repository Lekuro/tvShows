import Vue from "vue";

export default {
  namespaced: true,
  state: {
    items: []
  },
  getters: {
    items(state) {
      return state.items;
    },
    itemsMap(state) {
      let itemsMap = {};
      let len = state.items.length;
      for (let i = 0; i < len; i++) {
        let obj = state.items[i];
        itemsMap[obj.episodeNumber] = obj;
      }
      return itemsMap;
    },
    item: (state, getters) => id => {
      return getters.itemsMap[id];
    }
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
        params: { seasonId: payLoad },
        headers: {
          //Authorization: "Basic YWRtaW46YWRtaW4=",
          Accept: "application/json"
        }
      };
      console.log(payLoad, options);
      Vue.http
        .get("episodesfromseasonid.php", options)
        .then(response => {
          console.log(response);
          return response.json();
        })
        .then(data => {
          console.log(data);
          store.commit("loadItems", data);
        });
    }
  }
};
