<template>
  <div class="idea" :style="{ background: idea.color, color: contentColor }">
    <idea-content :content="idea.content" />

    <idea-tags :tags="idea.tags"/>

    <idea-snippet :key="id" :snippet="content" v-for="{ id, content } in snippets" />

    <idea-link :key="id" :link="content" v-for="{ id, content } in links" />

    <idea-image :key="id" :image="content" v-for="{ id, content } in images" />
  </div>
</template>

<script>
import Masonry from 'masonry-layout'
import Attachment from '@/enums/Attachment'
import IdeaLink from '@/components/Idea/Link'
import IdeaTags from '@/components/Idea/Tags'
import IdeaImage from '@/components/Idea/Image'
import IdeaContent from '@/components/Idea/Content'
import IdeaSnippet from '@/components/Idea/Snippet'

export default {
  props: ['idea'],

  components: { IdeaContent, IdeaTags, IdeaSnippet, IdeaLink, IdeaImage },

  computed: {
    attachments () {
      return type => this.idea.attachments.filter(idea => idea.type === type)
    },

    snippets () {
      return this.attachments(Attachment.CODE_SNIPPET)
    },

    links () {
      return this.attachments(Attachment.LINK)
    },

    images () {
      return this.attachments(Attachment.IMAGE)
    },

    contentColor () {
      return (this.color && (parseInt(this.color.replace('#', ''), 16) > 0xffffff / 2)) ? '#eee' : '#000'
    }
  },

  mounted () {
    this.$nextTick(() => {
      this.masonry = new Masonry('.idea-grid', {
        columnWidth: '.idea-grid-sizer',
        itemSelector: '.idea',
        percentPosition: true,
        gutter: 10
      })
    })
  }
}
</script>
