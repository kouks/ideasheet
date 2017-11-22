import Vue from 'vue'
import App from './App'
import routes from './routes'
import Router from 'vue-router'

/**
 * First we will load all of this project's JavaScript dependencies as well as
 * various helper functions.
 */

require('./bootstrap')
require('./directives')
require('./helpers')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page.
 */

Vue.use(Router)

export default new Vue({
  components: { App },
  el: '#app',
  router: new Router({ routes, mode: 'history' }),
  template: '<App />'
})
