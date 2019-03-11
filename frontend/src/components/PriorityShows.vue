<template>
  <div>
    <h2>The best show</h2>
    <div class="row">
      <router-link
        v-if="logined && +user.isAdmin"
        tag="a"
        to="/shows/newshow"
        exact
        class="btn btn-outline-primary"
      >Add new show</router-link>
      <div class="col-12" v-for="show in shows" :key="show.tvShowId">
        <router-link tag="h3" :to="'/shows/' + show.title.replace(/ /g, '_')">
          <a>
            <div class="media my-2">
              <img :src="basePath+show.posterImage" class="mr-3" :alt="'image '+show.title">
              <div class="media-body">
                <h4 class="mt-0">{{ show.title }}</h4>
                <h5>{{ show.startDate }}</h5>
                <h6 class="alert alert-success ratings">{{ show.ratingValue }}</h6>
              </div>
            </div>
          </a>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      basePath: "http://localhost/tvserial/images/shows/"
    };
  },
  created() {
    //console.log("PriorityShows");
  },
  computed: {
    ...mapGetters("shows", {
      shows: "items"
    }),
    ...mapGetters("auth", {
      logined: "logined",
      user: "items"
    })
  }
};
</script>

<style scoped>
.row {
  padding-left: 15px;
}
img {
  width: 80px;
}
a {
  text-decoration: none;
  color: #000000;
}
</style>