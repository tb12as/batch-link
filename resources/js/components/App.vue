<template>
  <div>
    <Navbar />
    <div class="container">
      <div class="columns my-4">
        <div class="column is-3" v-if="auth">
          <sidebar />
        </div>
        <div class="column" :class="auth ? 'is-9' : 'is-12'">
          <section class="hero is-info welcome m-2 is-small" v-if="auth">
            <div class="hero-body">
              <div class="container">
                <h1 class="title is-capitalized">Hello, {{ user.name }}.</h1>
                <h2 class="subtitle">I hope you are having a great day!</h2>
              </div>
            </div>
          </section>
          <router-view></router-view>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from "./NavbarNew.vue";
import Sidebar from "./SidebarDashboard.vue";
export default {
  components: {
    Navbar,
    Sidebar
  },

  computed: {
    auth() {
      return this.$store.state.auth.status;
    },

    user() {
      return this.$store.state.auth.user;
    }
  }
};
</script>