<template>
  <div class="modal" :class="{'is-active' : showed}">
    <div class="modal-background" @click.prevent="cencel"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Delete this Batch?</p>
        <button class="delete" aria-label="close" @click.prevent="cencel"></button>
      </header>
      <section class="modal-card-body">
        <article class="message is-danger">
          <div class="message-body">
            <p>
              This batch will be deleted :
              <i>
                <b>{{ this.title }}</b>
              </i>
            </p>This action
            <strong>cannot</strong> be undone!
          </div>
        </article>
      </section>
      <footer class="modal-card-foot">
        <button
          class="button is-danger"
          :class="{'is-loading' : load}"
          @click.prevent="sendDelete"
        >Delete</button>
        <button class="button" @click.prevent="cencel">Cancel</button>
      </footer>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      load: false
    };
  },

  props: {
    showed: Boolean,
    slug: String,
    title: String
  },

  methods: {
    sendDelete() {
      this.load = true;
      this.$store.dispatch("paste/delete", this.slug).then(() => {
        this.$emit("cencelOrDeleted");
        this.$emit("resetSearchQuery");
        this.load = false;
        if (this.$router.history.current.name == "paste.show") {
          this.$router.push({ name: "paste.index" });
        }
      });
    },

    cencel() {
      this.$emit("cencelOrDeleted");
    }
  }
};
</script>