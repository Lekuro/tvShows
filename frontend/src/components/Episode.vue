<template>
  <div>
    <h2>{{ show.title }}</h2>
    <router-link :to="{name: 'shows'}">Back to shows</router-link>
    <hr>
    <h3>{{ season.seasonName }}</h3>
    <router-link :to="{name: 'seasons'}">Back to seasons</router-link>
    <hr>
    <h3>{{ episode.episodeName }}</h3>
    <router-link :to="{name: 'episodes'}">Back to episodes</router-link>
    <hr>
    <iframe
      width="100%"
      height="100%"
      :src="episode.videoFragmentUrl"
      frameborder="0"
      allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
      allowfullscreen
    ></iframe>
  </div>
</template>

<script>
//незнаю чи тут треба інформацію про шов і сезон в штмл виводити ?

import { mapGetters } from "vuex";
export default {
  computed: {
    id() {
      //console.log(this.$route.params.id.replace(/_/g, " "));:src="episode.videoFragmentUrl"
      return this.$route.params.id.replace(/_/g, " ");
    },
    show() {
      return this.$store.getters["shows/item"](this.id);
    },
    seasonNum() {
      console.log(
        "Episode this.$route.params.seasonNum ",
        this.$route.params.seasonNum
      );
      return this.$route.params.seasonNum;
    },
    season() {
      return this.$store.getters["seasons/item"](this.seasonNum);
    },
    episodeNum() {
      console.log(
        "Episode this.$route.params.episodeNum ",
        this.$route.params.episodeNum
      );
      return this.$route.params.episodeNum;
    },
    episode() {
      console.log(
        this.$store.getters["episodes/item"](this.episodeNum).videoFragmentUrl
      );
      return this.$store.getters["episodes/item"](this.episodeNum);
    }
  }
};
</script>

<style scoped>
</style>
