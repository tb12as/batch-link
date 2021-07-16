<template>
  <div class="modal" :class="{'is-active' : showed}">
    <div class="modal-background" @click.prevent="cencel"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Link Edit</p>
        <button class="delete" aria-label="close" @click.prevent="cencel"></button>
      </header>
      <form @submit.prevent="pushChanges">
        <section class="modal-card-body">
          <div class="control">
            <input
              class="input m-1"
              type="text"
              placeholder="Link Title"
              v-model="link.title"
              required
            />

            <input
              class="input m-1"
              type="url"
              placeholder="https://yourlink.com/..."
              v-model="link.original_link"
              required
            />
          </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-warning" type="submit">Edit</button>
          <button class="button" @click.prevent="cencel">Cancel</button>
        </footer>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    showed: Boolean,
    link: Object
  },

  methods: {
    cencel() {
      this.$emit("closeModal");
    },

    pushChanges() {
      this.$emit("linkChanged");
    }
  }
};
</script>