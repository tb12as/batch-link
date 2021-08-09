<template>
  <div class="columns">
    <div class="column is-7">
      <div class="card">
        <div class="card-content">
          <div class="content">
            <h2 class="has-text-centered">Change Password</h2>
            <hr />
            <form @submit.prevent="save">
              <div class="field">
                <div class="control">
                  <input
                    class="input p-3"
                    type="password"
                    placeholder="Current Password"
                    v-model="form.current_password"
                    :class="{'is-danger' : keys.includes('current_password')}"
                  />
                  <p
                    v-if="keys.includes('current_password')"
                    class="help is-danger"
                  >{{ validation[keys.indexOf('current_password')] }}</p>
                </div>
              </div>
              <div class="field">
                <div class="control">
                  <input
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
              <div class="field">
                <div class="control">
                  <input
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
                    :class="{'is-loading' : is_load}"
                  >Save Change</button>
                </div>
              </div>
            </form>
          </div>
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
        current_password: "",
        password: "",
        password_confirmation: ""
      },
      errors: [],
      is_load: false
    };
  },

  computed: {
    user() {
      return this.$store.state.auth.user;
    },

    validation() {
      return Object.values(this.errors).flat();
    },

    keys() {
      return Object.keys(this.errors).flat();
    }
  },

  methods: {
    save() {
      this.is_load = true;
      this.$store
        .dispatch("auth/changePassword", this.form)
        .then(() => {
          this.errors = [];
          if (this.user.verified) {
            this.$router.push({ name: "paste.index" });
          } else {
            this.$router.push({ name: "verify" });
          }
        })
        .catch(err => {
          const status = err.response.status;
          if (status == 422 || status == 401) {
            this.errors = err.response.data.errors;
          }
        })
        .finally(() => {
          this.resetInput();
          this.is_load = false;
        });
    },

    resetInput() {
      this.form = {
        current_password: "",
        password: "",
        password_confirmation: ""
      };
    }
  }
};
</script>