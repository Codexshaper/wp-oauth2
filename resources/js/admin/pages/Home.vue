<template>
  <div class="home">
    <span>{{ msg }}</span>
  </div>
</template>

<script>
export default {

  name: 'Home',

  data () {
    return {
      msg: 'Welcome to Your Vue.js Admin App'
    }
  },
  mounted() {
  	axios.post('/csrf-token')
    .then(res => {
      console.log(res)
    })
    .catch(err => console.log(err));
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
