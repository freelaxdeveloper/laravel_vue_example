<template>
<div>
    <!-- Это я буду копировать: Ib-Fd07laL0 | 1MRuvGKDshQ<br>
    <input type="text" v-model="videoID">
    <input type="submit" value="Добавить" @click="searchById(videoID), videoID = ''">
    <input type="submit" value="Замутить" @click="ended"> -->
  <div class="columns is-marginless">
    <!-- <div class="column is-paddingless">
      <SearchContent/>
    </div> -->
    <div class="column is-paddingless ">
      <div class="f-left w-100pct h-400px">
        <Player/>
      </div>
      <div v-if="showPlaylist" class="f-left w-100pct h-400calc ovf-auto">
        <Playlists/>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import axios from 'axios'
import SearchContent from '../components/SearchContent'
import Player from '../components/Player'
import Playlists from '../components/Playlists'
import { mapActions, mapGetters } from 'vuex'

Array.prototype.diff = function (a) {
  return this.filter(function (i) {
    return a.indexOf(i) < 0
  })
}

export default {
  name: 'YoutubePlaylist',
  components: {
    SearchContent,
    Player,
    Playlists
  },
  data () {
    return {
      videoID: '',
      list: []
    }
  },
  computed: {
    ...mapGetters([
      'showPlaylist',
      'playlists',
      'selected',
      'videoInfo',
      'token',
      'user'
    ])
  },
  methods: {
    ...mapActions([
      'removeFromPlaylist',
      'searchById',
      'ended'
    ]),
    fetchVideo () {
      axios.get(`/${this.user.id}/${this.token}/youtube`).then(response => {
        const data = response.data
        let listVideoIdOnly = []
        let listAll = []
        data.map(item => {
          listVideoIdOnly.push(item.video_id)
        })
        this.playlists.map(item => {
          listAll.push(item.id)
        })
        const videoNew = listVideoIdOnly.diff(listAll)

        // videoNew.map(item => {
        //   this.searchById(item)
        // })
        this.insertNewVideo(videoNew)
        this.synchronizationPlaylist(listVideoIdOnly)
      })
    },
    async insertNewVideo (videoList) {
      for (const item of videoList) {
        await this.searchById(item)
      }
    },
    synchronizationPlaylist (list) {
      let playlists = []
      this.playlists.map(item => {
        playlists.push(item.id)
      })
      let removed = playlists.diff(list)
      
      removed.map((videoID, i) => {
        const index = this.playlists.findIndex(x => x.id === videoID)
        removed.splice(i, 1)
        if (this.selected && this.selected.id === videoID) {
          this.ended(this.selected)
        } else {
          this.removeFromPlaylist(index)
        }
      })
      
    }
  },
  created () {
    this.fetchVideo()
    setInterval(() => {
      this.fetchVideo()
    }, 15000)
   }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.bg-cl-282828 {
  background-color: #282828;
}
.h-400px {
  height: 400px;
}
.h-400calc {
  height: calc(100vh - 400px);
}
div {
  box-sizing: border-box !important;
}
</style>
