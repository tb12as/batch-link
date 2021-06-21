<template>
  <div class="columns is-flex is-justify-content-center m-6">
    <div class="column is-half card">
      <div class="card-content">
        <div class="content">
          <!-- <div v-for="(v, i) in validation" :key="i">
            <Error :message="v" />
          </div>-->

          <form @submit.prevent="login">
            <div class="field">
              <label class="label">Email</label>
              <div class="control">
                <input
                  class="input"
                  type="email"
                  placeholder="Your Email"
                  v-model="form.email"
                  :class="{'is-danger' : keys.indexOf('email') != -1}"
                />
                <p
                  v-if="keys.indexOf('email') != -1"
                  class="help is-danger"
                >{{ validation[keys.indexOf('email')] }}</p>
              </div>
            </div>

            <div class="field">
              <label class="label">Password</label>
              <div class="control">
                <input
                  class="input"
                  type="password"
                  placeholder="Password"
                  v-model="form.password"
                  :class="{'is-danger' : keys.indexOf('password') != -1}"
                />
                <p
                  v-if="keys.indexOf('password') != -1"
                  class="help is-danger"
                >{{ validation[keys.indexOf('password')] }}</p>
              </div>
            </div>

            <div class="field is-grouped">
              <div class="control">
                <button type="submit" class="button is-sm is-link">Login</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import Error from "../components/Error";
export default {
  // components: {
  //   Error
  // },

  data() {
    return {
      form: {
        email: "",
        password: ""
      },
      errors: []
    };
  },

  created() {
    axios.get("/sanctum/csrf-cookie");
    this.$store.commit("setNotFound", false);
    document.title = "Login";
  },

  computed: {
    validation() {
      return Object.values(this.errors).flat();
    },

    keys() {
      return Object.keys(this.errors).flat();
    }
  },

  methods: {
    login() {
      this.errors = [];

      this.$store
        .dispatch("auth/login", this.form)
        .then(() => {
          this.$router.push({ name: "paste.index" });
        })
        .catch(err => {
          let status = err.response.status;
          if (status == 422 || status == 401) {
            this.errors = err.response.data.errors;
          }
        });
    }
  }
};
</script>
