<template>
  <div id="vue-backend-app">
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App',

  mounted() {
  	// console.log(this.token.csrf)
  	// this.csrf_token()
  }
}
</script>

<style lang="css">
  @import '~bootstrap/dist/css/bootstrap.css';
</style>
