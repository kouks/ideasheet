<template>
  <div :class="['idea-content', contentClass]" v-show="content">
    {{ content }}
  </div>
</template>

<script>
export default {
  props: ['content'],

  computed: {
    contentClass () {
      return (this.content && this.content.length < 50) ? 'is-caption' : ''
    }
  }
}
</script>
