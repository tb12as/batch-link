<template>
  <div class="columns is-flex is-justify-content-center m-6">
    <div class="column is-half card">
      <div class="card-content">
        <div class="content">
          <form action>
            <div class="field">
              <label class="label">Name</label>
              <div class="control">
                <input class="input" type="text" placeholder="Text input" />
              </div>
            </div>

            <div class="field">
              <label class="label">Username</label>
              <div class="control">
                <input class="input is-success" type="text" placeholder="Text input" value="bulma" />
              </div>
              <p class="help is-success">This username is available</p>
            </div>

            <div class="field">
              <label class="label">Email</label>
              <div class="control">
                <input
                  class="input is-danger"
                  type="email"
                  placeholder="Email input"
                  value="hello@"
                />
              </div>
              <p class="help is-danger">This email is invalid</p>
            </div>

            <div class="field is-grouped">
              <div class="control">
                <button class="button is-sm is-link">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    mounted() {
        document.title = 'Login';
    }
}
</script>
