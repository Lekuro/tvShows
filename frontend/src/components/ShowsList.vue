<template>
  <div>
    <h1>Show's list</h1>
    <div v-for="show in shows" :key="show.tvShowId">
      <router-link tag="h3" :to="'/shows/' + show.title.replace(/ /g, '_')">
        <a>{{ show.title }}</a>
      </router-link>
      <div>{{ show.price }}</div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  created() {
    //console.log('ShowsList');
    //this.$store.dispatch('products/loadItems');
  },
  computed: {
    ...mapGetters("shows", {
      shows: "items"
    })
  }
};
</script>

<style scoped>
</style>