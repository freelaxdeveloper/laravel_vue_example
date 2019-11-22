<template>
  <div>
    <div class="f-left w-100pct mg-bt-10px" :key="index" v-for="(item, index) in playlists">
      <img class="f-left mg-r-10px" @click="selectVideo(item)" :src="item.snippet.thumbnails.default.url">
      <div class="mg-bt-10px">
        {{item.snippet.title}}
      </div>
      <button v-if="item.id !== selected.id" @click="remove(item, index)" class="button w-fit-content is-danger">Remove</button>
      <button v-else @click="removeFromDataBase(item), ended(item)" class="button w-fit-content is-danger">Skip</button>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  computed: {
    ...mapGetters([
      'playlists',
      'selected'
    ])
  },
  methods: {
    ...mapActions([
      'ended',
      'selectVideo',
      'removeFromPlaylist',
      'removeFromDataBase'
    ]),
    remove (item, index) {
      this.removeFromDataBase(item)
      this.removeFromPlaylist(index)
    }
  }
}
</script>
