import Vue from 'vue'

export default {
  namespaced: true,

  state: {
    loginErrors: {}
  },

  mutations: {
    updateLoginErrors (state, { errors }) {
      state.loginErrors = errors
    }
  },

  actions: {
    login ({ commit, state }, form) {
      return Vue.prototype.$http.post('/api/v1/login', form)
        .catch(({ response }) => {
          commit('updateLoginErrors', { errors: response.data.errors || response.data })
        })
    }
  }
}
