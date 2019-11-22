<template>
  <v-layout>
    <v-container fluid fill-height>
      <v-layout row wrap align-center v-if="user.id">
        <v-flex xs12 md4>
          <div class="text-xs-center">
            <v-avatar size="125px">
              <img
                class="img-circle elevation-7 mb-1"
                :src="user.avatar"
              >
            </v-avatar>
            <div class="headline" v-text="user.name"></div>
            <div class="subheading text-xs-center grey--text pt-1 pb-3" v-text="user.email"></div>
            <v-btn
              v-if="user.profile_mode === 'streamer'"
              @click="$router.push({name: 'StreamSettings'})"
              color="primary"
              small
            >Настройки</v-btn>
            <v-btn
              v-if="user.profile_mode === 'streamer'"
              @click="redirectMyVideo"
              color="primary"
              small
            >Мои видео</v-btn>
          </div>
          </v-flex>
          <v-flex xs12 sm6 md3 v-if="user.profile_mode === 'streamer'">

            <link-for-obs
              v-for="(link, i) in links"
              :key="`link_${i}`"
              :label="link.name" 
              :link="link.link"
            ></link-for-obs>

          </v-flex>
      </v-layout>
    </v-container>
  </v-layout>
</template>

<script>
import axios from 'axios'
import LinkForObs from '../components/LinkForObs'

export default {
  components: {
    LinkForObs
  },
  computed: {
    user: function () {
      return this.$store.state.user
    }
  },
  data () {
    return {
      links: []
    }
  },
  watch: {
    'user.profile_mode': function (val) {
      if (val === 'streamer') {
        this.fetchLinks()
      }
    }
  },
  methods: {
    redirectMyVideo () {
      const link = this.links.find(x => x.type === 'videoplay')
      window.location = `${link.link}/#/?show=1`
    },
    goLink (link) {
      window.location = `${link}/#/?settings=1`
    },
    goTransaction () {
      this.$router.push({name: 'Payment', params: {id: this.user.id}})
    },
    fetchLinks () {
      axios.get('/fetchlinks').then(response => {
        this.links = response.data
      })
    }
  },
  created () {
    if (this.user.profile_mode === 'streamer') {
      this.fetchLinks()
    }
  }
}
</script>

<style lang="scss" scoped>
  .img-circle {
    background-color: #fff;
  }
</style>
