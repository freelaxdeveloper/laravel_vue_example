import axios from 'axios'

export const KEY_TOKEN = 'user-token'
export const KEY_JWT = 'user-jwt'

export const mutations = {
  loader(state, isLoader) {
    state.loader = isLoader
  },

  mainSettings(state, settings) {
    state.mainSettings = settings
  },

  setToken(state, api_token) {
    // axios.defaults.headers.common['Authorization'] = 'Bearer ' + api_token
    $cookies.set(KEY_TOKEN, api_token)
    // localStorage.setItem(KEY_TOKEN, api_token)
    state.api_token = api_token
  },

  setJWTToken(state, jwt_token) {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + jwt_token
    $cookies.set(KEY_JWT, jwt_token)
    state.jwt_token = jwt_token
  },

  setUser(state, user) {
    // localStorage.setItem(KEY_USER, JSON.stringify(user))
    state.user = user
  },

  setDesign(state, design) {
    state.settings.design = design
    switch (design) {
      case 'light':
        state.settings.logo = '/img/logo_light.png'
      break;
      case 'dark':
        state.settings.logo = '/img/logo.png'
      break;
    }
  },

  errors(state, errors) {
    state.errors = Object.values(errors)
  },

  rightDrawerToggle(state, val) {
    if (val === 'none') {
      state.settings.rightDrawer = !state.settings.rightDrawer
    } else {
      state.settings.rightDrawer = val
    }
  },

  rightDrawerChange(state, val) {
    state.settings.menu = val
  },

  settingsDonatePage(state, settings) {
    state.settings.donate = settings
  },

  snackbar(state, snackbar) {
    state.snackbar.model = true
    state.snackbar.text = snackbar.text
    state.snackbar.color = snackbar.color || 'success'
  },

  logout(state) {
    delete axios.defaults.headers.common['Authorization']
    localStorage.clear()
    $cookies.remove(KEY_TOKEN);
    $cookies.remove(KEY_JWT);
    state.user = {
      id: null,
      profile_mode: null,
    }
    state.loader = null
    state.api_token = null
    state.jwt_token = null
  },

}
