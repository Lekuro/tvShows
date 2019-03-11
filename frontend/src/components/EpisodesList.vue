<template>
  <div>
    <div class="row align-items-center">
      <div class="col-auto mr-auto">
        <h2>{{ show.title }}</h2>
      </div>
      <div class="col-auto">
        <router-link :to="{name: 'shows'}">
          <a href="#" class="btn btn-outline-primary">Back to shows</a>
        </router-link>
      </div>
    </div>
    <div v-if="!addNew" class="row align-items-center">
      <div class="col-auto mr-auto">
        <h2>{{ season.seasonName }}</h2>
      </div>
      <div class="col-auto">
        <router-link :to="{name: 'seasons'}">
          <a href="#" class="btn btn-outline-primary">Back to seasons</a>
        </router-link>
      </div>
    </div>
    <h3 v-if="addNew">Add new season</h3>
    <div class="card mb-3">
      <!-- ~~~~~~~~~~~~~~~~~~~~~~~~  navigation for admin ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
      <div v-if="logined && +user.isAdmin && !addNew" class="card-header">
        <button
          type="button"
          class="btn btn-outline-primary"
          @click="usersView=true; editView=false"
        >User's view</button>
        <button type="button" class="btn btn-outline-primary" @click="onEdit">Edit season</button>
        <!-- <button type="button" class="btn btn-outline-primary" @click="onAddNewShow">Add new show</button> -->
      </div>
      <div class="card-body">
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ User's view ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <div v-if="usersView && !addNew">
          <img
            v-if="season.featuredImage"
            :src="basePathSeason+season.featuredImage"
            class="img-thumbnail float-left mr-3 mg-fluid"
            :alt="'image '+season.title"
          >
          <h3 class="card-title">{{ season.seasonName }}</h3>
          <h5 class="card-title">{{ season.shortDescription }}</h5>
          <h6 class="alert alert-success ratings">{{ season.ratingValue }}</h6>
          <p class="card-text">{{ season.longDescription }}</p>
          <app-starrating v-if="logined" :seasonId="+season.seasonId"></app-starrating>
          <div v-if="logined">
            <div v-if="season.videoFragmentUrl" class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" :src="season.videoFragmentUrl" allowfullscreen></iframe>
            </div>
          </div>
          <h4 v-else class="alert alert-warning mt-5" role="alert">Please login to watch video</h4>
        </div>
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Edit ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <keep-alive>
          <div v-if="editView || addNew">
            <form @submit.prevent="formSubmited = true">
              <div class="form-group">
                <div v-for="(item, index) in  info" :key="index">
                  <label>{{ item.nameLabel }}</label>
                  <span
                    class="fa"
                    v-if="controls[index].activated"
                    :class="controls[index].error ? 
									'fa-exclamation-circle text-danger' : 
							  		 'fa-check-circle text-success'"
                  ></span>
                  <input
                    required
                    :type="item.type"
                    class="form-control mb-2"
                    :value="editData[index]"
                    @input="onInput(index, $event.target.value)"
                  >
                </div>
                <label for="sd">Short description</label>
                <textarea class="form-control mb-2" id="sd" rows="3" v-model="editData[5]"></textarea>
                <label for="ld">Long description</label>
                <textarea class="form-control mb-2" id="ld" rows="6" v-model="editData[6]"></textarea>
                <label>Poster image</label>
                <input type="file" ref="fileImage" accept="image/*">
              </div>
              <h4 v-if="resultMes" class="alert alert-success">{{resultMes}}</h4>
              <button class="btn btn-primary" @click="sendData">Send Data</button>
            </form>
          </div>
        </keep-alive>
      </div>
    </div>

    <router-link :to="{name: 'seasons'}">
      <a class="btn btn-outline-primary my-3" href="#" role="button">Back to seasons</a>
    </router-link>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~ Episodes List ~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <h3 v-if="!addNew">Episodes list</h3>
    <h4 v-if="isEpisode && !addNew" class="alert alert-primary">{{isEpisode}}</h4>
    <div v-if="!addNew">
      <router-link
        v-if="logined && +user.isAdmin"
        tag="a"
        :to="'/shows/'+this.$route.params.id+'/'+this.$route.params.seasonName+'/newepisode'"
        exact
        class="btn btn-outline-primary"
      >Add new episode</router-link>
      <router-link
        v-for="episode in episodes"
        :key="episode.episodeId"
        class="card-title"
        tag="h4"
        :to="`/shows/${$route.params.id}/${$route.params.seasonName}/${episode.episodeName.replace(/ /g, '_')}`"
      >
        <a>
          <div class="no-gutters media my-3">
            <img
              v-if="episode.featuredImage"
              :src="basePathEpisode+episode.featuredImage"
              class="col-3 mr-3"
              :alt="'image episode'+episode.episodeNumber"
            >
            <div class="col-9 media-body">
              <h6>Episode {{ episode.episodeNumber }}</h6>
              <h5 class="mt-0">{{ episode.episodeName }}</h5>
              <h6 class="alert alert-success ratings">{{ episode.ratingValue }}</h6>
              <!-- <h6>{{ episode.shortDescription }}</h6> -->
            </div>
          </div>
        </a>
      </router-link>
    </div>
  </div>
