<template>
  <div class="columns">
    <div class="column m-1">
        {{ pastes }}
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      pastes: []
    };
  },

  mounted() {
    axios.get("/api/paste?with-links=true").then(res => (this.pastes = res.data.pastes));
  }
};
</script>