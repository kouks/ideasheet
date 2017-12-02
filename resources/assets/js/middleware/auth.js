import Vue from 'vue'
import Cookie from 'js-cookie'

const handle = (to, from, next) => {
  addAuthorizationHeader()

  Vue.prototype.$http.get('/api/v1/user')
    .then((response) => {
      Vue.prototype.$user = response.data

      next()
    })
    .catch(({ response }) => {
      next({ name: 'login' })
    })
}

const addAuthorizationHeader = () => {
  let token = Cookie.get('ideasheet_token')

  Vue.prototype.$http.defaults.headers.common['Authorization'] = `Bearer ${token}`
}

export default handle
