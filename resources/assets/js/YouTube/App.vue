<template>
  <div id="app">
    <!-- <NavBar></NavBar> -->
    <router-view/>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import NavBar from './components/NavBar'

export default {
  name: 'App',
  components: {
    NavBar
  },
  methods: {
    ...mapActions([
      'initialization',
      'showPlaylist'
    ])
  },
  created () {
    this.initialization()

    if (this.$route.query.show) {
      this.showPlaylist(true)
    }
  }
}
</script>

<style>
</style>
