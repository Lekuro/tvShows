<template>
  <div>
    <div class="row align-items-center">
      <div class="col-auto mr-auto">
        <h2 class="alert alert-danger" role="alert">404 Page not found</h2>
      </div>
      <div class="col-auto">
        <router-link v-if="logined" :to="{name: 'shows'}">
          <a href="#" class="btn btn-outline-primary">Start from main page</a>
        </router-link>
        <router-link v-else :to="{name: 'priorityShows'}">
          <a href="#" class="btn btn-outline-primary">Start from main page</a>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters("auth", {
      logined: "logined",
      user: "items"
    })
  }
};
</script>
<style scoped>
</style>
