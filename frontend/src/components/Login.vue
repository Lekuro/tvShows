<template>
  <div class="wrapper">
    <form @submit.prevent="formSubmited=true">
      <h4 v-if="errorReg">{{errorReg}}</h4>
      <div>
        <div class="form-group" v-for="(item, index) in  info" :key="index">
          <label>{{ item.name }}</label>
          <span
            class="fa"
            v-if="controls[index].activated"
            :class="controls[index].error ? 
									'fa-exclamation-circle text-danger' : 
							  		 'fa-check-circle text-success'"
          ></span>
          <input
            :type="item.type"
            class="form-control"
            :value="item.value"
            @input="onInput(index, $event.target.value)"
          >
        </div>
      </div>
      <button class="btn btn-primary" :disabled="done < info.length" @click="login">Send Data</button>
    </form>
  </div>
</template>
   
<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      info: [
        {
          type: "text",
          name: "login",
          value: "",
          pattern: /^[a-z0-9_-]{2,30}$/i
        },
        {
          type: "password",
          name: "password",
          value: "",
          pattern: /[^.\s]{5,15}$/
        }
      ],
      controls: [],
      formSubmited: false
    };
  },
  created() {
    for (let i = 0; i < this.info.length; i++) {
      this.controls.push({
        error: !this.info[i].pattern.test(this.info[i].value),
        activated: this.info[i].value != ""
      });
    }
  },
  methods: {
    onInput(index, value) {
      let data = this.info[index];
      let control = this.controls[index];

      data.value = value;
      control.error = !data.pattern.test(value);
      control.activated = true;
    },
    login() {
      /*let objData = {
        login: this.info[0].value,
        password: md5(this.info[1].value)
      };
      this.$store.dispatch("auth/loadItems", objData);*/

      let formData = new FormData();
      formData.append("login", this.info[0].value);
      formData.append("password", md5(this.info[1].value));
      this.$store.dispatch("auth/loadItems", formData);
      // GET
      /*let objData = {
        login: this.info[0].value,
        password: md5(this.info[1].value)
      };
      //console.log("Login.vue methods:login() objData", objData);
      this.$store.dispatch("auth/loadItems", objData);*/
    }
  },
  computed: {
    ...mapGetters("auth", {
      errorReg: "errorReg"
      //logined: "logined",
      //user: "items"
    }),
    done() {
      let done = 0;
      for (let i = 0; i < this.controls.length; i++) {
        if (!this.controls[i].error) {
          done++;
        }
      }
      return done;
    }
  },
  watch: {}
};
</script>

<style scoped>
.wrapper {
  max-width: 600px;
  margin: 20px auto;
}
</style>