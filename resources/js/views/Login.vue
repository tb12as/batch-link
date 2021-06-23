<template>
  <div class="columns is-flex is-justify-content-center m-6">
    <div class="column is-half card">
      <div class="card-content">
        <div class="content">
          <form @submit.prevent="login">
            <div class="field">
              <label class="label" for="email">Email</label>
              <div class="control">
                <input
                  id="email"
                  class="input"
                  type="email"
                  placeholder="Your Email"
                  v-model="form.email"
                  :class="{'is-danger' : keys.includes('email')}"
                />
                <p
                  v-if="keys.includes('email')"
                  class="help is-danger"
                >{{ validation[keys.indexOf('email')] }}</p>
              </div>
            </div>

            <div class="field">
              <label class="label" for="password">Password</label>
              <div class="control">
                <input
                  id="password"
                  class="input"
                  type="password"
                  placeholder="Password"
                  v-model="form.password"
                  :class="{'is-danger' : keys.includes('password')}"
                />
                <p
                  v-if="keys.includes('password')"
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
export default {
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
