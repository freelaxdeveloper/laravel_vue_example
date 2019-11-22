import Vue from 'vue'
import Vuex from 'vuex'
import { mutations } from './mutations'
import actions from './actions'

Vue.use(Vuex)

export const store = new Vuex.Store({
  state: {
    positionChangeMode: false,
    loader: false,
    errors: [],
    token: null,
    type: null,
    push_id: null,
    user: null,
    snackbar: {
      model: false,
      timeout: 2000,
      color: 'success',
      text: '',
    },
    stopExecpt: null,
    settings: {
      rightDrawer: false,
      donate: {
        main: {
          grid: {
            xs6: false,
            xs12: true,
            image: 'right'
          },
          minVoice: '',
          minDonate: '',
          sound: {
            src: '/4.mp3',
            volume: 9
          }
        },
        image: {
          color: '',
          tile: false,
          size: 175,
          src: 'https://media3.giphy.com/media/1AIP2ZGpgMj9tGTO7b/giphy.gif?cid=3640f6095bbfa6602e46563067ee5145'
        },
        video: {
          src: ''
        },
        name: {
          color: '',
          size: 17,
          font: ''
        },
        amount: {
          color: '',
          size: 17,
          font: ''
        },
        message: {
          color: '',
          size: 17,
          font: ''
        },
        attachment: {},
        position: {
          title: {},
          counter: {},
          message: {},
          attachment: {},
        }
      },
      music: []
    },
  },
  actions,
  mutations,
})