</template>

<script>
import StarRating from "./StarRating.vue";
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      basePathShow: "http://localhost/tvserial/images/shows/",
      basePathSeason: "http://localhost/tvserial/images/seasons/",
      basePathEpisode: "http://localhost/tvserial/images/episodes/",
      addNew: this.$route.params.seasonName === "newseason",
      usersView: !this.addNew,
      editView: false,
      info: [
        {
          type: "text",
          nameLabel: "Season Name",
          pattern: /^[a-z 0-9]{1,10}/i
        },
        {
          type: "text",
          nameLabel: "Season Number",
          pattern: /[0-9]{1,3}/
        },
        {
          type: "text",
          nameLabel: "Tv-Show Id",
          pattern: /[0-9]{1,10}/
        },
        {
          type: "text",
          nameLabel: "Video fragment url",
          pattern: /[a-z._:\/0-9]{3,255}/i
        },
        {
          type: "text",
          nameLabel: "Users rating",
          pattern: /[0-9]{1,2}/
        }
      ],
      editData: ["", "", "", "", "", "", ""],
      controls: [],
      formSubmited: false,
      seasonProp: [
        "seasonName",
        "seasonNumber",
        "tvShowId",
        "videoFragmentUrl",
        "usersRating",
        "shortDescription",
        "longDescription"
      ]
    };
  },
  created() {
    // console.log(
    //   "EpisodeList created() this.$route.params  ",
    //   this.$route.params.id,
    //   this.$route.params.seasonName
    // );
    //this.$store.dispatch("episodes/loadItems", this.season.seasonId);

    //this.$store.commit("seasons/clearMes");
    //this.$store.dispatch("seasons/loadItems", this.show.tvShowId);
    if (this.addNew) {
      this.usersView = false;
      //this.editShow = false;
      for (let i = 0; i < this.editData.length; i++) {
        this.editData[i] = i === 2 ? this.show.tvShowId : "";
      }
      this.controls = [];
      for (let i = 0; i < this.info.length; i++) {
        this.controls.push({
          error: !this.info[i].pattern.test(this.editData[i]),
          activated: this.editData[i] !== ""
        });
      }
      //console.log("EpisodeList created() this.addNew", this.addNew);
    }
  },
  components: {
    appStarrating: StarRating
  },
  computed: {
    id() {
      return this.$route.params.id.replace(/_/g, " ");
    },
    show() {
      return this.$store.getters["shows/item"](this.id);
    },
    seasonName() {
      // console.log(
      //   "EpisodeList seasonName() ",
      //   this.$route.params.seasonName.replace(/_/g, " ")
      // );
      return this.$route.params.seasonName.replace(/_/, " ");
    },
    season() {
      // console.log(
      //   "EpisodeList season() ",
      //   this.$store.getters["seasons/item"](this.seasonName)
      // );
      return this.$store.getters["seasons/item"](this.seasonName);
    },
    ...mapGetters("episodes", {
      episodes: "items",
      isEpisode: "resultMes"
    }),
    ...mapGetters("auth", {
      logined: "logined",
      user: "items"
    }),
    ...mapGetters("seasons", {
      resultMes: "resultMes"
    })
  },
  methods: {
    onInput(index, value) {
      let data = this.info[index];
      let control = this.controls[index];
      this.editData[index] = value;
      control.error =
        !data.pattern.test(value) || !(value.match(data.pattern)[0] === value);
      control.activated = true;
    },
    sendData() {
      const pattern = /[ ]{2,}/g;
      let formData = new FormData();
      //console.log("EpisodeList.vue sendData() $refs", this.$refs);
      let fileToUpload = this.$refs.fileImage.files[0];
      //console.log("EpisodeList.vue sendData() fileToUpload", fileToUpload);
      formData.append("fileImage", fileToUpload);
      let len = this.editData.length;
      for (let i = 0; i < len; i++) {
        let z = this.editData[i]
          ? this.editData[i].trim().replace(pattern, " ")
          : "";
        formData.append(`${this.seasonProp[i]}`, z);
      }
      if (this.editView) {
        formData.append(`seasonId`, +this.season.seasonId);
        this.$store.dispatch("seasons/updateOld", formData);
      }
      if (this.addNew) {
        this.$store.dispatch("seasons/insertNew", formData);
      }
      //console.log("EpisodeList.vue sendData() formData", formData);
    },
    onEdit() {
      //this.$store.commit("seasons/clearMes");
      //this.addNew = false;
      this.usersView = false;
      this.editView = true;
      let len = this.editData.length;
      for (let i = 0; i < len; i++) {
        this.editData[i] =
          i === 2 ? this.show.tvShowId : this.season[`${this.seasonProp[i]}`];
      }
      this.controls = [];
      len = this.info.length;
      for (let i = 0; i < len; i++) {
        this.controls.push({
          error: !this.info[i].pattern.test(this.editData[i]),
          activated: this.editData[i] !== ""
        });
      }
    }
  }
};
</script>
<style scoped>
h4 a {
  text-decoration: none;
  color: #000000;
}
</style>
