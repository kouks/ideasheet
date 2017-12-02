<template>
  <main class="hero is-fullheight">
    <div class="hero-body">
      <div class="container">
        <div class="columns">
          <div class="column is-4 is-offset-4">
            <form class="form" @submit.prevent="login()">
              <div class="form-field">
                <div class="form-field has-addons">
                  <span class="form-addon">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
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
                    <i class="fa fa-key" aria-hidden="true"></i>
                  </span>
                  <input type="password" v-model="form.password" placeholder="Password">
                </div>

                <span v-for="error in errors.password" class="form-message has-text-danger">
                  {{ error }}
                </span>
              </div>

              <div class="form-field">
                <button type="submit" class="action is-fullwidth is-primary">Login</button>

                <span v-show="errors.error" class="form-message has-text-danger">
                  {{ errors.error }}
                </span>
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

  computed: mapState({ errors: state => state.auth.loginErrors }),

  methods: {
    login () {
      this.$store.dispatch('auth/login', this.form)
        .then((response) => {
          Cookie.set('ideasheet_token', response.data.api_token)
          this.$router.push({ name: 'home' })
        })
    }
  }
}
</script>
