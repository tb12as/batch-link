<template>
  <div class="columns">
    <div class="column is-12">
      <div class="card w-full">
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
  </div>
</template>

<script>
export default {
  created() {
    document.title = "Ups! 404";

    this.$store.commit("setPasteNotFound", true);
    this.$store.commit("setNotFound", true);
  }
};
</script>