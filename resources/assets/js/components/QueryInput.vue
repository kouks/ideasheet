<template>
  <div class="query">
    <div
      ref="query"
      class="query-input"
      contenteditable="true"
      @paste="clearQuery()"
    ></div>

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
    handleGlobalKeydownEvent (event) {
      let code = event.keyCode || event.which
      let el = this.queryInput()

      if (document.activeElement !== el && this.delimiters[code]) {
        event.preventDefault()
        this.query(this.delimiters[code])
      }

      if (document.activeElement === el && code === 13 && !event.shiftKey) {
        event.preventDefault()
        this.$emit('submit', this.query())
        el.blur()
        this.query('')
      }

      if (document.activeElement === el && code === 27) {
        this.query('')
        el.blur()
      }
    },

    clearQuery () {
      this.$nextTick(() => {
        this.query(this.queryInput().innerText)
      })
    },

    query (val) {
      let el = this.queryInput()

      if (val === undefined) {
        return el.innerText
      }

      el.innerText = val
      this.cursorToEndOf(el)
    },

    queryInput () {
      return this.$refs.query
    },

    cursorToEndOf (el) {
      if (!el.childNodes[0]) {
        return
      }

      let node = el.childNodes[el.childNodes.length - 1]
      let length = node.textContent.length
      let range = document.createRange()
      let sel = window.getSelection()
      range.setStart(node, length)
      range.collapse(true)
      sel.removeAllRanges()
      sel.addRange(range)
    }
  }
}
</script>
