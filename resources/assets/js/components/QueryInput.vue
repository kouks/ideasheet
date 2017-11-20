<template>
  <div class="query">
    <div
      ref="query"
      class="query-input"
      contenteditable="true"
      @paste="clearQuery()"
    ></div>

    <button class="query-button" @click="$emit('submit', query())">
      Post
    </button>
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
      window.addEventListener('keyup', this.handleGlobalKeyupEvent)
    })
  },

  methods: {
    handleGlobalKeyupEvent (event) {
      let code = event.keyCode || event.which
      let el = this.queryInput()

      if (document.activeElement !== el && this.delimiters[code]) {
        this.query(this.delimiters[code])
      }

      if (document.activeElement === el && code === 27) {
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
