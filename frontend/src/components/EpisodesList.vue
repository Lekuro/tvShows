<template>
  <div>
    <h1>{{ show.title }}</h1>
    <router-link :to="{name: 'shows'}">Back to shows</router-link>
    <hr>
    <h1>{{ season.seasonName }}</h1>
    <router-link :to="{name: 'seasons'}">Back to seasons</router-link>
    <hr>
    <div v-for="episode in episodes" :key="episode.episodeId">
      <router-link
        tag="h4"
        :to="`/shows/${$route.params.id}/season_${season.seasonNumber}/episode_${episode.episodeNumber}`"
      >
        <a>{{ episode.episodeName }}</a>
      </router-link>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  created() {
    console.log(
      "EpisodeList this.$route.params  ",
      this.$route.params.id,
      this.$route.params.seasonNum
    );
    console.log("EpisodeList this.show", this.show);
    this.$store.dispatch("episodes/loadItems", this.season.seasonId);
  },
  computed: {
    id() {
      //console.log("EpisodeList ", this.$route.params.id.replace(/_/g, " "));
      return this.$route.params.id.replace(/_/g, " ");
    },
    show() {
      return this.$store.getters["shows/item"](this.id);
    },
    seasonNum() {
      console.log("EpisodeList ", this.$route.params.seasonNum);
      return this.$route.params.seasonNum;
    },
    season() {
      return this.$store.getters["seasons/item"](this.seasonNum);
    },
    ...mapGetters("episodes", {
      episodes: "items"
    })
  }
};
</script>

<style scoped>
</style>