<template>
  <div class="container content">
    <div class="columns">
      <div class="column m-1 mt-4">
        <div class="card">
          <div class="card-content">
            <div class="content">
              <h2>Your Bookmarks</h2>

              <table class="table is-bordered">
                <thead>
                  <tr class="has-text-centered">
                    <th width="80">No</th>
                    <th>Paste Title</th>
                    <th width="300">Action</th>
                  </tr>
                </thead>

                <tbody>
                  <tr v-for="(val, i) in bookmarks" :key="i">
                    <td class="has-text-centered">{{ i+1 }}</td>
                    <td>{{ val.title }}</td>
                    <td class="has-text-centered">
                      <a
                        :href="`${appUrl}public-batch/${val.slug}/d`"
                        target="blank"
                        class="button is-small is-link"
                      >Visit</a>
                      <button
                        class="button is-small is-danger deleteBtn"
                        @click.prevent="showModalDelete(val.paste_id)"
                      >Delete</button>
                    </td>
                  </tr>

                  <tr v-if="bookmarks.length == 0">
                    <td colspan="3" class="has-text-centered">You don't have any bookmark</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="modal" :class="{'is-active' : deleteMode}">
        <div class="modal-background" @click.prevent="reset"></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">Delete Bookmark?</p>
            <button class="cancel delete" aria-label="close" @click.prevent="reset"></button>
          </header>
          <section class="modal-card-body">
            <article class="message is-danger">
              <div class="message-body">
                This action
                <strong>cannot</strong> be undone!
              </div>
            </article>
          </section>
          <footer class="modal-card-foot">
            <button
              class="button is-danger"
              :class="{'is-loading' : sending}"
              @click.prevent="sendDelete"
            >Delete</button>
            <button class="button cancel" @click.prevent="reset">Cancel</button>
          </footer>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      deleteMode: false,
      targetDelete: null,
      sending: false
    };
  },

  created() {
    document.title = 'Bookmarks';
    this.loadBookmark();
  },

  methods: {
    loadBookmark() {
      this.$store.dispatch("bookmark/get");
    },

    showModalDelete(id) {
      this.deleteMode = true;
      this.targetDelete = id;
    },

    reset() {
      this.deleteMode = false;
      this.targetDelete = null;
    },

    sendDelete() {
      this.sending = true;
      this.$store
        .dispatch("bookmark/detach", this.targetDelete)
        .then(() => {
          this.loadBookmark();
          this.reset();
        })
        .finally(() => (this.sending = false));
    }
  },

  computed: {
    bookmarks() {
      return this.$store.state.bookmark.bookmarks;
    },

    appUrl() {
      return this.$store.state.appUrl;
    }
  }
};
</script>