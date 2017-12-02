<template>
  <layout-master>
    <header class="hero is-small">
      <div class="hero-body">
        <div class="container">
          <div class="columns">
            <div class="column is-6 is-offset-3">
              <query-input />
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
  </layout-master>
</template>

<script>
import Idea from './Idea'
import QueryInput from './QueryInput'
import LayoutMaster from '@/components/Layouts/Master'

export default {
  components: { QueryInput, Idea, LayoutMaster },

  mounted () {
    this.$store.dispatch('loadIdeas')

    this.$nextTick(() => {
      window.addEventListener('scroll', this.handleScrollEvent)
    })
  },

  beforeDestroy () {
    window.removeEventListener('scroll', this.handleScrollEvent)
  },

  methods: {
    handleScrollEvent () {
      if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
        this.$store.dispatch('loadMoreIdeas')
      }
    }
  }
}
</script>
