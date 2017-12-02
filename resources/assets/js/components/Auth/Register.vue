<template>
  <main class="hero is-fullheight">
    <div class="hero-body">
      <div class="container">
        <div class="columns">
          <div class="column is-4 is-offset-4">
            <form class="form" @submit.prevent="register()">
              <div class="form-field">
                <div class="form-field has-addons">
                  <span class="form-addon">
                    <i class="fa fa-fw fa-user" aria-hidden="true"></i>
                  </span>
                  <input autofocus type="text" v-model="form.name" placeholder="Name">
                </div>

                <span v-for="error in errors.name" class="form-message has-text-danger">
                  {{ error }}
                </span>
              </div>

              <div class="form-field">
                <div class="form-field has-addons">
                  <span class="form-addon">
                    <i class="fa fa-fw fa-envelope" aria-hidden="true"></i>
                  </span>
                  <input autofocus type="text" v-model="form.email" placeholder="Email">
                </div>

                <span v-for="error in errors.email" class="form-message has-text-danger">
                  {{ error }}
                </span>
              </div>

              <div class="form-field">
                <div class="form-field has-addons">
                  <span class="form-addon">
                    <i class="fa fa-fw fa-key" aria-hidden="true"></i>
                  </span>
                  <input type="password" v-model="form.password" placeholder="Password">
                </div>
              </div>

              <div class="form-field">
                <div class="form-field has-addons">
                  <span class="form-addon">
                    <i class="fa fa-fw fa-key" aria-hidden="true"></i>
                  </span>
                  <input type="password" v-model="form.password_confirmation" placeholder="Password Confirmation">
                </div>

                <span v-for="error in errors.password" class="form-message has-text-danger">
                  {{ error }}
                </span>
              </div>

              <div class="form-field">
                <button type="submit" class="action is-fullwidth is-primary">Register</button>

                <span v-show="errors.error" class="form-message has-text-danger">
                  {{ errors.error }}
                </span>
              </div>

              <div class="form-field">
                <router-link
                  class="action is-default is-fullwidth"
                  to="/login"
                >Already have an account?</router-link>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import { mapState } from 'vuex'
import Cookie from 'js-cookie'

export default {
  data () {
    return {
      form: {}
    }
  },

  computed: mapState({ errors: state => state.auth.registrationErrors }),

  methods: {
    register () {
      this.$store.dispatch('auth/register', this.form)
        .then((response) => {
          Cookie.set('ideasheet_token', response.data.api_token, { domain: window.location.hostname })
          this.$router.push({ name: 'home' })
        })
    }
  }
}
</script>
