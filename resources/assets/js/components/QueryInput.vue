<template>
  <div class="query">
    <textarea
      ref="query"
      class="query-input"
      rows="1"
      v-model="$store.state.query"
      @keypress="adjustHeight($event)"
      @paste="adjustHeight($event)"
    ></textarea>
    <div class="query-overlay"></div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      delimiters: {
        162: '$', // Key code for ů
        86: '@' // Key code for v
      }
    }
  },

  mounted () {
    this.$nextTick(() => {
      window.addEventListener('keydown', this.handleGlobalKeydownEvent)
    })
  },

  methods: {
    handleGlobalKeydownEvent (e) {
      let code = e.keyCode || e.which
      let el = this.$refs.query

      if (document.activeElement !== el && this.delimiters[code]) {
        e.preventDefault()
        this.$store.commit('updateQuery', { text: this.delimiters[code] })
        el.focus()
      }

      if (document.activeElement === el && code === 13 && !e.shiftKey) {
        e.preventDefault()
        this.$store.dispatch('storeIdea')
        el.blur()
      }

      if (document.activeElement === el && code === 27) {
        this.$store.commit('updateQuery', { text: '' })
        el.blur()
      }
    },

    adjustHeight ({ target }) {
      this.$nextTick(() => {
        target.style.height = (target.scrollHeight > target.clientHeight)
          ? (target.scrollHeight) + 'px'
          : '60px'
      })
    }
  }
}
</script>
