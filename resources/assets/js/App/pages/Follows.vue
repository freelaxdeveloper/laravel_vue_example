<template>
  <v-layout row>
    <v-flex xs12 sm6 offset-sm3>

      <v-list subheader>
        <v-subheader>Мои подписчики</v-subheader>
      </v-list>

      <v-expansion-panel>
        <v-expansion-panel-content
          v-for="follow in follows"
          :key="follow._id"
        >
         
          <div slot="header" class="test">
            <v-list-tile avatar>
              <v-list-tile-avatar>
                <img :src="follow.logo">
              </v-list-tile-avatar>
              <v-list-tile-content>
                <v-list-tile-title>
                  {{ follow.display_name }}
                  <v-icon :color="follow.pivot.free ? 'white' : 'grey'">mdi-account-check</v-icon>
                  <v-icon :color="follow.pivot.paid ? '' : 'grey'">mdi-account-check</v-icon>
                  <v-icon :color="follow.pivot.premium ? '' : 'grey'">mdi-account-check</v-icon>
                </v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
          </div>
          <v-card v-if="follow.service.name === 'Twitch'">
            <v-card-text>
              {{ follow.bio }} 
              <v-btn 
                small 
                @click="fetchFollowInfo(follow._id)
              ">Подробнее</v-btn></v-card-text>
          </v-card>
        </v-expansion-panel-content>
      </v-expansion-panel>

    </v-flex>


    <v-dialog
      v-if="followInfo"
      v-model="followInfoDialog"
      max-width="500"
    >
      <v-card>
        <v-img
          :src="followInfo.profile_banner"
          aspect-ratio="2.75"
        ></v-img>
        <v-card-title class="headline">
          <v-list-tile avatar>
            
              <v-list-tile-avatar>
                <img :src="followInfo.logo">
              </v-list-tile-avatar>

              <v-list-tile-content>
                <v-list-tile-title>
                  {{followInfo.display_name}}
                </v-list-tile-title>
                <v-list-tile-sub-title>
                  
                  <v-chip
                    small
                    color="green lighten-4"
                    class="ml-0"
                  >
                    <v-avatar>
                      <v-icon>mdi-eye</v-icon>
                    </v-avatar>
                    {{ followInfo.views }} просмотров
                  </v-chip>
                  
                  <v-chip
                    color="green lighten-4"
                    class="ml-0"
                    small
                  >
                    <v-avatar>
                      <v-icon>mdi-account-group</v-icon>
                    </v-avatar>
                    {{ followInfo.followers }} подписчиков
                  </v-chip>
                  
                  <!-- <v-chip
                    :color="`green lighten-4`"
                    class="ml-0"
                    label
                    small
                  >{{ followInfo.game }}</v-chip> -->

                </v-list-tile-sub-title>
              </v-list-tile-content>

            </v-list-tile>
          </v-card-title>

        <!-- <v-card-text>
           <v-chip
              :color="`green lighten-4`"
              class="ml-0"
              label
              small
            >
              4 new
            </v-chip>
        </v-card-text> -->

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn
            color="green darken-1"
            flat="flat"
            @click="followInfoDialog = false"
          >
            Закрыть
          </v-btn>

        </v-card-actions>
      </v-card>
    </v-dialog>

  </v-layout>
</template>

<style>
  .v-expansion-panel__header {
    padding: 0;
  }
</style>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      follows: [],
      followInfo: null,
      followInfoDialog: false,
    }
  },
  methods: {
    fetchFollowInfo(channel) {
      this.$store.dispatch('loader', true)
      // this.followInfo = channel
      axios.get('/twitch/channels/' + channel).then(response => {
        console.log('response', response.data)
        this.followInfo = response.data
        this.$store.dispatch('loader', false)
      })
    },
    fetchfollows() {
      this.$store.dispatch('loader', true)
      // axios.get('/twitch/followsList').then(response => {
      //   this.follows = response.data.follows
      //   this.$store.dispatch('loader', false)
      // })

      axios.get('/subscribers').then(response => {
        this.follows = response.data
        this.$store.dispatch('loader', false)
      })
    }
  },
  created() {
    this.fetchfollows()
  },
  watch: {
    followInfo: function (val) {
      if (null !== val) {
        this.followInfoDialog = true
      }
    },
    followInfoDialog: function (val) {
      if (false === val) {
        this.followInfo = null
      }
    },
  },
}
</script>
