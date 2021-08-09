<template>
  <div class="columns">
    <div class="column is-12">
      <div class="card">
        <div class="card-content">
          <div class="content has-text-centered">
            <h2>Verify e-mail Address</h2>
            <p>
              You must verify your email address (
              <i>{{ user.email }}</i>), to access batch link features
            </p>
            <hr />
            <article class="message is-success" v-if="resended">
              <div class="message-header">
                <p style="margin-bottom: 0;">Sended!</p>
                <button
                  class="delete is-small"
                  aria-label="delete"
                  @click.prevent="resended = false"
                ></button>
              </div>
              <div class="message-body">
                <p>A new email verification link has been emailed to {{ user.email }}</p>
              </div>
            </article>
            <button
              class="button is-primary"
              :class="{'is-loading' : sending}"
              @click.prevent="resendEmail"
            >Resend Email</button>
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
      sending: false,
      resended: false
    };
  },

  created() {
    document.title = "Verify Email";
  },

  computed: {
    user() {
      return this.$store.state.auth.user;
    }
  },

  methods: {
    resendEmail() {
      this.sending = true;
      this.resended = false;

      this.$store
        .dispatch("auth/resendEmail")
        .then(() => {
          this.resended = true;
        })
        .catch(error => {
          console.log(error);
        })
        .finally(() => (this.sending = false));
    }
  }
};
</script>