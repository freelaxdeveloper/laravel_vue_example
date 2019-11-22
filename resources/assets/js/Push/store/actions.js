export default {

  stopAll({ commit }, execpt) {
    commit('stopAll', execpt)
  },

  positionChangeMode({ commit }, is_show) {
    commit('positionChangeMode', is_show)
  },

  addMusic({ commit }, music) {
    commit('addMusic', music)
  },

  setUser({ commit }, user) {
    commit('setUser', user)
  },

  setToken({ commit }, token) {
    commit('setToken', token)
  },

  setType({ commit }, type) {
    commit('setType', type)
  },

  setPushId({ commit }, push_id) {
    commit('setPushId', push_id)
  },

  rightDrawerToggle({ commit }, val = 'none') {
    commit('rightDrawerToggle', val)
  },

  settingsDonatePage({ commit }, settings) {
    commit('settingsDonatePage', settings)
  },
}