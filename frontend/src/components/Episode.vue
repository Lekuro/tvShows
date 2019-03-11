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
    <div class="row align-items-center">
      <div class="col-auto mr-auto">
        <h2>{{ season.seasonName }}</h2>
      </div>
      <div class="col-auto">
        <router-link :to="{name: 'seasons'}">
          <a href="#" class="btn btn-outline-primary">Back to seasons</a>
        </router-link>
      </div>
    </div>
    <div v-if="!addNew" class="row align-items-center">
      <div class="col-auto mr-auto">
        <h2>{{ episode.episodeName }}</h2>
      </div>
      <div class="col-auto">
        <router-link :to="{name: 'episodes'}">
          <a href="#" class="btn btn-outline-primary">Back to episodes</a>
        </router-link>
      </div>
    </div>
    <h3 v-if="addNew">Add new episode</h3>
    <div class="card mb-3">
      <!-- ~~~~~~~~~~~~~~~~~~~~~~~~  navigation for admin ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
      <div v-if="logined && +user.isAdmin && !addNew" class="card-header">
        <button
          type="button"
          class="btn btn-outline-primary"
          @click="usersView=true; editView=false"
        >User's view</button>
        <button type="button" class="btn btn-outline-primary" @click="onEdit">Edit episode</button>
      </div>
      <div class="card-body">
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ User's view ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <div v-if="usersView && !addNew">
          <img
            v-if="episode.featuredImage"
            :src="basePathEpisode+episode.featuredImage"
            class="img-thumbnail float-left mr-3 mg-fluid"
            :alt="'image '+episode.title"
          >
          <h3 class="card-title">{{ episode.episodeName }}</h3>
          <h5 class="card-title">{{ episode.shortDescription }}</h5>
          <h6 class="alert alert-success ratings">{{ episode.ratingValue }}</h6>
          <p class="card-text">{{ episode.longDescription }}</p>
          <app-starrating v-if="logined" :episodeId="+episode.episodeId"></app-starrating>
          <div v-if="logined">
            <div v-if="episode.videoFragmentUrl" class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" :src="episode.videoFragmentUrl" allowfullscreen></iframe>
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
                    :type="item.type"
                    class="form-control mb-2"
                    :value="editData[index]"
                    @input="onInput(index, $event.target.value)"
                  >
                </div>
                <label for="sd">Short description</label>
                <textarea class="form-control mb-2" id="sd" rows="3" v-model="editData[6]"></textarea>
                <label for="ld">Long description</label>
                <textarea class="form-control mb-2" id="ld" rows="6" v-model="editData[7]"></textarea>
                <label>Poster image</label>
                <input type="file" ref="fileImage" accept="image/*">
              </div>
              <h4 v-if="resultMes && !addNew" class="alert alert-success">{{resultMes}}</h4>
              <button class="btn btn-primary" @click="sendData">Send Data</button>
            </form>
          </div>
        </keep-alive>
      </div>
    </div>
    <router-link :to="{name: 'episodes'}">
      <a class="btn btn-outline-primary my-3" href="#" role="button">Back to episodes</a>
    </router-link>
  </div>
</template>

<script>
import StarRating from "./StarRating.vue";
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      //basePathShow: "http://localhost/tvserial/images/shows/",
      //basePathSeason: "http://localhost/tvserial/images/seasons/",
      basePathEpisode: "http://localhost/tvserial/images/episodes/",
      addNew: this.$route.params.episodeName === "newepisode",
      usersView: !this.addNew,
      editView: false,
      info: [
        {
          type: "text",
          nameLabel: "Episode Name",
          pattern: /^[a-z 0-9]{1,10}/i
        },
        {
          type: "text",
          nameLabel: "Episode Number",
          pattern: /[0-9]{1,3}/
        },
        {
          type: "text",
          nameLabel: "Tv-Show Id",
          pattern: /[0-9]{1,10}/
        },
        {
          type: "text",
          nameLabel: "Season Id",
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
      editData: ["", "", "", "", "", "", "", ""],
      controls: [],
      formSubmited: false,
      episodeProp: [
        "episodeName",
        "episodeNumber",
        "tvShowId",
        "seasonId",
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
    //   this.$route.params.seasonName,
    //   this.$route.params.episodeName
    // );

    //this.$store.commit("episodes/clearMes");
    //this.$store.dispatch("seasons/loadItems", this.show.tvShowId);
    if (this.addNew) {
      this.usersView = false;
      //this.editShow = false;
      for (let i = 0; i < this.editData.length; i++) {
        this.editData[i] = i === 2 ? this.show.tvShowId : "";
      }
      this.editData[3] = this.season.seasonId;
      this.controls = [];
      for (let i = 0; i < this.info.length; i++) {
        this.controls.push({
          error: !this.info[i].pattern.test(this.editData[i]),
          activated: this.editData[i] !== ""
        });
      }
      //console.log("Episode created() this.addNew", this.addNew);
    }
  },
  components: {
    appStarrating: StarRating
  },
  computed: {
    id() {
      //console.log("Episode id() ", this.$route.params.id.replace(/_/g, " "));
      return this.$route.params.id.replace(/_/g, " ");
    },
    show() {
      // console.log(
      //   "Episode show() ",
      //   this.$store.getters["shows/item"](this.id)
      // );
      return this.$store.getters["shows/item"](this.id);
    },
    seasonName() {
      // console.log(
      //   "Episode seasonName() ",
      //   this.$route.params.seasonName.replace(/_/g, " ")
      // );
      return this.$route.params.seasonName.replace(/_/, " ");
    },
    season() {
      // console.log(
      //   "Episode season() ",
      //   this.$store.getters["seasons/item"](this.seasonName)
      // );
      return this.$store.getters["seasons/item"](this.seasonName);
    },
    episodeName() {
      // console.log(
      //   "Episode episodeName() ",
      //   this.$route.params.episodeName.replace(/_/g, " ")
      // );
      return this.$route.params.episodeName.replace(/_/g, " ");
    },
    episode() {
      // console.log(
      //   "Episode episode() ",
      //   this.$store.getters["episodes/item"](this.episodeName)
      // );
      return this.$store.getters["episodes/item"](this.episodeName);
    },
    ...mapGetters("auth", {
      logined: "logined",
      user: "items"
    }),
    ...mapGetters("episodes", {
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
      let fileToUpload = this.$refs.fileImage.files[0];
      //console.log("Episode.vue sendData() fileToUpload", fileToUpload);
      formData.append("fileImage", fileToUpload);
      let len = this.editData.length;
      for (let i = 0; i < len; i++) {
        let z = this.editData[i]
          ? this.editData[i].trim().replace(pattern, " ")
          : "";
        formData.append(`${this.episodeProp[i]}`, z);
      }
      if (this.editView) {
        formData.append(`episodeId`, +this.episode.episodeId);
        this.$store.dispatch("episodes/updateOld", formData);
      }
      if (this.addNew) {
        this.$store.dispatch("episodes/insertNew", formData);
      }
    },
    onEdit() {
      //this.$store.commit("seasons/clearMes");
      //this.addNew = false;
      this.usersView = false;
      this.editView = true;
      console.log("this.show.tvShowId", this.show.tvShowId);
      let len = this.editData.length;
      for (let i = 0; i < len; i++) {
        this.editData[i] = this.episode[`${this.episodeProp[i]}`];
      }
      this.editData[2] = this.show.tvShowId;
      this.editData[3] = this.season.seasonId;
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
