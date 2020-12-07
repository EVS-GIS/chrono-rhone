import VueRouter from 'vue-router'
import store from '../store'
import Home from '../components/pages/Home'
import TimelinePage from '../components/pages/TimelinePage'
import Map from '../components/pages/Map'
import Documentation from '../components/pages/Documentation'
import Login from '../components/pages/auth/Login'
import ForgotPassword from '../components/pages/auth/ForgotPassword'
import ResetPassword from '../components/pages/auth/ResetPassword'
import Users from '../components/pages/admin/Users'
import Roles from '../components/pages/admin/Roles'
import Thematics from '../components/pages/admin/Thematics'
import Themes from '../components/pages/admin/Themes'
import Relationships from '../components/pages/admin/Relationships'
import Events from '../components/pages/account/Events'
import Images from '../components/pages/account/Images'
import Me from '../components/pages/account/Me'

const ifAuthenticated = (to, from, next) => {
  if (!store.getters.isAuthenticated) {
    next()
    return
  }
  next('/')
}

const ifNotAuthenticated = (to, from, next) => {
  if (store.getters.isAuthenticated) {
    next()
    return
  }
  next('/login')
}

const ifAdmin = (to, from, next) => {
  if (store.getters.isAdmin && store.getters.isAuthenticated) {
    next()
    return
  }
  next('/login')
}

let router = new VueRouter({
  mode: 'history',
  routes: [
    { path: '/', name: 'Home', component: Home },
    { path: '/timeline', name: 'TimelinePage', component: TimelinePage },
    { path: '/map', name: 'Map', component: Map },
    { path: '/documentation', name: 'Documentation', component: Documentation },
    { path: '/login', name: 'Login', component: Login, beforeEnter: ifAuthenticated },
    { path: '/forgot-password', name: 'ForgotPassword', component: ForgotPassword },
    { path: '/password/reset/:token', name: 'ResetPassword', component: ResetPassword },
    { path: '/users', name: 'Users', component: Users, beforeEnter: ifAdmin },
    { path: '/roles', name: 'Roles', component: Roles, beforeEnter: ifAdmin },
    { path: '/thematics', name: 'Thematics', component: Thematics, beforeEnter: ifAdmin },
    { path: '/themes', name: 'Themes', component: Themes, beforeEnter: ifAdmin },
    { path: '/relationships', name: 'Relationships', component: Relationships, beforeEnter: ifAdmin },
    { path: '/events', name: 'Events', component: Events, beforeEnter: ifNotAuthenticated },
    { path: '/images', name: 'Images', component: Images, beforeEnter: ifNotAuthenticated },
    { path: '/me', name: 'Me', component: Me, beforeEnter: ifNotAuthenticated },
    { path: '*', redirect: '/' }
  ]
})

export default router
