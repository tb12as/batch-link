<template>
  <div class="columns">
    <div class="column is-half mt-4">
      <div class="card">
        <div class="card-header">
          <p class="card-header-title">Batch Create</p>
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
                <label for="desc" class="label">Description</label>
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

    <div class="column is-half mt-4">
      <div class="card">
        <div class="card-header">
          <p class="card-header-title">Links</p>
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
                  <td
                    colspan="3"
                    class="has-text-centered break-word has-text-weight-bold"
                  >{{ form.title }}</td>
                </tr>
                <tr v-for="(link, i) in form.links" :key="i" class="break-word">
                  <td class="has-text-weight-bold break-word">{{ link.title }}</td>
                  <td class="break-word">{{ link.original_link }}</td>
                  <td>
                    <button
                      class="button is-danger is-small m-1"
                      @click.prevent="deleteLink(i)"
                    >Delete</button>

                    <button class="button is-warning is-small m-1" @click.prevent="editLink(i)">Edit</button>

                    <span class="tag is-danger" v-if="linksIndexError.includes(i)">!</span>
                  </td>
                </tr>
              </tbody>
            </table>

            <form @submit.prevent="pushLink">
              <div class="field">
                <label class="label">Batch Links</label>
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
                  type="button"
                  :class="{'is-loading' : load}"
                  @click.prevent="save"
                >Save</button>
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
  </div>
</template>

<script>
import ModalEdit from "../../components/ModalEditLink.vue";
export default {
  created() {
    document.title = "New Batch";
  },

  components: {
    ModalEdit
  },

  data() {
    return {
      editLinkMode: false,
      editingIndex: null,
      canSave: false,
      errors: [],
      form: {
        title: "",
        privacy: "",
        description: "",
        links: []
      },
      links: {
        title: "",
        original_link: ""
      },
      load: false
    };
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
    }
  },

  methods: {
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
      this.links.title = "";
      this.links.original_link = "";

      this.editLinkMode = false;
      this.editingIndex = null;
    },

    deleteLink(index) {
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
        this.load = true;
        this.$store
          .dispatch("paste/save", this.form)
          .catch(err => {
            if (err.response.status == 422) {
              this.errors = err.response.data.errors;
            }
          })
          .finally(() => (this.load = false));
      } else {
        this.errors = { title: "The title field is required" };
      }
    }
  }
};
</script>