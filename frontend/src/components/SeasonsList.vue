<template>
  <div>
    <h2>{{ show.title }}</h2>
    <router-link :to="{name: 'shows'}">Back to shows</router-link>
    <hr>
    <div v-for="season in seasons" :key="season.seasonId">
      <router-link tag="h4" :to="`/shows/${$route.params.id}/season_${season.seasonNumber}`">
        <a>{{ season.seasonName }}</a>
      </router-link>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  created() {
    this.$store.dispatch("seasons/loadItems", this.show.tvShowId);
  },
  computed: {
    id() {
      console.log("SeasonsList ", this.$route.params.id.replace(/_/g, " "));
      return this.$route.params.id.replace(/_/g, " ");
    },
    show() {
      return this.$store.getters["shows/item"](this.id);
    },
    ...mapGetters("seasons", {
      seasons: "items"
    })
  }
};
</script>


<style scoped>
</style>