<template>
  <a
    :href="link"
    class="idea-link"
    target="_blank"
  >
    {{ link }}
  </a>
</template>

<script>
export default {
  props: ['link']
}
</script>
