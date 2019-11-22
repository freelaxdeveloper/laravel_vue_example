import Vue from 'vue'
import Vuex from 'vuex'
import { mutations, KEY_TOKEN, KEY_JWT } from './mutations'
import actions from './actions'

Vue.use(Vuex)

export const store = new Vuex.Store({
  state: {
    mainSettings: {

    },
    user: {
      id: null,
      profile_mode: ''
    },
    api_token: $cookies.get(KEY_TOKEN),
    jwt_token: $cookies.get(KEY_JWT),
    loader: false,
    errors: [],
    snackbar: {
      model: false,
      timeout: 2000,
      color: 'success',
      text: '',
    },
    settings: {
      logo: '/img/logo.png',
      design: 'dark',
      menu: 'default',
      rightDrawer: false,
      donate: {
        main: {
          bgImage: '',
          bgColor: '',
          bgVideo: ''
        },
        header: {
          fontFamily: '',
          color: ''
        },
        btnNext: {
          text: '',
          bgColor: ''
        },
        btnBack: {
          bgColor: ''
        },
        btnCanel: {
          bgColor: ''
        },
        btnDonat: {
          text: '',
          bgColor: ''
        },
        other: {
          donatevideolimit: 0
        }
      }
    },
  },
  actions,
  mutations,
})
