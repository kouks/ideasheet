<template>
  <div class="idea-tags" v-show="tags.length">
    <a
      class="idea-tag"
      href="#"
      v-for="tag in tags"
      @click.prevent="searchForTag(tag)"
    >#{{ tag.name }}</a>
  </div>
</template>

<script>
export default {
  props: ['tags'],

  methods: {
    searchForTag (tag) {
      this.$store.commit('updateQuery', { text: `@ #${tag.name}` })
      this.$store.dispatch('focusQueryInput')
    }
  }
}
</script>
