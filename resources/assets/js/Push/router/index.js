import Vue from 'vue'

import Router from 'vue-router'

Vue.use(Router)

import Donate from '../pages/Donate'
import DonateV2 from '../pages/DonateV2'
import Test from '../pages/Test'

export default new Router({
  routes: [
    { path: '/', name: 'Donate', component: DonateV2, },
    { path: '/test', name: 'Test', component: Test, },
  ]
})
