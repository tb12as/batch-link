<template>
  <div class="columns is-flex is-justify-content-center mt-6 mx-2">
    <div class="column is-half card">
      <div class="card-content">
        <div class="content">
          <h1>404 | Not Found</h1>
          <p>Paste not found</p>
          <hr />
          <router-link
            :to="{name: 'paste.index'}"
            class="button is-small is-light is-success"
          >Your Pastes is Here</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  created() {
    document.title = "Ups! 404";

    this.$store.commit("setPasteNotFound", true);
    this.$store.commit("setNotFound", true);
  },
};
</script>