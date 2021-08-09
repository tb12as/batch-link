<template>
  <aside class="menu is-hidden-mobile">
    <p class="menu-label">Dashboard</p>
    <ul class="menu-list">
      <li>
        <router-link :to="{name: 'paste.index'}">My Batch</router-link>
      </li>
      <li>
        <router-link :to="{name: 'paste.create'}">Batch Create</router-link>
      </li>
      <li>
        <router-link :to="{name: 'bookmark'}">Bookmarks</router-link>
      </li>
    </ul>

    <p class="menu-label">Account</p>
    <ul class="menu-list">
      <li>
        <router-link :to="{name: 'change.password'}">Change Password</router-link>
      </li>
      <li>
        <a href="logout" @click.prevent="logout">Logout</a>
      </li>
    </ul>
  </aside>
</template>

<script>
export default {
  methods: {
    logout() {
      this.$store.dispatch("auth/logout").then(() => {
        this.$router.push("/login");
        this.$store.commit("paste/setNeedLoad", true);
      });
    }
  }
};
</script>