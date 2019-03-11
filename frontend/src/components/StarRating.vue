<template>
  <div>
    <div class="rating">
      <input id="star5" type="radio" name="starrating" value="5" @click="sendRating($event)">
      <label for="star5">&#9733;</label>
      <input id="star4" type="radio" name="starrating" value="4" @click="sendRating($event)">
      <label for="star4">&#9733;</label>
      <input id="star3" type="radio" name="starrating" value="3" @click="sendRating($event)">
      <label for="star3">&#9733;</label>
      <input id="star2" type="radio" name="starrating" value="2" @click="sendRating($event)">
      <label for="star2">&#9733;</label>
      <input id="star1" type="radio" name="starrating" value="1" @click="sendRating($event)">
      <label for="star1">&#9733;</label>
      <input id="star0" type="radio" name="starrating" value="0" @click="sendRating($event)">
      <label for="star0">&#9733;</label>
    </div>
    <h5 v-if="resultMes" class="alert alert-primary">{{resultMes}}</h5>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  props: {
    tvShowId: { type: Number, default: null },
    seasonId: { type: Number, default: null },
    episodeId: { type: Number, default: null }
  },
  computed: {
    ...mapGetters("rating", {
      resultMes: "resultMes"
    })
  },
  methods: {
    sendRating(e) {
      let formData = new FormData();
      formData.append("ratingValue", +e.target.value);
      if (this.tvShowId) {
        formData.append("tvShowId", this.tvShowId);
        this.$store.dispatch("rating/sendRating", formData);
      }
      if (this.seasonId) {
        formData.append("seasonId", this.seasonId);
        this.$store.dispatch("rating/sendRating", formData);
      }
      if (this.episodeId) {
        formData.append("episodeId", this.episodeId);
        this.$store.dispatch("rating/sendRating", formData);
      }
      setTimeout(_ => this.$store.dispatch("rating/clearMes"), 3000);
    }
  }
};
</script>
<style scoped>
</style>
