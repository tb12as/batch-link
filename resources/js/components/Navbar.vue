<template>
  <nav
    class="navbar is-fixed-top is-light"
    role="navigation"
    aria-label="main navigation"
    v-if="! isNotFound"
  >
    <div class="navbar-brand">
      <a class="navbar-item" href="https://bulma.io">
        <h5 class="has-text-weight-bold">Batch Links</h5>
      </a>

      <a
        role="button"
        class="navbar-burger"
        aria-label="menu"
        aria-expanded="false"
        data-target="navbarBasicExample"
        @click.prevent="openOrClose"
        :class="{'is-active' : open}"
      >
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu" :class="{'is-active' : open}">
      <div class="navbar-start">
        <a :href="`${appUrl}batch-links`" class="navbar-item">Public Batch</a>
        
        <div class="navbar-item has-dropdown is-hoverable" v-if="authStatus">
          <a class="navbar-link">Your Batch</a>

          <div class="navbar-dropdown">
            <router-link
              class="navbar-item"
              @click.native="openOrClose"
              :to="{name: 'paste.index'}"
            >All Batches</router-link>

            <router-link
              class="navbar-item"
              @click.native="openOrClose"
              :to="{name: 'paste.create'}"
            >New Batch</router-link>
          </div>
        </div>

        <a :href="`${appUrl}bookmarks`" class="navbar-item">Bookmarks</a>
      </div>

      <div class="navbar-end">
        <div class="navbar-item" v-if="! authStatus">
          <div class="buttons">
            <router-link
              @click.native="openOrClose"
              :to="{name: 'register'}"
              class="button is-primary"
            >
              <strong>Sign up</strong>
            </router-link>

            <router-link
              @click.native="openOrClose"
              :to="{name: 'login'}"
              class="button is-light"
            >Log in</router-link>
          </div>
        </div>

        <div class="navbar-item has-dropdown is-hoverable" v-if="authStatus">
          <a class="navbar-link">{{ user.name }}</a>

          <div class="navbar-dropdown">
            <a class="navbar-item" @click.prevent="logout">Logout</a>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      open: false
    };
  },

  methods: {
    openOrClose() {
      if (this.open) {
        this.open = false;
      } else {
        this.open = true;
      }
    },

    logout() {
      this.$store.dispatch("auth/logout").then(() => {
        this.openOrClose();
        this.$router.push("/login");
        this.$store.commit("paste/setNeedLoad", true);
      });
    }
  },

  computed: {
    authStatus() {
      return this.$store.state.auth.status;
    },

    user() {
      return this.$store.state.auth.user;
    },

    isNotFound() {
      return this.$store.state.isNotFound;
    },

    appUrl() {
      return this.$store.state.appUrl;
    }
  }
};
</script>