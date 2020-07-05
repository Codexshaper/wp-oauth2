try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.querySelector('#codexshaper-oauth-server-admin');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.getAttribute('csrf-token');
    window.axios.defaults.baseURL = token.getAttribute('base-url')+'/cos';
} else {
    console.error('CSRF token not found.');
}

import Vue from 'vue'
import App from './App.vue'
import store from './store'
import router from './router'

window.Swal = require('sweetalert2');
window.toastr = require('toastr');

toastr.options.closeButton = true

Vue.config.productionTip = false

import mixin from './mixin.js'
Vue.mixin(mixin)

/* eslint-disable no-new */
new Vue({
  el: '#codexshaper-oauth-server-admin',
  store,
  router,
  ...App
});
