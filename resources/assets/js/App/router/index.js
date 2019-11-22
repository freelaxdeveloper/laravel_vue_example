import Vue from 'vue'

import Router from 'vue-router'

Vue.use(Router)

import { store } from '../store/store.js';

const ifAuthenticated = (to, from, next) => {
  if (store.state.api_token) {
    next()
    return
  }
  next('/login')
}

const ifNotAuthenticated = (to, from, next) => {
  if (!store.state.api_token) {
    next()
    return
  }
  next('/')
}

import Home from '../pages/Home'
import Login from '../pages/Login'
import Logout from '../pages/Logout'
// import Register from '../pages/Register'
// import RecoverPassword from '../pages/RecoverPassword'
import MyProfile from '../pages/MyProfile'
import Profile from '../pages/Profile'
import Follows from '../pages/Follows'
// import Transaction from '../pages/Transaction'
import Donate from '../pages/Donate'
import UserSubscribe from '../pages/UserSubscribe'
import MakePayment from '../pages/MakePayment'
import StreamSettings from '../pages/StreamSettings/index'
import ErrorPage from '../pages/Error'
import Test from '../pages/Test'
import Private from '../pages/Privacy/Private'
import Services from '../pages/Privacy/Services'
import Conditions from '../pages/Privacy/Conditions'
import Privacy from '../pages/Privacy'
import Help from '../pages/Help'
import MySocial from '../pages/MySocial'
// import TestImg from '../pages/TestImg'

export default new Router({
  // mode: 'history',
  routes: [
    { path: '/', name: 'Home', component: Home, },
    { path: '/testimg', name: 'TestImg', component: () => import('../pages/TestImg.vue'), },
    { path: '/privacy', name: 'Privacy', component: Privacy, },
    { path: '/help', name: 'Help', component: Help, },
    { path: '/privacy/conditions', name: 'Conditions', component: Conditions, },
    { path: '/privacy/services', name: 'Services', component: Services, },
    { path: '/privacy/private', name: 'Private', component: Private, },
    { path: '/make/payment/:orderId/:userId', name: 'MakePayment', component: MakePayment, },
    { path: '/error/:message', name: 'ErrorPage', component: ErrorPage, },
    { path: '/test', name: 'Test', component: Test, },
    { path: '/stream/settings', name: 'StreamSettings', component: StreamSettings, beforeEnter: ifAuthenticated, },
    { path: '/profile/social/:redirect?', name: 'MySocial', component: MySocial, beforeEnter: ifAuthenticated, },
    { path: '/usersubscribe/:id', name: 'UserSubscribe', component: UserSubscribe },
    { path: '/payment/:id', name: 'Payment', component: Donate, props: true, },
    { path: '/login/:redirect?', name: 'Login', component: Login, beforeEnter: ifNotAuthenticated, meta: {title: 'Авторизация'} },
    // { path: '/twitch/login/rollback', name: 'LoginTwitch', component: LoginTwitch, props: true,},
    { path: '/logout', name: 'Logout', component: Logout, beforeEnter: ifAuthenticated, },
    // { path: '/register', name: 'Register', component: Register, },
    { path: '/profile', name: 'MyProfile', component: MyProfile, beforeEnter: ifAuthenticated, },
    { path: '/profile/:id', name: 'Profile', component: Profile, props: true, },
    { path: '/follows', name: 'Follows', component: Follows, beforeEnter: ifAuthenticated, },
    { path: '/transaction', name: 'Transaction', component: () => import('../pages/Transaction.vue'), beforeEnter: ifAuthenticated, },
  ]
})
