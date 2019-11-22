export default {

  loader({ commit }, loader) {
    commit('loader', loader)
  },

  mainSettings({ commit }, settings) {
    commit('mainSettings', settings)
  },

  setToken({ commit }, api_token) {
    commit('setToken', api_token)
    commit('snackbar', {text: 'Вы успешно авторизовались'})
  },

  setJWTToken({ commit }, jwt_token) {
    commit('setJWTToken', jwt_token)
  },

  setUser({ commit }, user) {
    commit('setUser', user)
  },

  rightDrawerToggle({ commit }, val = 'none') {
    commit('rightDrawerToggle', val)
  },

  rightDrawerChange({ commit }, val) {
    commit('rightDrawerChange', val)
  },

  settingsDonatePage({ commit }, settings) {
    commit('settingsDonatePage', settings)
  },

  setDesign({ commit }, design) {
    commit('setDesign', design)
  },

  logout({ commit }) {
    commit('logout')
  },

  errors({ commit }, errors) {
    commit('errors', errors)
  },

  snackbar({ commit }, snackbar) {
    commit('snackbar', snackbar)
  },
}