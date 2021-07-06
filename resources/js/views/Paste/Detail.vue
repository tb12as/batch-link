<template>
  <div :class="{'columns' : !pasteNotFound}">
    <NotFound v-if="pasteNotFound" />

    <div class="column" v-if="! load && !pasteNotFound">
      <div class="card">
        <div class="card-content">
          <div class="content">
            <modal-delete :showed="showModal" :slug="paste.slug" @cencelOrDeleted="toggleModal"></modal-delete>

            <h2 class="break-word">{{ paste.title }}</h2>

            <article class="message is-primary" v-if="paste.links.length < 1">
              <div class="message-body">
                <p>This paste doesn't have any link</p>
              </div>
            </article>

            <p>{{ paste.description }}</p>

            <table class="table is-bordered" v-if="paste.links.length > 0">
              <thead class="has-text-centered">
                <tr>
                  <th width="80">No</th>
                  <th>Link Title</th>
                  <th width="300">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(link, i) in paste.links" :key="i">
                  <td class="has-text-centered">{{ i+1 }}</td>
                  <td>{{ link.title }}</td>
                  <td class="has-text-centered">
                    <a
                      class="button is-small is-success m-1"
                      target="blank"
                      :href="`${appUrl}r/${link.hash}`"
                    >Test Redirect</a>

                    <a
                      class="button is-small is-primary m-1"
                      target="blank"
                      v-if="paste.privacy === 'public'"
                      :href="link.original_link"
                    >Test Original Link</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <footer class="card-footer">
          <router-link
            class="card-footer-item"
            :to="{name: 'paste.edit', params: {slug: paste.slug}}"
          >Edit</router-link>

          <a href="#" class="card-footer-item" @click.prevent="toggleModal">Delete</a>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
import ModalDelete from "../../components/ModalDeletePaste.vue";
import NotFound from "../PasteNotFound.vue";
export default {
  components: {
    ModalDelete,
    NotFound
  },

  data() {
    return {
      load: true,
      showModal: false
    };
  },

  created() {
    document.title = "Batch Detail";
    this.$store.commit("setPasteNotFound", false);
  },

  mounted() {
    this.$store
      .dispatch("paste/detail", this.$route.params.slug)
      .then(() => {
        this.load = false;
      })
      .catch(error => {
        if (error.response.status === 404) {
          this.$store.commit("setPasteNotFound", true);
        }
      });
  },

  computed: {
    paste() {
      return this.$store.state.paste.singlePaste;
    },

    pasteNotFound() {
      return this.$store.state.pasteNotFound;
    },

    appUrl() {
      return this.$store.state.appUrl;
    }
  },

  methods: {
    toggleModal() {
      if (this.showModal) {
        this.showModal = false;
      } else {
        this.showModal = true;
      }
    }
  }
};
</script>