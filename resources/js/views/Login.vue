<template>
  <div class="columns is-flex is-justify-content-center m-6">
    <div class="column is-half card">
      <div class="card-content">
        <div class="content">
          <article class="message is-success" v-if="success">
            <div class="message-body">
              <p>Login success, redirecting....</p>
            </div>
          </article>

          <h2 class="has-text-centered">Login</h2>
          <p class="has-text-centered">Please login to proceed.</p>
          <hr />

          <form @submit.prevent="login">
            <div class="field">
              <div class="control">
                <input
                  id="email"
                  class="input p-4"
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
              <div class="control">
                <input
                  id="password"
                  class="input p-3"
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
                <button
                  type="submit"
                  class="button is-sm is-primary"
                  :class="{'is-loading' : is_load || success}"
                >Login</button>
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
      errors: [],
      success: false,
      is_load: false
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
      this.is_load = true;
      this.errors = [];

      this.$store
        .dispatch("auth/login", this.form)
        .then(() => (this.success = true))
        .catch(err => {
          const status = err.response.status || null;
          if (status == 422 || status == 401) {
            this.errors = err.response.data.errors;
          }
        })
        .finally(() => (this.is_load = false));
    }
  }
};
</script>
