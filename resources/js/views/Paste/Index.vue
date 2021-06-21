<template>
  <div class="columns" v-if="! load">
    <div class="column m-1 mt-4">
      <div class="card">
        <div class="card-header">
          <p class="card-header-title">Your Paste</p>
        </div>

        <delete-modal :slug="selectedSlug" :showed="deleteMode" @cencelOrDeleted="unselect"></delete-modal>

        <div class="card-content">
          <div class="content">
            <div class="table-container">
              <table class="table is-bordered is-striped is-hoverable is-fullwidth">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Paste Title</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody>
                  <tr v-if="pastes.data.length < 1">
                    <td colspan="3" class="has-text-centered">
                      You don't have any paste yet, create one
                      <router-link :to="{name: 'paste.create'}">here</router-link>
                    </td>
                  </tr>

                  <tr v-for="(paste, i) in pastes.data" :key="i">
                    <td>{{ i+1 }}</td>
                    <td>{{ paste.title }}</td>
                    <td>
                      <button
                        class="button is-danger is-small m-1"
                        @click="selectDel(paste.slug)"
                      >Delete</button>
                      <router-link
                        class="button is-link is-small m-1"
                        :to="{name: 'paste.show', params: {slug: paste.slug}}"
                      >Detail</router-link>
                      <router-link
                        class="button is-warning is-small m-1"
                        :to="{name: 'paste.edit', params: {slug: paste.slug}}"
                      >Edit</router-link>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <nav
              class="pagination is-rounded"
              role="navigation"
              aria-label="pagination"
              v-if="pastes.meta.links.slice(1, -1).length > 1"
            >
              <a
                class="pagination-previous"
                title="This is the first page"
                @click.prevent="paginateOnChange(pastes.links.prev)"
                :disabled="!pastes.links.prev"
              >Previous</a>

              <a
                class="pagination-next"
                @click.prevent="paginateOnChange(pastes.links.next)"
                :disabled="!pastes.links.next"
              >Next page</a>

              <ul class="pagination-list">
                <li v-for="(link, i) in pastes.meta.links.slice(1, -1)" :key="i">
                  <a
                    class="pagination-link"
                    :class="{'is-current' : link.active}"
                    :aria-label="`Page ${link.label}`"
                    :aria-current="{'page' : link.active}"
                    :disabled="!link.url"
                    @click.prevent="paginateOnChange(link.url, link.active)"
                    v-html="link.label"
                  ></a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DeleteModal from "../../components/ModalDeletePaste.vue";

export default {
  data() {
    return {
      load: true,
      deleteMode: false,
      selectedSlug: ""
    };
  },

  components: {
    DeleteModal
  },

  created() {
    document.title = "Paste";
    this.$store.commit("setNotFound", false);
  },

  mounted() {
    this.getPastes();
  },

  computed: {
    pastes() {
      return this.$store.state.paste.pastes;
    }
  },

  methods: {
    getPastes() {
      this.$store.dispatch("paste/get").then(() => {
        this.load = false;
      });
    },

    selectDel(slug) {
      this.selectedSlug = slug;
      this.deleteMode = true;
    },

    unselect() {
      this.selectedSlug = "";
      this.deleteMode = false;
    },

    paginateOnChange(url, isActive) {
      if (!isActive) {
        this.$store.dispatch("paste/paginateOnChange", url);
      }
    }
  }
};
</script>