<template>
  <nav class="navbar is-white is-fixed-top">
    <div class="container">
      <div class="navbar-brand">
        <a class="navbar-item" :href="`${appUrl}`">
          <img :src="`${appUrl}img/black-logo.png`" alt="Batch Links" width="112" height="48" />
        </a>
        <div
          class="navbar-burger burger"
          data-target="navMenu"
          @click.prevent="openOrClose"
          :class="{'is-active' : open}"
        >
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <div id="navMenu" class="navbar-menu" :class="{'is-active' : open}">
        <div class="navbar-start">
          <a class="navbar-item" :href="`${appUrl}public-batch`">Public Batch</a>
        </div>

        <div class="navbar-end" v-if="authStatus">
          <router-link
            @click.native="openOrClose"
            :to="{name : 'paste.index'}"
            class="navbar-item"
          >My Batch</router-link>
          
          <router-link
            @click.native="openOrClose"
            :to="{name : 'bookmark'}"
            class="navbar-item"
          >Bookmarks</router-link>
        </div>

        <div class="navbar-item has-dropdown is-hoverable" v-if="authStatus">
          <a class="navbar-link is-capitalized">{{ user.name }}</a>

          <div class="navbar-dropdown">
            <router-link
              @click.native="openOrClose"
              :to="{name : 'change.password'}"
              class="navbar-item"
            >Change Password</router-link>
            <a class="navbar-item" @click.prevent="logout">Logout</a>
          </div>
        </div>

        <div class="navbar-end" v-if="! authStatus">
          <router-link @click.native="openOrClose" :to="{name: 'register'}" class="navbar-item">
            <strong>Sign up</strong>
          </router-link>

          <router-link @click.native="openOrClose" :to="{name: 'login'}" class="navbar-item">Log in</router-link>
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

  computed: {
    appUrl() {
      return this.$store.state.appUrl;
    },

    user() {
      return this.$store.state.auth.user;
    },

    authStatus() {
      return this.$store.state.auth.status;
    }
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
  }
};
</script>