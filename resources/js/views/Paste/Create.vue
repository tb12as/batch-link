<template>
  <div class="columns">
    <div class="column is-half mt-4">
      <div class="card">
        <div class="card-header">
          <p class="card-header-title">Paste Create</p>
        </div>

        <div class="card-content">
          <div class="content">
            <form @submit.prevent="save">
              <div class="field">
                <label class="label">Paste Title</label>
                <div class="control">
                  <input
                    class="input m-1"
                    type="text"
                    placeholder="Paste Title"
                    v-model="form.title"
                    :class="{'is-danger' : keys.includes('title')}"
                  />
                  <p
                    v-if="keys.includes('title')"
                    class="help is-danger"
                  >{{ errorValues[keys.indexOf('title')] }}</p>
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
          <p class="card-header-title">Paste Create</p>
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
                  <td colspan="3" class="has-text-centered">
                    <b>{{ form.title }}</b>
                  </td>
                </tr>
                <tr v-for="(link, i) in form.links" :key="i">
                  <td>
                    <b>{{ link.title }}</b>
                  </td>
                  <td>{{ link.original_link.length > 50 ? link.original_link.slice(0, 50) + "..." : link.original_link }}</td>
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

            <div class="field">
              <label class="label">Paste Links</label>
              <div class="control">
                <input class="input m-1" type="text" placeholder="Link Title" v-model="links.title" />

                <input
                  class="input m-1"
                  type="text"
                  placeholder="https://yourlink.com/..."
                  v-model="links.original_link"
                />
              </div>
            </div>

            <div class="field">
              <button
                type="button"
                class="button is-small m-1 is-light"
                :class="{'is-warning' : editLinkMode, 'is-primary': !editLinkMode}"
                @click.prevent="pushLink"
              >{{ editLinkMode ? 'Edit' : 'Add' }} Link</button>

              <button
                v-if="canSave"
                class="button is-primary is-small m-1"
                type="button"
                @click.prevent="save"
              >Save</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Error from "../../components/Error.vue";
export default {
  components: {
    Error
  },

  data() {
    return {
      editLinkMode: false,
      editingIndex: null,
      canSave: false,
      errors: [],
      form: {
        title: "",
        links: []
      },
      links: {
        title: "",
        original_link: ""
      }
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
        this.$store
          .dispatch("paste/save", this.form)
          .then(() => {
            this.$router.push({ name: "paste.index" });
          })
          .catch(err => {
            if (err.response.status == 422) {
              this.errors = err.response.data.errors;
            }
          });
      } else {
        this.errors = { title: "The title field is required" };
      }
    }
  }
};
</script>