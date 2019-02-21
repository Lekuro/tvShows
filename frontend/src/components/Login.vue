<template>
  <form @submit.prevent="formSubmited=true">
    <div v-for="(item, index) in  info" :key="index">
      <label>{{ item.name }}</label>
      <span
        class="fa"
        v-if="controls[index].activated"
        :class="controls[index].error ? 
									'fa-exclamation-circle text-danger' : 
							  		 'fa-check-circle text-success'"
      ></span>
      <input :type="item.type" :value="item.value" @input="onInput(index, $event.target.value)">
    </div>
    <button :disabled="done < info.length" @click="sendAuth">Send Data</button>
  </form>
</template>
   
<script>
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
          pattern: /^.{5,15}$/
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
    sendAuth() {
      let objData = {
        login: this.info[0].value,
        password: md5(this.info[1].value)
      };
      console.log(objData);
      this.$store.dispatch("auth/loadItems", objData);
    }
  },
  computed: {
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
</style>

