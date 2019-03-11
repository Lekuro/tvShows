<template>
  <div>
    <div v-if="!addNewShow" class="row align-items-center">
      <div class="col-auto mr-auto">
        <h2>{{ show.title }}</h2>
      </div>
      <div class="col-auto">
        <router-link :to="{name: 'shows'}">
          <a href="#" class="btn btn-outline-primary">Back to shows</a>
        </router-link>
      </div>
    </div>
    <h2 v-if="addNewShow">Add new show</h2>
    <div class="card mb-3">
      <!-- ~~~~~~~~~~~~~~~~~~~~~~~~  navigation for admin ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
      <div v-if="logined && +user.isAdmin && !addNewShow" class="card-header">
        <button
          type="button"
          class="btn btn-outline-primary"
          @click="usersView=true; editShow=false"
        >User's view</button>
        <button type="button" class="btn btn-outline-primary" @click="onEditShow">Edit show</button>
        <!-- <button type="button" class="btn btn-outline-primary" @click="onAddNewShow">Add new show</button> -->
      </div>
      <div class="card-body">
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ User's view ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <div v-if="usersView && !addNewShow">
          <img
            :src="basePathShow+show.posterImage"
            class="img-thumbnail float-left mr-3 mg-fluid"
            :alt="'image '+show.title"
          >
          <h3 class="card-title">{{ show.title }}</h3>
          <h5 class="card-title">{{ show.startDate }}</h5>
          <h6 class="alert alert-success ratings">{{ show.ratingValue }}</h6>
          <p class="card-text">{{ show.shortDescription }}</p>
          <p class="card-text">{{ show.longDescription }}</p>
          <app-starrating v-if="logined" :tvShowId="+show.tvShowId"></app-starrating>
          <div v-if="logined" class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" :src="show.videoFragmentUrl" allowfullscreen></iframe>
          </div>
          <h4 v-else class="alert alert-warning mt-5" role="alert">Please login to watch video</h4>
        </div>
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Edit show ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <keep-alive>
          <div v-if="editShow || addNewShow">
            <form @submit.prevent="formSubmited = true" enctype="multipart/form-data">
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
                    :value="edit[index]"
                    @input="onInput(index, $event.target.value)"
                  >
                </div>
                <label for="sd">Short description</label>
                <textarea class="form-control mb-2" id="sd" rows="3" v-model="edit[6]"></textarea>
                <label for="ld">Long description</label>
                <textarea class="form-control mb-2" id="ld" rows="6" v-model="edit[7]"></textarea>
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

    <router-link :to="{name: 'shows'}">
      <a class="btn btn-outline-primary my-3" href="#" role="button">Back to shows</a>
    </router-link>

    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~ Seasons List ~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <h2 v-if="!addNewShow">Seasons list</h2>
    <h4 v-if="isSeason && !addNew" class="alert alert-primary">{{isSeason}}</h4>
    <div v-if="!addNewShow">
      <router-link
        v-if="logined && +user.isAdmin"
        tag="a"
        :to="'/shows/'+this.$route.params.id+'/newseason'"
        exact
        class="btn btn-outline-primary"
      >Add new season</router-link>
      <router-link
        v-for="season in seasons"
        :key="season.seasonId"
        class="card-title"
        tag="h5"
        :to="`/shows/${$route.params.id}/${season.seasonName.replace(/ /g, '_')}`"
      >
        <a>
          <div class="no-gutters media my-3">
            <img
              v-if="season.featuredImage"
              :src="basePathSeason+season.featuredImage"
              class="col-3 mr-3"
              :alt="'image season'+season.seasonNumber"
            >
            <div class="col-9 media-body">
              <h5 class="mt-0">{{ season.seasonName }}</h5>
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
      //addNewShow: this.$store.getters["seasons/addNewShow"],
      basePathShow: "http://localhost/tvserial/images/shows/",
      basePathSeason: "http://localhost/tvserial/images/seasons/",
      usersView: true,
      editShow: false,
      addNewShow: this.$route.params.id === "newshow",
      info: [
        {
          type: "text",
          nameLabel: "Title",
          pattern: /^[a-z- ,&':!0-9]{1,50}/i
        },
        {
          type: "text",
          nameLabel: "Subtitle",
          pattern: /^[.\S]{1,50}/i
        },
        {
          type: "date",
          nameLabel: "Start date",
          pattern: /[0-9]{4}[-]{1}[0-9]{2}[-]{1}[0-9]{2}/
        },
        {
          type: "text",
          nameLabel: "Priority",
          pattern: /[0-9]{1}/
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
      edit: ["", "", "", "", "", "", "", ""],
      controls: [],
      formSubmited: false,
      showProp: [
        "title",
        "subtitle",
        "startDate",
        "priority",
        "videoFragmentUrl",
        "usersRating",
        "shortDescription",
        "longDescription"
      ]
    };
  },
  created() {
    //this.$store.commit("shows/clearMes");
    //this.$store.dispatch("seasons/loadItems", this.show.tvShowId);
    if (this.addNewShow) {
      this.usersView = false;
      //this.editShow = false;
      for (let i = 0; i < this.edit.length; i++) {
        this.edit[i] = "";
      }
      this.controls = [];
      for (let i = 0; i < this.info.length; i++) {
        this.controls.push({
          error: !this.info[i].pattern.test(this.edit[i]),
          activated: this.edit[i] !== ""
        });
      }
      //console.log("SeasonsList created() this.addNewShow", this.addNewShow);
    }
  },
  // beforeRouteUpdate(to, from, next) {
  //   if (to.params.id === from.params.id) {
  //     store.dispatch("shows/loadItems");
  //   }
  //   if (to.params.id !== from.params.id) {
  //     let showTitle = to.params.id.replace(/_/g, " ");
  //     console.log("routrs.js episodes showTitle", showTitle);
  //     let show = store.getters["shows/item"](showTitle);
  //     console.log("routrs.js episodes show", show);
  //     store.dispatch("seasons/loadItems", show.tvShowId);
  //   }
  // },
  components: {
    appStarrating: StarRating
  },
  computed: {
    id() {
      // console.log(
      //   "SeasonsList id() this.$route.params.id.replace",
      //   this.$route.params.id.replace(/_/g, " ")
      // );
      return this.$route.params.id.replace(/_/g, " ");
    },
    show() {
      // console.log(
      //   "SeasonsList show() this.$store.getters['shows/item'](this.id)",
      //   this.$store.getters["shows/item"](this.id)
      // );
      return this.$store.getters["shows/item"](this.id);
    },
    ...mapGetters("seasons", {
      seasons: "items",
      isSeason: "resultMes"
    }),
    ...mapGetters("auth", {
      logined: "logined",
      user: "items"
    }),
    ...mapGetters("shows", {
      resultMes: "resultMes"
    })
  },
  methods: {
    onInput(index, value) {
      let data = this.info[index];
      let control = this.controls[index];
      this.edit[index] = value;
      control.error =
        !data.pattern.test(value) || !(value.match(data.pattern)[0] === value);
      control.activated = true;
    },
    sendData() {
      const pattern = /[ ]{2,}/g;
      let formData = new FormData();
      //console.log("SeasonList.vue sendData() $refs", this.$refs);
      let fileToUpload = this.$refs.fileImage.files[0];
      //console.log("SeasonList.vue sendData() fileToUpload", fileToUpload);
      formData.append("fileImage", fileToUpload);
      for (let i = 0; i < this.edit.length; i++) {
        let z = this.edit[i] ? this.edit[i].trim().replace(pattern, " ") : "";
        formData.append(`${this.showProp[i]}`, z);
      }
      if (this.editShow) {
        formData.append(`tvShowId`, +this.show.tvShowId);
        this.$store.dispatch("shows/updateOld", formData);
      }
      if (this.addNewShow) {
        this.$store.dispatch("shows/insertNew", formData);
      }
      //console.log("SeasonList.vue sendData() fileToUpload", formData);
    },
    onEditShow() {
      //this.$store.commit("shows/clearMes");
      this.addNewShow = false;
      this.usersView = false;
      this.editShow = true;
      for (let i = 0; i < this.edit.length; i++) {
        this.edit[i] = this.show[`${this.showProp[i]}`];
      }
      this.controls = [];
      for (let i = 0; i < this.info.length; i++) {
        this.controls.push({
          error: !this.info[i].pattern.test(this.edit[i]),
          activated: this.edit[i] !== ""
        });
      }
    }
    // onAddNewShow() {
    //   this.addNewShow = true;
    //   this.usersView = false;
    //   this.editShow = false;
    //   for (let i = 0; i < this.edit.length; i++) {
    //     this.edit[i] = "";
    //   }
    //   this.controls = [];
    //   for (let i = 0; i < this.info.length; i++) {
    //     this.controls.push({
    //       error: !this.info[i].pattern.test(this.edit[i]),
    //       activated: this.edit[i] !== ""
    //     });
    //   }
    // }
  }
};
</script>
<style scoped>
img {
  max-width: 100px;
}
@media (min-width: 768px) {
  img {
    max-width: 180px;
  }
}
</style>
