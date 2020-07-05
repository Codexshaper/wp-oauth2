import Vue from 'vue'
import App from './App.vue'
import store from './store'
import router from './router'
window.toastr = require('toastr');

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#vue-frontend-app',
  store,
  router,
  render: h => h(App)
})
