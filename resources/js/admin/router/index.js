import Vue from 'vue'
import Router from 'vue-router'
import Home from '../pages/Home.vue'
import Clients from '../pages/Clients.vue'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/clients',
      name: 'Clients',
      component: Clients
    },
  ]
})
