import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import menu from "./modules/menu";
import shows from "./modules/shows";
import seasons from "./modules/seasons";
import episodes from "./modules/episodes";
import auth from "./modules/auth";

export const store = new Vuex.Store({
  modules: {
    menu,
    shows,
    seasons,
    episodes,
    auth
  },
  strict: process.env.NODE_ENV !== "production"
});
