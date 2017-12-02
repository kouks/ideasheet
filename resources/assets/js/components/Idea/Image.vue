<template>
  <div class="idea-image">
    <img :src="image" alt="Attachment Image">
  </div>
</template>

<script>
export default {
  props: ['image']
}
</script>
