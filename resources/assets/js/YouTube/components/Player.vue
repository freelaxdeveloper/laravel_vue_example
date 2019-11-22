<template>
  <div class="h-100pct dp-flex f-drt-column jtf-ct-center">
    <youtube
      v-if="videoId !== ''"
      class="f-left w-100pct"
      :video-id="videoId"
      @ended="ended(selected)"
      :player-vars="{ autoplay: !showPlaylist }"
      player-width="100%">
    </youtube>
  </div>
</template>

<script>
import axios from 'axios'

import { mapGetters, mapActions } from 'vuex'
export default {
  computed: {
    ...mapGetters([
      'showPlaylist',
      'playlists',
      'selected',
      'token',
      'user'
    ]),
    videoId () {
      if (!this.selected || !this.selected.id) {
        return ''
      }
      let video = this.selected.id
      return typeof video === 'object' ? this.selected.id.videoId : this.selected.id
    },
    title () {
      return this.selected && this.selected.id ? this.selected.snippet.title : ''
    }
  },
  methods: {
    ...mapActions([
      'removeFromPlaylist',
      'selectVideo',
      'ended'
    ])
  }
}
</script>

<style>
  body, html {
    overflow:  hidden;
    background-color: #0000;
  }
</style>
