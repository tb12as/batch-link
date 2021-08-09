<template>
  <div :class="{'columns' : ! pasteNotFound}">
    <NotFound v-if="pasteNotFound" />

    <div class="column is-6" v-if="! pasteNotFound && ! load">
      <div class="card">
        <div class="card-header">
          <p class="card-header-title">Batch Edit</p>
        </div>

        <div class="card-content">
          <div class="content">
            <form @submit.prevent="save">
              <div class="field">
                <label class="label">Batch Title</label>
                <div class="control">
                  <input
                    class="input m-1"
                    type="text"
                    placeholder="Batch Title"
                    v-model="form.title"
                    :class="{'is-danger' : keys.includes('title')}"
                  />
                  <p
                    v-if="keys.includes('title')"
                    class="help is-danger"
                  >{{ errorValues[keys.indexOf('title')] }}</p>
                </div>
              </div>

              <div class="field">
                <label for="desc">Description</label>
                <textarea
                  id="desc"
                  v-model="form.description"
                  class="textarea"
                  placeholder="Description (optional)"
                ></textarea>
              </div>

              <div class="field">
                <div class="select" :class="{'is-danger' : keys.includes('privacy')}">
                  <select v-model="form.privacy">
                    <option disabled value>Privacy</option>
                    <option value="private">Private</option>
                    <option value="public">Public</option>
                  </select>

                  <p
                    v-if="keys.includes('privacy')"
                    class="help is-danger"
                  >{{ errorValues[keys.indexOf('privacy')] }}</p>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="column is-6" v-if="! pasteNotFound && ! load">
      <div class="card">
        <div class="card-header">
          <p class="card-header-title">Links Edit</p>
        </div>

        <div class="card-content">
          <div class="content">
            <article class="message is-danger" v-if="errorValues.length > 0">
              <div class="message-body pt-2">
                <ul v-for="(e, index) in errorValues" :key="index">
                  <li>{{ e }}</li>
                </ul>
              </div>
            </article>

            <table border="0">
              <tbody>
                <tr>
                  <td colspan="3" class="has-text-centered break-word">
                    <b>{{ form.title }}</b>
                    <p class="is-small">{{ form.description }}</p>
                  </td>
                </tr>
                <tr v-for="(link, i) in form.links" :key="i">
                  <td class="has-text-weight-bold break-word">{{ link.title }}</td>
                  <td class="break-word">
                    {{ link.original_link }}
                    <span
                      class="tag is-danger"
                      v-if="linksIndexError.includes(i)"
                    >
                      <i class="fa fa-exclamation" aria-hidden="true"></i>
                    </span>
                  </td>
                  <td>
                    <button
                      class="button is-danger is-small m-1"
                      @click.prevent="showModalDeleteLink(i, form.links[i] || null)"
                    >
                      <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
                    </button>

                    <button class="button is-warning is-small m-1" @click.prevent="editLink(i)">
                      <i class="fa fa-pencil-square fa-lg" aria-hidden="true"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>

            <form @submit.prevent="pushLink">
              <div class="field">
                <label class="label">Add / Edit Links</label>
                <div class="control">
                  <input
                    class="input m-1"
                    type="text"
                    placeholder="Link Title"
                    v-model="links.title"
                    required
                  />

                  <input
                    class="input m-1"
                    type="url"
                    placeholder="https://yourlink.com/..."
                    v-model="links.original_link"
                    required
                  />
                </div>
              </div>

              <div class="field">
                <button
                  type="submit"
                  class="button is-small m-1 is-light"
                  :class="{'is-warning' : editLinkMode, 'is-primary': !editLinkMode}"
                >{{ editLinkMode ? 'Edit' : 'Add' }} Link</button>

                <button
                  v-if="canSave"
                  class="button is-primary is-small m-1"
                  :class="{'is-loading' : sending}"
                  type="button"
                  @click.prevent="save"
                >Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <modal-edit
      :showed="editLinkMode"
      :link="links"
      @closeModal="resetEditMode"
      @linkChanged="pushLink"
    ></modal-edit>

    <modal-delete-link
      :showed="deleteMode"
      :link="selectedToDelete"
      @sendDelete="deleteLink(selectedIndexDelete, selectedToDelete.hash)"
      @cencel="hideModalDeleteLink"
    ></modal-delete-link>
  </div>
