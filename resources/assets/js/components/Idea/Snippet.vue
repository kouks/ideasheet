<template>
  <div class="idea-snippet">
    <code>{{ snippet.replaceAll('`', '') }}</code>
  </div>
</template>

<script>
export default {
  props: ['snippet']
}
</script>
