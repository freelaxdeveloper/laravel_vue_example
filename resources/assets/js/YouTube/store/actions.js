import axios from 'axios'
import config from '../config/config'

export async function search ({ commit }, keyword) {
  try {
    const { data } = await axios.get(`https://www.googleapis.com/youtube/v3/search/?q=${keyword}&maxResults=25&part=snippet&key=${config.API_KEY}`)
    this.searchResult = data
    commit('setSearchResult', data)
  } catch (error) {
    console.log(error)
  }
}

export async function initialization ({ commit }) {
  try {
    const token = document.head.querySelector('meta[name="token"]')
    const user = document.head.querySelector('meta[name="user"]')

    commit('setToken', token.content)
    commit('setUser', JSON.parse(user.content))
  } catch (error) {
    console.log(error)
  }
}

export async function ended ({ state, dispatch }, video) {
  dispatch('removeFromPlaylist', 0)
  dispatch('selectVideo', {})
  if (!state.showPlaylist) {
    dispatch('removeFromDataBase', video)
  }
  if (state.playlists.length) {
    dispatch('selectVideo', state.playlists[0])
  }
}

export async function searchById ({ commit, dispatch }, videoId) {
  try {
    const { data } = await axios.get(`https://www.googleapis.com/youtube/v3/videos/?id=${videoId}&part=snippet,contentDetails,statistics&part=snippet&key=${config.API_KEY}`)
    this.videoInfo = data
    commit('setVideoResult', data)
    // console.log('dispatch video', data.items[0])
    dispatch('addToPlaylist', data.items[0])
  } catch (error) {
    console.log(error)
  }
}

export function selectVideo ({ commit }, video) {
  commit('setSelected', video)
}

export function showPlaylist ({ commit }, is_show) {
  commit('showPlaylist', is_show)
}

export function addToPlaylist ({ commit, state, dispatch }, video) {
  if (!state.playlists.length) {
    dispatch('selectVideo', video)
  }
  commit('addToPlaylist', video)
}

export function removeFromDataBase ({ state }, item) {
  axios.delete(`/${state.user.id}/${state.token}/youtube/${item.id}`).then(() => {
    
  })
}

export function removeFromPlaylist ({ commit }, index) {
  commit('removeFromPlaylist', index)
}

export function truncateFromPlaylist ({ commit }) {
  commit('truncateFromPlaylist')
}


