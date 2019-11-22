
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


import Vue from 'vue'
import VueHead from 'vue-head'
import VueCookies from 'vue-cookies'
import App from './App'
import VueClipboard from 'vue-clipboard2'
import AnimateCss from 'v-animate-css';
import Swimlane from 'vue-swimlane'

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.scss'

import router from './router'
import { store } from './store/store.js';
import CxltToastr from 'cxlt-vue2-toastr'
import 'cxlt-vue2-toastr/dist/css/cxlt-vue2-toastr.css'

Vue.use(CxltToastr, {
    position: 'top right',
    timeOut: 3000,
    // progressBar: true,
    showMethod: 'slideInRight'
    // hideDuration: 1000
})
import ruLocale from 'vuetify/es5/locale/ru'
Vue.use(Vuetify, {
    lang: {
      current: 'ru',
      locales: { ru: ruLocale }
    },    
    theme: {
      primary: "#6278f5",
      secondary: "#e57373",
      accent: "#9c27b0",
      error: "#f44336",
      warning: "#d09309",
      info: "#2196f3",
      success: "#4caf50"
    },
})
Vue.use(VueHead)
Vue.use(VueCookies)
Vue.use(VueClipboard)
Vue.use(AnimateCss)
Vue.use(Swimlane)

import axios from 'axios'
import { config } from './config'

axios.defaults.baseURL = config.baseURL
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// axios.defaults.headers.common['Authorization'] = 'Bearer fsdfsdfdsf'
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
router.beforeEach((to, from, next) => {
    if (typeof to.meta.title !== 'undefined') {
        document.title = `Donation Support - ${to.meta.title}`
    } else {
        document.title = 'Donation Support'
    }
    next()
})

const app = new Vue({
    store,
    router,
    el: '#app',
    template: '<App/>',
    components: { App },
    head: {
        meta: [
          {
            name: 'viewport',
            content: 'width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover'
          }
        ]
    },
});
