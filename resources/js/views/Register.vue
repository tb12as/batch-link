<template>
  <div class="columns is-flex is-justify-content-center m-6">
    <div class="column is-half card">
      <div class="card-content">
        <div class="content">
          <h2 class="has-text-centered">Sign Up</h2>
          <p class="has-text-centered">Join us now</p>
          <hr />

          <form @submit.prevent="register">
            <div class="field">
              <div class="control">
                <input
                  id="name"
                  class="input p-4"
                  type="text"
                  placeholder="Your Name"
                  v-model="form.name"
                  :class="{'is-danger' : keys.includes('name')}"
                />
                <p
                  v-if="keys.includes('name')"
                  class="help is-danger"
                >{{ validation[keys.indexOf('name')] }}</p>
              </div>
            </div>

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
                  class="input p-4"
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

            <div class="field">
              <div class="control">
                <input
                  id="password_c"
                  class="input p-4"
                  type="password"
                  placeholder="Password Confirmation"
                  v-model="form.password_confirmation"
                  :class="{'is-danger' : keys.includes('password_confirmation')}"
                />
                <p
                  v-if="keys.includes('password_confirmation')"
                  class="help is-danger"
                >{{ validation[keys.indexOf('password_confirmation')] }}</p>
              </div>
            </div>

            <div class="field is-grouped">
              <div class="control">
                <button
                  type="submit"
                  class="button is-sm is-primary"
                  :class="{'is-loading' : load}"
                >Sign Up</button>
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
        name: "",
        email: "",
        password: "",
        password_confirmation: ""
      },
      errors: [],
      load: false
    };
  },

  created() {
    axios.get("/sanctum/csrf-cookie");
    this.$store.commit("setNotFound", false);
    document.title = "Sign Up";
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
    register() {
      this.errors = [];
      this.load = true;

      this.$store
        .dispatch("auth/register", this.form)
        .then(() => {
          this.$router.push({ name: "paste.index" });
        })
        .catch(err => {
          let status = err.response.status;
          if (status == 422 || status == 401) {
            this.errors = err.response.data.errors;
          }
        })
        .finally(() => (this.load = false));
    }
  }
};
</script>
