import axios from 'axios'


export const mutations = {

  rightDrawerToggle(state, val) {
    if (val === 'none') {
      state.settings.rightDrawer = !state.settings.rightDrawer
    } else {
      state.settings.rightDrawer = val
    }
  },

  settingsDonatePage(state, settings) {
    state.settings.donate = settings
    console.log('update')
    state.settings.music = settings.music
  },

  stopAll(state, execpt) {
    state.stopExecpt = execpt
  },

  positionChangeMode(state, is_show) {
    state.positionChangeMode = is_show
  },

  addMusic(state, music) {
    state.settings.music.push(music)
  },

  setUser(state, user) {
    state.user = user
  },

  setType(state, type) {
    state.type = type
  },

  setPushId(state, push_id) {
    state.push_id = push_id
  },

  setToken(state, token) {
    state.token = token
  },

}
