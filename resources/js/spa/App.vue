<template>
  <div id="vue-frontend-app">
    <div class="container">
      <h2>{{ appName }} App</h2>
    </div>
    

    <router-link to="/">Home</router-link>
    <router-link to="/login">Login</router-link>

    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App',
  data: () => ({
  	appName: 'Spa'
  }),
  mounted() {
  	axios.post('http://localhost/laravel-woocommerce/csrf-token', {token: 'hello', 'wbp_nonce': 'my_nonce'})
    .then(res => {
      console.log(res)
    })
    .catch(err => {
      console.log(err.response)
    });
  }
}
</script>

<style lang="css">
.container {
  width: 100px;
  margin: 0px auto;
}
</style>
