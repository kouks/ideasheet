<template>
  <div>
    <header class="hero is-small">
      <div class="hero-body">
        <div class="container">
          <div class="columns">
            <div class="column is-6 is-offset-3">
              <query-input
                @submit="storePost()"
              />
            </div>
          </div>
        </div>
      </div>
    </header>

    <main id="ideas" class="section is-small">
      <div class="container">
        <div class="idea-grid">
          <div style="display: none" class="idea-grid-sizer"></div>
          <idea
            v-for="idea in $store.getters.allIdeas"
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

  mounted () {
    this.$store.dispatch('loadIdeas')
  }
}
</script>