</template>

<script>
import NotFound from "../PasteNotFound.vue";
import ModalEdit from "../../components/ModalEditLink.vue";
import ModalDeleteLink from "../../components/ModalDeleteLink.vue";

export default {
  data() {
    return {
      load: true,
      editLinkMode: false,
      editingIndex: null,
      canSave: false,
      errors: [],
      deleteMode: false,
      selectedToDelete: {},
      selectedIndexDelete: null,
      form: {
        title: "",
        slug: "",
        privacy: "",
        description: "",
        links: []
      },
      links: {
        link_id: null,
        title: "",
        original_link: ""
      },
      sending: false
    };
  },

  created() {
    document.title = "Batch Edit";
    this.getPaste();
    this.$store.commit("setPasteNotFound", false);
  },

  methods: {
    getPaste() {
      this.$store
        .dispatch("paste/getUpdateData", this.$route.params.slug)
        .then(() => {
          this.load = false;
          this.form = this.singlePaste;

          if (this.singlePaste.links.length > 0) {
            this.canSave = true;
          }
        })
        .catch(error => {
          if (error.response.status === 404) {
            this.$store.commit("setPasteNotFound", true);
          }
        });
    },

    pushLink() {
      if (!this.editLinkMode) {
        this.form.links.push({ ...this.links });
      } else {
        this.form.links[this.editingIndex] = { ...this.links };
      }

      this.canSave = true;

      this.resetEditMode();
    },

    resetEditMode() {
      this.links = {
        link_id: null,
        title: "",
        original_link: ""
      };

      this.editLinkMode = false;
      this.editingIndex = null;
    },

    showModalDeleteLink(i, data) {
      this.deleteMode = true;
      this.selectedIndexDelete = i;
      this.selectedToDelete = { ...data };
    },

    hideModalDeleteLink() {
      this.deleteMode = false;
      this.selectedIndexDelete = null;
      this.selectedToDelete = {};
    },

    deleteLink(index, hash) {
      if (hash) {
        this.$store.dispatch("link/delete", hash).then(() => {
          this.deleteLinkFromData(index);
          this.hideModalDeleteLink();
        });
      } else {
        this.deleteLinkFromData(index);
        this.hideModalDeleteLink();
      }
    },

    deleteLinkFromData(index) {
      this.form.links.splice(index, 1);
      if (this.form.links.length < 1) {
        this.canSave = false;
      }
    },

    editLink(index) {
      this.editingIndex = index;
      this.editLinkMode = true;

      this.links = { ...this.form.links[index] };
    },

    save() {
      if (this.form.title) {
        this.sending = true;
        this.$store
          .dispatch("paste/update", this.form)
          .then(() => {
            this.$router.push({ name: "paste.index" });
          })
          .catch(err => {
            if (err.response.status == 422) {
              this.errors = err.response.data.errors;
            }
          })
          .finally(() => (this.sending = false));
      } else {
        this.errors = { title: "The title field is required" };
      }
    }
  },

  components: {
    NotFound,
    ModalEdit,
    ModalDeleteLink
  },

  computed: {
    keys() {
      return Object.keys(this.errors).flat();
    },

    errorValues() {
      return Object.values(this.errors).flat();
    },

    linksIndexError() {
      let z = this.keys.join("").match(/\d/g);

      return z ? z.map(x => parseInt(x)) : "";
    },

    singlePaste() {
      return this.$store.state.paste.singlePaste;
    },

    pasteNotFound() {
      return this.$store.state.pasteNotFound;
    }
  }
};
</script>