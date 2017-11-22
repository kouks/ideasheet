<template>
  <div class="column is-4">
    <div class="idea">
      <div v-show="idea.content" :class="['idea-content', contentClass]">
        {{ idea.content }}
      </div>

      <div class="idea-tags" v-show="idea.tags.length">
        <a class="idea-tag" href="" v-for="tag in idea.tags">#{{ tag.name }}</a>
      </div>

      <div class="idea-snippet" v-for="{ content } in attachments(2)">
        <code>{{ content.replaceAll('`', '') }}</code>
      </div>

      <a :href="content" target="_blank" class="idea-link" v-for="{ content } in attachments(0)">
        {{ content }}
      </a>

      <div class="idea-image" v-for="{ content } in attachments(1)">
        <img src="" alt="Attachment Image" v-lazy-load="content">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['idea'],

  computed: {
    contentClass () {
      return (this.idea.content && this.idea.content.length < 50) ? 'is-caption' : ''
    },

    attachments () {
      return (type) => {
        return this.idea.attachments.filter(item => item.type === type)
      }
    }
  }
}
</script>
