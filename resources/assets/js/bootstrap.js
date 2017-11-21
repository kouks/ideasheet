import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie and the
 * API Authorization header
 */

Vue.use(VueAxios, axios)

const csrfToken = document.head.querySelector('meta[name="csrf-token"]')
const apiToken = document.head.querySelector('meta[name="api-token"]')

Vue.prototype.$http.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
Vue.prototype.$http.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content
Vue.prototype.$http.defaults.headers.common['Authorization'] = 'Bearer ' + apiToken.content
