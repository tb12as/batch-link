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
                  <tr v-for="(paste, i) in pastes" :key="i">
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
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
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
    }
  }
};
</script>