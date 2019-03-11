import Vue from "vue";
import { router } from "../../routes.js";

export default {
  namespaced: true,
  state: {
    items: { login: String, isAdmin: Boolean, tvSerialUserId: Number },
    logined: false,
    errorReg: ""
  },
  getters: {
    items(state) {
      return state.items[0];
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
    },
    errorReg(state) {
      return state.errorReg;
    },
    logined(state) {
      return state.logined;
    }
  },
  mutations: {
    clearItems(state) {
      state.items = {};
    },
    loadItems(state, data) {
      state.items = data;
      //console.log("auth.js mutations:loadItems() state.items", state.items);
    },
    loadError(state, data) {
      state.errorReg = data;
    },
    unError(state) {
      state.errorReg = "";
    },
    logined(state) {
      state.logined = true;
    },
    unLogined(state) {
      state.logined = false;
    }
  },
  actions: {
    /** logins user */
    loadItems(store, payload) {
      store.commit("clearItems");
      //console.log("auth.js actions:loadItems() payload", payload);
      /*Vue.http
        .post("login.php", payload, {
          headers: {
            Accept: "application/json",
            "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8"
          }
        })
        .then(response => {
          console.log("auth.js actions:loadItems() response", response);
          return response.json();
        })
        .then(data => {
          console.log("auth.js actions:loadItems() data", data);
          //console.log("auth.js actions:loadItems() data", { isAdmin: !!+data[0].isAdmin, login: data[0]["login"] });
          if (!data.errorMes) {
            store.commit("loadItems", data);
            store.commit("unError");
            store.commit("logined");
            router.push("/");
          } else {
            store.commit("loadError", data.errorMes);
            store.commit("unLogined");
            router.push("/login");
          }
        });*/
      Vue.http
        .post("login.php", payload)
        .then(response => {
          //console.log("auth.js actions:loadItems() response", response);
          return response.json();
        })
        .then(data => {
          //console.log("auth.js actions:loadItems() data", data);
          //console.log("auth.js actions:loadItems() data", { isAdmin: !!+data[0].isAdmin, login: data[0]["login"] });
          if (!data.errorMes) {
            store.commit("loadItems", data);
            store.commit("unError");
            store.commit("logined");
            router.push("/");
          } else {
            store.commit("loadError", data.errorMes);
            store.commit("unLogined");
            router.push("/login");
          }
        });
      // .catch(error => {
      //   console.log("auth.js actions:loadItems() error", error);
      // });
    },
    /** registration user */
    sendItems(store, payload) {
      store.commit("clearItems");
      store.commit("unLogined");
      //console.log("auth.js actions:sendItems() payload", payload);
      Vue.http
        .post("registration.php", payload)
        .then(response => {
          //console.log("auth.js actions:sendItems() response", response);
          return response.json();
        })
        .then(data => {
          //console.log("auth.js actions:sendItems() data", data);
          if (!data.errorMes) {
            store.commit("loadItems", data);
            store.commit("logined");
            router.push("/");
          } else {
            store.commit("loadError", data.errorMes);
            store.commit("unLogined");
            router.push("/registration");
          }
        })
        .catch(error => {
          //console.log("auth.js actions:sendItems() error", error);
        });
    },
    /** exit from user's session */
    exit(store, payload) {
      Vue.http
        .post("logout.php", payload)
        .then(response => {
          //console.log("auth.js actions:exit() respons", response);
          return response.json();
        })
        .then(data => {
          //console.log("auth.js actions:exit() data", data);
          if (!data.errorMes) {
            store.commit("clearItems");
            store.commit("unLogined");
            router.push("/");
          } else {
            store.commit("loadError", data.errorMes);
          }
        });
      // .catch(error => {
      //   console.log("auth.js actions:exit() error", error);
      // });
    }
  }
};
