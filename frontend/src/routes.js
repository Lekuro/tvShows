import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import ShowsList from "./components/ShowsList";
import Login from "./components/Login";
import Registration from "./components/Registration";
import SeasonsList from "./components/SeasonsList";
import EpisodesList from "./components/EpisodesList";
import Episode from "./components/Episode";
import E404 from "./components/E404";

import { store } from "./store";

const routes = [
  {
    //name: "priorityShows",
    path: "",
    redirect: { name: "shows" }
    //compontnt: PriorityShows
  },
  {
    name: "shows",
    path: "/shows",
    component: ShowsList,
    beforeEnter(from, to, next) {
      store.dispatch("shows/loadItems");
      next();
    }
  },
  {
    //я знаю що цей кусок можна робити дитиною попереднього але незнаю чи це необхідно чи можливо враховуючи всі ці айді
    name: "seasons",
    path: "/shows/:id",
    component: SeasonsList /*,
    beforeEnter(from, to, next) {
      store.dispatch("seasons/loadItems", from.params.id);
      next();
    }
    таким чином в мене не виходить тому що я не можу з іншого стору дістати інформацію про айді маючи назву шоу
    можливо це не потрібно і треба відсилати саме назву і номер сезону а на бекенді з цим розбиратись Підкажи!
    я звертаюсь на ти тому що нас попереджали що у вас так прийнято але без проблем можу говорити і на ви 
    просто дай знати як краще і на всяк випадок перепрошую!*/
  },
  {
    name: "episodes",
    path: "/shows/:id/season_:seasonNum",
    component: EpisodesList
  },
  {
    name: "episode",
    path: "/shows/:id/season_:seasonNum/episode_:episodeNum",
    component: Episode
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
