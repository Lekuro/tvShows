import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import ShowsList from "./components/ShowsList";
import PriorityShows from "./components/PriorityShows";
import Login from "./components/Login";
import Registration from "./components/Registration";
import SeasonsList from "./components/SeasonsList";
import EpisodesList from "./components/EpisodesList";
import Episode from "./components/Episode";
import E404 from "./components/E404";

import { store } from "./store";

const routes = [
  {
    name: "priorityShows",
    path: "",
    //redirect: { name: "shows" }
    component: PriorityShows,
    beforeEnter(to, from, next) {
      store.dispatch("shows/loadPriority");
      next();
    }
  },
  {
    name: "shows",
    path: "/shows",
    component: ShowsList,
    beforeEnter(to, from, next) {
      store.dispatch("shows/loadItems");
      next();
    }
  },
  {
    name: "seasons",
    path: "/shows/:id",
    component: SeasonsList,
    beforeEnter(to, from, next) {
      if (to.params.id !== "newshow") {
        let showTitle = to.params.id.replace(/_/g, " ");
        //console.log("routrs.js seasons showTitle", showTitle);
        let show = store.getters["shows/item"](showTitle);
        //console.log("routrs.js seasons show", show);
        store.dispatch("seasons/loadItems", show.tvShowId);
      }
      next();
    }
  },
  {
    name: "episodes",
    path: "/shows/:id/:seasonName",
    component: EpisodesList,
    beforeEnter(to, from, next) {
      if (to.params.seasonName !== "newseason") {
        let seasonName = to.params.seasonName.replace(/_/g, " ");
        //console.log("routrs.js episodes seasonName", seasonName);
        let season = store.getters["seasons/item"](seasonName);
        //console.log("routrs.js episodes season", season);
        store.dispatch("episodes/loadItems", season.seasonId);
      }
      next();
    }
  },
  {
    name: "episode",
    path: "/shows/:id/:seasonName/:episodeName",
    component: Episode,
    beforeEnter(to, from, next) {
      store.dispatch("episodes/clearMes");
      next();
    }
  },
  {
    path: "/login",
    component: Login
  },
  {
    path: "/registration",
    component: Registration
  },
  {
    path: "*",
    component: E404
  }
];

export const router = new VueRouter({
  routes,
  mode: "history"
});
