import Index from '@/components/Index'
import Login from '@/components/Auth/Login'
import Register from '@/components/Auth/Register'
import auth from '@/middleware/auth'

export default [
  {
    path: '/',
    component: Index,
    name: 'home',
    beforeEnter: auth
  },
  {
    path: '/login',
    component: Login,
    name: 'login'
  },
  {
    path: '/register',
    component: Register,
    name: 'register'
  }
]
