
window._ = require('lodash')

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie and the
 * API Authorization header
 */

window.axios = require('axios')

const csrfToken = document.head.querySelector('meta[name="csrf-token"]')
const apiToken = document.head.querySelector('meta[name="api-token"]')

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content
window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + apiToken.content
