import Vue from 'vue'
import Vuex from 'vuex'
import auth from './auth'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    auth
  },

  state: {
    ideas: [],
    query: '',
    ideaErrors: {},
    queryInput: null
  },

  getters: {
    allIdeas: ({ ideas }) => ideas
  },

  mutations: {
    updateQuery (state, { text }) {
      state.query = text
    },

    setQueryInput (state, { el }) {
      state.queryInput = el
    },

    updateIdeas (state, { data }) {
      state.ideas = data
    },

    addIdea (state, { idea }) {
      state.ideas.unshift(idea)
    },

    updateIdeaErrors (state, { errors }) {
      state.ideaErrors = errors
    }
  },

  actions: {
    storeIdea ({ commit, state }) {
      return Vue.prototype.$http.post('/api/v1/ideas', { query: state.query })
        .then((response) => {
          commit('updateQuery', { text: '' })
          commit('addIdea', { idea: response.data })
        })
        .catch(({ response }) => {
          commit('updateIdeaErrors', { errors: response.data })
        })
    },

    loadIdeas ({ commit }) {
      return Vue.prototype.$http.get('/api/v1/ideas')
        .then(response => commit('updateIdeas', response))
    },

    focusQueryInput ({ state }) {
      state.queryInput.focus()
    }
  }
})
