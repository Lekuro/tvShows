<template>
  <div class="wrapper">
    <form @submit.prevent="formSubmited = true">
      <div class="progress">
        <div class="progress-bar" :style="progressWidth"></div>
      </div>
      <h4 v-if="errorReg">{{errorReg}}</h4>
      <div class="form-group">
        <div v-for="(item, index) in  info" :key="index">
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
        <label v-if="logined && +user.isAdmin" for="admin">
          Will Admin
          <input type="checkbox" id="admin" v-model="willAdmin">
          {{willAdmin}}
        </label>
      </div>
      <button class="btn btn-primary" :disabled="done < info.length" @click="registration">Send Data</button>
    </form>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      willAdmin: false,
      info: [
        {
          type: "text",
          name: "Login",
          value: "",
          pattern: /[a-z0-9_@.&-]{2,30}/i
        },
        /*{
          type: "text",
          name: "Phone",
          value: "",
          pattern: /\+[0-9]{12}/
        },
        {
          type: "email",
          name: "Email",
          value: "",
          pattern: /([a-z0-9_\.]+[@][a-z]+)([\.][a-z]+)+/i
        },*/
        {
          type: "password",
          name: "Password",
          value: "",
          pattern: /[.\S]{5,15}/i
        },
        {
          type: "password",
          name: "Confirm",
          value: "",
          pattern: /[.\S]{5,15}/i
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
    registration() {
      let formData = new FormData();
      formData.append("login", this.info[0].value.trim());
      formData.append("password", md5(this.info[1].value.trim()));
      formData.append("isAdmin", +this.willAdmin);
      this.$store.dispatch("auth/sendItems", formData);
      // let objData = {
      //   login: this.info[0].value.trim(),
      //   password: md5(this.info[1].value.trim()),
      //   isAdmin: +this.willAdmin
      // };
      // console.log(objData);
      // this.$store.dispatch("auth/sendItems", objData);
    }
  },
  computed: {
    ...mapGetters("auth", {
      errorReg: "errorReg",
      logined: "logined",
      user: "items"
    }),
    done() {
      let done = 0;
      let len = this.controls.length;
      for (let i = 0; i < len; i++) {
        if (!this.controls[i].error) {
          done++;
          if (i === len - 1) {
            if (this.info[len - 1].value !== this.info[len - 2].value) {
              done--;
            }
          }
        }
      }
      return done;
    },
    progressWidth() {
      return {
        width: (this.done / this.info.length) * 100 + "%"
      };
    }
  }
};
</script>

<style scoped>
.wrapper {
  max-width: 600px;
  margin: 20px auto;
}
</style>