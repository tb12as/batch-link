<template>
  <div class="columns is-flex is-justify-content-center m-6">
    <div class="column is-half card">
      <div class="card-content">
        <div class="content">
          <form @submit.prevent="register">
            <div class="field">
              <label class="label">Name</label>
              <div class="control">
                <input
                  class="input"
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
              <label class="label">Email</label>
              <div class="control">
                <input
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
              <label class="label">Password</label>
              <div class="control">
                <input
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

            <div class="field">
              <label class="label">Email</label>
              <div class="control">
                <input
                  class="input"
                  type="password"
                  placeholder="Your Email"
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
                <button type="submit" class="button is-sm is-link">Sign Up</button>
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
      errors: []
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
        });
    }
  }
};
</script>
