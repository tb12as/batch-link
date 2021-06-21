<template>
  <div class="columns is-flex is-justify-content-center is-align-items-center mt-6 mx-2">
    <div class="column is-half card">
      <div class="card-content">
        <div class="content">
          <h1>404 | Not Found</h1>
          <p>There is nothing here. What do you looking for?</p>
          <p>
            Your crush?
            <br />Bro, you dont even have 1 girl who's interested in you.
          </p>
          <hr />
          <router-link
            v-if="authStatus"
            :to="{name: 'paste.index'}"
            class="button is-small is-light is-success"
          >Your Pastes is Here</router-link>

          <router-link
            v-if="! authStatus"
            :to="{name: 'login'}"
            class="button is-small is-light is-success"
          >Login</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  created() {
    document.title = "Ups! 404";

    this.$store.commit("setNotFound", true);
  },

  computed: {
    authStatus() {
      return this.$store.state.auth.status;
    }
  }
};
</script>