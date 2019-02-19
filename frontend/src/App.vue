<template>
  <div>
    <header>
      <h1>Site with shows</h1>
    </header>
    <section>
      <ul>
        <router-link
          v-for="(item, index) in menuList"
          :key="index"
          :to="item.url"
          tag="li"
          active-class="active"
        >
          <a>{{ item.text }}</a>
        </router-link>
      </ul>
      <hr>
      <router-view></router-view>
    </section>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  computed: {
    ...mapGetters("menu", {
      menuList: "items"
    })
  }
};
</script>

<style>
</style>