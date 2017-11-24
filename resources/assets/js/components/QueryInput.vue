<template>
  <div class="query">
    <textarea
      ref="query"
      class="query-input"
      rows="1"
      v-model="$store.state.query"
      @input="adjustHeight($event)"
    ></textarea>
    <div class="query-overlay"></div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      listeners: {
        162: this.dollarSignPressed,
        86: this.atSignPressed,
        13: this.enterPressed,
        27: this.escapePressed
      }
    }
  },

  mounted () {
    this.$nextTick(() => {
      this.$store.commit('setQueryInput', { el: this.$refs.query })
      window.addEventListener('keydown', this.handleGlobalKeydownEvent)
    })
  },

  methods: {
    handleGlobalKeydownEvent (event) {
      let code = event.keyCode || event.which

      if (this.listeners[code]) {
        this.listeners[code](event, this.$store.state.queryInput)
      }
    },

    dollarSignPressed (event, el) {
      if (event.target === el) {
        return
      }

      event.preventDefault()
      this.$store.commit('updateQuery', { text: '$' })
      el.focus()
    },

    atSignPressed (event, el) {
      if (event.target === el) {
        return
      }

      event.preventDefault()
      this.$store.commit('updateQuery', { text: '@' })
      el.focus()
    },

    enterPressed (event, el) {
      if (event.target !== el) {
        return
      }

      event.preventDefault()
      this.$store.dispatch('storeIdea')
      el.blur()
    },

    escapePressed (event, el) {
      if (event.target !== el) {
        return
      }

      event.preventDefault()
      this.$store.commit('updateQuery', { text: '' })
      el.blur()
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
