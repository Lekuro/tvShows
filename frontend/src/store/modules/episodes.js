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
        itemsMap[obj.episodeName] = obj;
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
      state.resultMes = mes;
    },
    clearMes(state) {
      state.resultMes = false;
    }
  },
  actions: {
    clearMes(store) {
      store.commit("clearMes");
    },
    loadItems(store, payLoad) {
      store.commit("clearItems");
      store.commit("clearMes");
      const options = {
        params: { seasonId: payLoad },
        headers: {
          //Authorization: "Basic YWRtaW46YWRtaW4=",
          Accept: "application/json"
        }
      };
      //console.log("episodes.js actions:loadItems() payLoad, options", payLoad, options);
      Vue.http
        .get("episodesfromseasonid.php", options)
        .then(response => {
          //console.log("episodes.js actions:loadItems() response", response);
          return response.json();
        })
        .then(data => {
          if (data.resultMes) {
            store.commit("setResultMes", data.resultMes);
            //console.log("season.js actions:loadItems() data.resultMes", data.resultMes);
          } else {
            //console.log("episodes.js actions:loadItems() data", data);
            store.commit("loadItems", data);
          }
        });
    },
    insertNew(store, payload) {
      store.commit("clearMes");
      //console.log("episodes.js actions:insertNew() payload", payload);
      Vue.http
        .post("insertEpisode.php", payload)
        .then(response => {
          //console.log("episodes.js actions:insertNew() response", response);
          return response.json();
        })
        .then(data => {
          store.commit("setResultMes", data.resultMes);
          //console.log("episodes.js actions:insertNew() data.resultMes", data.resultMes);
        });
    },
    updateOld(store, payload) {
      store.commit("clearMes");
      //console.log("episodes.js updateOld() payload", payload);
      Vue.http
        .post("updateEpisode.php", payload)
        .then(response => {
          //console.log("season.js actions:updateShow() response", response);
          return response.json();
        })
        .then(data => {
          store.commit("setResultMes", data.resultMes);
          //console.log("episodes.js actions:updateOld() data.resultMes", data.resultMes);
        });
    }
  }
};
