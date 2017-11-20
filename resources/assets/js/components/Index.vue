<template>
  <div>
    <header class="hero is-small">
      <div class="hero-body query-container">
        <div class="container has-text-centered">
          <div class="columns">
            <div class="column is-6 is-offset-3">
              <query-input
                @submit="storePost($event)"
              />
            </div>
          </div>
        </div>
      </div>
    </header>

    <main id="ideas" class="section is-small">
      <div class="container">
        <div class="columns is-multiline">
          <idea
            v-for="idea in ideas"
            :key="idea.id"
            :idea="idea"
          />
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import Idea from './Idea'
import QueryInput from './QueryInput'

export default {
  components: { QueryInput, Idea },

  data () {
    return {
      ideas: []
    }
  },

  mounted () {
    this.loadIdeas()
  },

  methods: {
    storePost (query) {
      this.$http.post('/api/v1/ideas', { query })
        .then((response) => {
          this.ideas.unshift(response.data)
        })
    },

    loadIdeas () {
      this.$http.get('/api/v1/ideas')
        .then(response => {
          this.ideas = response.data
        })
    }
  }
}
</script>
