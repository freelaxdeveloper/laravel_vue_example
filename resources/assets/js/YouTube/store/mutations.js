export const setSearchResult = (state, playload) => {
  state.searchResults = playload
}

export const setVideoResult = (state, playload) => {
  state.videoInfo = playload
}

export const setToken = (state, token) => {
  state.token = token
}

export const setUser = (state, user) => {
  state.user = user
}

export const setSelected = (state, video) => {
  state.selected = video
}

export const addToPlaylist = (state, video) => {
  state.playlists.push(video)
}

export const removeFromPlaylist = (state, index) => {
  state.playlists.splice(index, 1)
}

export const truncateFromPlaylist = (state) => {
  state.playlists = []
}

export const showPlaylist = (state, is_show) => {
  state.showPlaylist = is_show
}
