import Vue from 'vue'
import App from './App'
import axios from 'axios'
import store from './store'
import routes from './routes'
import Router from 'vue-router'
import VueAxios from 'vue-axios'

/**
 * First we will load all of this project's JavaScript dependencies as well as
 * various helper functions.
 */

require('./directives')
require('./helpers')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page.
 */

Vue.use(Router)
Vue.use(VueAxios, axios)

export default new Vue({
  components: { App },
  el: '#app',
  router: new Router({ routes, mode: 'history' }),
  store,
  template: '<App />'
})
