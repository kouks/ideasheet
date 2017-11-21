<template>
  <div class="column is-4">
    <div class="idea">
      <div :class="['idea-content', contentClass]">
        {{ idea.content }}
      </div>

      <div class="idea-tags" v-show="idea.tags.length">
        <a class="idea-tag" href="" v-for="tag in idea.tags">#{{ tag.name }}</a>
      </div>

      <div class="idea-snippet" v-for="snippet in attachments(2)">
        <code>{{ snippet.content.replace('`', '') }}</code>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['idea'],

  computed: {
    contentClass () {
      return this.idea.content.length < 50 ? 'is-caption' : ''
    },

    attachments () {
      return (type) => {
        return this.idea.attachments.filter(item => item.type === type)
      }
    }
  }
}
</script>
