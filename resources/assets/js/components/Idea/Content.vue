<template>
  <div :class="['idea-content', contentClass]" v-show="content" :style="{ background: color, color: contentColor }">
    {{ content }}
  </div>
</template>

<script>
export default {
  props: ['content', 'color'],

  computed: {
    contentClass () {
      return (this.content && this.content.length < 50) ? 'is-caption' : ''
    },

    contentColor () {
      return (this.color && (parseInt(this.color.replace('#', ''), 16) > 0xffffff / 2)) ? '#eee' : '#000'
    }
  }
}
</script>
