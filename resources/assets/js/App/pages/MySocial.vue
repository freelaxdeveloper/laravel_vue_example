<template>
  <v-layout>
    <v-container fluid fill-height v-if="user.id">
      <login-oauth 
        :redirect="redirectAfterAuth" 
        :is_streamer="true"
        icon="mdi-twitch"
        title="TWITCH"
        service="twitch"
        :disabled="user.social_twitch"
      />
     <login-oauth 
        :redirect="redirectAfterAuth" 
        :is_streamer="true"
        icon="mdi-youtube"
        title="YouTube"
        service="google"
        :disabled="user.social_youtube"
      />
     <login-oauth 
        :redirect="redirectAfterAuth" 
        :is_streamer="true"
        icon="mdi-vk"
        title="VK"
        service="vkontakte"
        :disabled="user.social_vkontakte"
      />
    </v-container>
  </v-layout>
</template>

<script>
import LoginOauth from '../components/LoginOauth'

export default {
  components: {
    LoginOauth
  },
  data () {
    return {
      redirectAfterAuth: ''
    }
  },
  computed: {
    user: function () {
      return this.$store.state.user
    }
  },
  created () {
    this.redirectAfterAuth = window.btoa(`MySocial-0`)
  }
}
</script>