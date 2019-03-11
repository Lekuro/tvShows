import Vue from "vue";

export default {
  namespaced: true,
  state: {
    items: [],
    resultMes: false
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
        itemsMap[obj.title] = obj;
      }
      return itemsMap;
    },
    item: (state, getters) => id => {
      return getters.itemsMap[id];
    },
    resultMes(state) {
      return state.resultMes;
    }
  },
  mutations: {
    clearItems(state) {
      state.items = [];
    },
    loadItems(state, data) {
      state.items = data;
    },
    setResultMes(state, mes) {
      state.resultMes = mes.resultMes;
    },
    clearMes(state) {
      state.resultMes = false;
    }
  },
  actions: {
    loadItems(store) {
      store.commit("clearItems");
      store.commit("clearMes");

      Vue.http
        .get("alltvshowtitlesort.php")
        .then(response => response.json())
        .then(data => {
          store.commit("loadItems", data);
          //console.log("shows.js actions:loadItems() data", data);
        });
    },
    insertNew(store, payload) {
      store.commit("clearMes");
      //console.log("shows.js insertNew() payload", payload);
      Vue.http
        .post("insertShow.php", payload)
        .then(response => {
          //console.log("auth.js actions:insertNew() response", response);
          return response.json();
        })
        .then(data => {
          //console.log("shows.js actions:insertNew() data", data);
        });
    },
    updateOld(store, payload) {
      store.commit("clearMes");
      //console.log("shows.js updateOld() payload", payload);
      Vue.http
        .post("updateShow.php", payload)
        .then(response => {
          //console.log("auth.js actions:updateShow() response", response);
          return response.json();
        })
        .then(data => {
          store.commit("setResultMes", data);
          //console.log("shows.js actions:updateOld() data", data);
        });
    },
    loadPriority(store) {
      store.commit("clearItems");
      store.commit("clearMes");

      Vue.http
        .get("alltvshowprioritysort.php")
        .then(response => response.json())
        .then(data => {
          store.commit("loadItems", data);
          //console.log("shows.js actions:loadItems() data", data);
        });
    }
  }
};
