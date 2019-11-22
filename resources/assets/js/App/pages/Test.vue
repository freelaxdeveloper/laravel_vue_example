<template>
  <div>
    <video-bg :sources="['https://www.w3schools.com/html/mov_bbb.mp4']" img="someURL">
      <!-- If you want to add content here, a slot is waiting! -->
      </video-bg>
  </div>
</template>

<script>
import axios from 'axios'
import VideoBg from 'vue-videobg'

export default {
  components: {
    VideoBg
  },
  data () {
    return {
      icon: '',
      icons: []
    }
  },
  methods: {
    fetchIcons () {
      axios.get('/icons').then(response => {
        this.icons = response.data
      })
    }
  },
  created () {
    this.fetchIcons()
  }
}
</script>
