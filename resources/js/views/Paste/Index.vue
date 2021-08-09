<template>
  <div class="columns">
    <div class="column is-12">
      <div class="card" v-if="! load">
        <delete-modal
          :slug="selectedSlug"
          :title="selectedTitle"
          :showed="deleteMode"
          @cencelOrDeleted="unselect"
          @resetSearchQuery="resetSearchQuery"
        ></delete-modal>
        <div class="card-content">
          <div class="content">
            <router-link class="button is-primary is-rounded p-1 px-2 is-small" :to="{name: 'paste.create'}">
              <i aria-hidden="true" class="fa fa-plus-circle fa-2x"></i> <span class="ml-2"> New Batch</span>
            </router-link>

            <div class="is-flex is-justify-content-space-between my-3 mx-2 is-flex-wrap-wrap">
              <h2>Your Batch</h2>
              <form @submit.prevent="sendSearch">
                <div class="field has-addons is-half">
                  <div class="control">
                    <input class="input" type="search" placeholder="Search" v-model="searchQuery" />
                  </div>
                  <div class="control">
                    <button type="submit" class="button is-primary">
                      <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
            <div class="table-container">
              <table class="table is-bordered is-striped is-hoverable is-fullwidth">
                <thead>
                  <tr class="has-text-centered mx-auto">
                    <th width="50">#</th>
                    <th width="350">Paste Title</th>
                    <th width="70">Privacy</th>
                    <th width="70">Visited</th>
                    <th width="230">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="pastes.data.length < 1 && !searchMode">
                    <td colspan="5" class="has-text-centered">
                      You don't have any paste yet, create one
                      <router-link :to="{name: 'paste.create'}">here</router-link>
                    </td>
                  </tr>
                  <tr v-if="pastes.data.length < 1 && searchMode">
                    <td
                      colspan="5"
                      class="has-text-centered"
                    >Can't find anything with query {{ this.searchQuery }}</td>
                  </tr>
                  <tr v-for="(paste, i) in pastes.data" :key="i">
                    <td class="has-text-centered">{{ i+1 }}</td>
                    <td class="break-word">{{ paste.title }}</td>
                    <td>{{ paste.privacy }}</td>
                    <td>{{ (paste.visited_count || 0) + (paste.visited_count > 1 ? " times" : " time") }}</td>
                    <td class="has-text-centered">
                      <button
                        class="button is-small is-danger m-1"
                        @click="selectDel(paste.slug, paste.title)"
                      >
                        <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
                      </button>
                      <router-link
                        class="button is-small is-link m-1"
                        :to="{name: 'paste.show', params: {slug: paste.slug}}"
                      >
                        <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                      </router-link>
                      <router-link
                        class="button is-small is-warning m-1"
                        :to="{name: 'paste.edit', params: {slug: paste.slug}}"
                      >
                        <i class="fa fa-pencil-square fa-lg" aria-hidden="true"></i>
                      </router-link>
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
              >Next</a>
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
      selectedSlug: "",
      selectedTitle: "",
      searchQuery: "",
      searchMode: false
    };
  },

  components: {
    DeleteModal
  },

  created() {
    document.title = "Your Batch";
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

  watch: {
    searchQuery() {
      if (this.searchQuery.length == 0) {
        this.$store.dispatch("paste/get");
        this.searchMode = false;
      }
    }
  },

  methods: {
    getPastes() {
      this.$store.dispatch("paste/get").then(() => {
        this.load = false;
      });
    },

    selectDel(slug, title) {
      this.selectedSlug = slug;
      this.selectedTitle = title;

      this.deleteMode = true;
    },

    unselect() {
      this.selectedSlug = "";
      this.selectedTitle = "";
      this.deleteMode = false;
    },

    resetSearchQuery() {
      this.searchQuery = "";
    },

    paginateOnChange(url, isActive) {
      if (!isActive) {
        this.$store.dispatch("paste/paginateOnChange", url);
      }
    },

    sendSearch() {
      if (this.sendSearch && this.searchQuery.length > 0) {
        this.searchMode = true;
        this.$store.dispatch("paste/search", this.searchQuery);
      }
    }
  }
};
</script>