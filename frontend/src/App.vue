<template>
  <div>
    <header>
      <div class="container">
        <div class="row align-items-end">
          <div class="col-sm-auto mr-auto">
            <h1>TvShows</h1>
          </div>
          <div class="col-sm-auto">
            <h3 v-if="logined">
              Hello, {{user.login}}!
              <a href="#" @click="exit">Exit</a>
            </h3>
            <h3 v-else>Hello, guest!</h3>
          </div>
        </div>
        <hr>
      </div>
    </header>
    <section>
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <ul class="list-group">
              <router-link
                v-for="(item, index) in menuList"
                :key="index"
                :to="item.url"
                tag="li"
                class="list-group-item"
                active-class="active"
              >
                <a>{{ item.text }}</a>
              </router-link>
            </ul>
          </div>
          <div class="col-md-9">
            <transition name="slide" mode="out-in">
              <router-view></router-view>
            </transition>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  computed: {
    ...mapGetters("menu", {
      menuList: "items"
    }),
    ...mapGetters("auth", {
      logined: "logined",
      user: "items"
    })
  },
  methods: {
    exit() {
      let formData = new FormData();
      formData.append("login", this.user.login);
      this.$store.dispatch("auth/exit", formData);
    }
  }
};
</script>

<style>
.list-group-item a {
  display: block;
}

.list-group-item a {
  text-decoration: none;
}

.list-group-item.active a {
  color: inherit;
}

.slide-enter {
}

.slide-enter-active {
  animation: slideIn 0.5s;
}

.slide-enter-to {
}

.slide-leave {
}

.slide-leave-active {
  animation: slideOut 0.5s;
}

.slide-leave-to {
}

@keyframes slideIn {
  from {
    transform: rotateY(90deg);
  }
  to {
    transform: rotateY(0deg);
  }
}

@keyframes slideOut {
  from {
    transform: rotateY(0deg);
  }
  to {
    transform: rotateY(90deg);
  }
}

.rating label {
  font-size: 2em;
  color: #cccccc;
  float: right;
}
[type="radio"] {
  margin: 0;
  float: right;
}
.rating > input,
.rating > label:last-child,
[type="radio"]:last-child {
  opacity: 0;
}
.rating > label:hover,
.rating > label:hover ~ label,
.rating:not(:hover) > :checked ~ label {
  color: #dddd00;
}
.ratings {
  display: inline-block;
}
</style>