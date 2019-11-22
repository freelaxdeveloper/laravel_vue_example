import Vue from 'vue'
import Vuex from 'vuex'

import * as getters from './getters'
import * as mutations from './mutations'
import * as actions from './actions'

Vue.use(Vuex)

export const store = new Vuex.Store({
  strict: true,
  state: {
    token: '',
    user: {},
    searchResults: {
      items: []
    },
    videoInfo: {},
    playlists: [],
    selected: {},
    showPlaylist: false
  },
  getters,
  mutations,
  actions
})
