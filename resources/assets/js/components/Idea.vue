<template>
  <div class="idea" :style="{ background: idea.color }">
    <div v-show="idea.content" :style="{ color: contentColor }" :class="['idea-content', contentClass]">
      {{ idea.content }}
    </div>

    <div class="idea-date">
      <small class="has-text-grey"><i>{{ idea.date }}</i></small>
    </div>

    <div class="idea-tags" v-show="idea.tags.length">
      <a
        class="idea-tag"
        href="#"
        v-for="tag in idea.tags"
        @click.prevent="$store.commit('updateQuery', { text: `@ #${tag.name}` })"
      >#{{ tag.name }}</a>
    </div>

    <div v-show="attachments(2).length" class="idea-snippet" v-for="{ content } in attachments(2)">
      <code>{{ content.replaceAll('`', '') }}</code>
    </div>

    <a
      :href="content"
      class="idea-link"
      target="_blank"
      v-for="{ content } in attachments(0)"
      v-show="attachments(0).length"
    >
      {{ content }}
    </a>

    <div v-show="attachments(1).length" class="idea-image" v-for="{ content } in attachments(1)">
      <img src="" alt="Attachment Image" v-lazy-load="content">
    </div>
  </div>
</template>

<script>
import Masonry from 'masonry-layout'

export default {
  props: ['idea'],

  computed: {
    contentClass () {
      return (this.idea.content && this.idea.content.length < 50) ? 'is-caption' : ''
    },

    contentColor () {
      return (this.idea.color && (parseInt(this.idea.color.replace('#', ''), 16) > 0xffffff / 2)) ? '#eee' : '#000'
    },

    attachments () {
      return (type) => {
        return this.idea.attachments.filter(item => item.type === type)
      }
    }
  },

  mounted () {
    this.masonry = new Masonry('.idea-grid', {
      columnWidth: '.idea-grid-sizer',
      itemSelector: '.idea',
      percentPosition: true,
      gutter: 10
    })
  }
}
</script>
