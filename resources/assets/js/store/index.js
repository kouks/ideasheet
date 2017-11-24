import Vue from 'vue'
import Vuex from 'vuex'
import auth from './auth'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    auth
  },

  state: {
    page: 1,
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
      data.forEach((idea) => {
        state.ideas.push(idea)
      })
    },

    addIdea (state, { idea }) {
      state.ideas.unshift(idea)
    },

    updateIdeaErrors (state, { errors }) {
      state.ideaErrors = errors
    },

    incrementPage (state) {
      state.page++
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

    loadIdeas ({ commit, state }) {
      return Vue.prototype.$http.get('/api/v1/ideas?page=' + state.page)
        .then(response => commit('updateIdeas', response))
    },

    loadMoreIdeas ({ commit, dispatch }) {
      commit('incrementPage')

      return dispatch('loadIdeas')
    },

    focusQueryInput ({ state }) {
      state.queryInput.focus()
    }
  }
})
