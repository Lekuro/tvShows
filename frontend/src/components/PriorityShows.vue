<template>
  <div>
    <h1>Priority list</h1>
    <div v-for="product in products" :key="product.id_product">
      <router-link tag="h3" :to="'/shows/' + product.id_product">
        <a>{{ product.title }}</a>
      </router-link>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  created() {
    //console.log('PriorityShows');
    //this.$store.dispatch('products/loadItems');
  },
  computed: {
    ...mapGetters("shows", {
      products: "items"
    })
  }
};
</script>

<style scoped>
</style>