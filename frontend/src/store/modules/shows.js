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
        itemsMap[obj.title] = obj;
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
    loadItems(store) {
      store.commit("clearItems");

      Vue.http
        .get("alltvshowtitlesort.php")
        .then(response => response.json())
        .then(data => {
          store.commit("loadItems", data);
        });
    }
    //в мене кожен файл php віддає якусь одну таблицю їх треба всталяти одну в іншу чи так може бути
  }
};
