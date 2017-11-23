import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    query: '',
    ideas: []
  },

  getters: {
    allIdeas: ({ ideas }) => ideas
  },

  mutations: {
    updateQuery (state, { text }) {
      state.query = text
    },

    setIdeas (state, { data }) {
      state.ideas = data
    },

    addIdea (state, { idea }) {
      state.ideas.unshift(idea)
    }
  },

  actions: {
    storeIdea ({ dispatch, commit, state }) {
      Vue.prototype.$http.post('/api/v1/ideas', { query: state.query })
        .then((response) => {
          commit('updateQuery', { text: '' })
          commit('addIdea', { idea: response.data })
        })
    },

    loadIdeas ({ dispatch, commit }) {
      Vue.prototype.$http.get('/api/v1/ideas')
        .then(response => commit('setIdeas', response))
    }
  }
})
