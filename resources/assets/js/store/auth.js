import Vue from 'vue'

export default {
  namespaced: true,

  state: {
    loginErrors: {},
    registrationErrors: {}
  },

  mutations: {
    updateLoginErrors (state, { errors }) {
      state.loginErrors = errors
    },

    updateRegistrationErrors (state, { errors }) {
      console.log(errors)
      state.registrationErrors = errors
    }
  },

  actions: {
    login ({ commit, state }, form) {
      return Vue.prototype.$http.post('/api/v1/login', form)
        .catch(({ response }) => {
          commit('updateLoginErrors', { errors: response.data.errors || response.data })
        })
    },

    register ({ commit, state }, form) {
      return Vue.prototype.$http.post('/api/v1/register', form)
        .catch(({ response }) => {
          commit('updateRegistrationErrors', { errors: response.data.errors || response.data })
        })
    }
  }
}
