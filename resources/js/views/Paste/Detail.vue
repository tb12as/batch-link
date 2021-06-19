<template>
  <div class="columns">
    <modal-delete :showed="showModal" :slug="paste.slug" @cencelOrDeleted="toggleModal"></modal-delete>
    <div class="column m-1 mt-5">
      <div class="card" v-if="! load">
        <header class="card-header">
          <p class="card-header-title">{{ paste.title }}</p>
        </header>
        <div class="card-content">
          <div class="content">
            <p v-if="paste.links.length < 1">This paste doesn't have any link</p>

            <table border="0">
              <tbody>
                <tr v-for="(link, i) in paste.links" :key="i">
                  <td>
                    <b>{{ link.title }}</b>
                  </td>
                  <td>
                    {{ link.original_link.length > 50 ? link.original_link.slice(0, 50) + "..." : link.original_link }}
                    <span
                      class="tag"
                    >{{ link.hash }}</span>
                  </td>
                  <td>
                    <a
                      class="button is-small is-link is-light m-1"
                      target="blank"
                      :href="'http://localhost:8000/r/'+link.hash"
                    >Test Redirect</a>
                    <a
                      class="button is-small is-link is-light m-1"
                      target="blank"
                      :href="link.original_link"
                    >Test Original Link</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <footer class="card-footer">
          <a href="#" class="card-footer-item">Edit</a>
          <a href="#" class="card-footer-item" @click.prevent="toggleModal">Delete</a>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
import ModalDelete from "../../components/ModalDeletePaste.vue";
export default {
  components: {
    ModalDelete
  },

  data() {
    return {
      load: true,
      showModal: false
    };
  },

  created() {
    document.title = "Paste Detail";
  },

  mounted() {
    this.$store.dispatch("paste/detail", this.$route.params.slug).then(() => {
      this.load = false;
    });
  },

  computed: {
    paste() {
      return this.$store.state.paste.singlePaste;
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