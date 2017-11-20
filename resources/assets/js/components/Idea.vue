<template>
  <div class="column is-4">
    {{ idea.content }}

    <a :href="`/#${tag.name}`" v-for="tag in idea.tags">#{{ tag.name }} </a>
  </div>
</template>

<script>
export default {
  props: ['idea']
}
</script>
