<template>
  <div>
    <nav class="navigation">
      <div class="container">
        <div class="nav-left">
          <!-- <router-link to="/">Home</router-link> -->
        </div>
        <div class="nav-right">
          <!-- <a href="#">Profile</a> -->
          <a href="#" @click.prevent="logout()">Logout</a>
        </div>
      </div>
    </nav>
    <slot />
  </div>
</template>

<script>
import Cookie from 'js-cookie'

export default {
  methods: {
    logout () {
      Cookie.remove('ideasheet_token')
      this.$router.push({ name: 'login' })
    }
  }
}
</script>
