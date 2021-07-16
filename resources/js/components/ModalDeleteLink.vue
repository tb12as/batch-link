<template>
  <div class="modal" :class="{'is-active' : showed}">
    <div class="modal-background" @click.prevent="cencel"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Delete this link?</p>
        <button class="delete" aria-label="close" @click.prevent="cencel"></button>
      </header>
      <section class="modal-card-body">
        <article class="message is-danger">
          <div class="message-body">
            <p>
              This link will be deleted :
              <i>
                <b>{{ link.title }}</b>
              </i>
            </p>This action
            <strong>cannot</strong> be undone!
          </div>
        </article>
      </section>
      <footer class="modal-card-foot">
        <button class="button is-danger" @click.prevent="sendDelete">Delete</button>
        <button class="button" @click.prevent="cencel">Cancel</button>
      </footer>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    showed: Boolean,
    link: Object,
  },

  methods: {
    cencel() {
      this.$emit("cencel");
    },

    sendDelete() {
        this.$emit("sendDelete");
    }
  }
};
</script>