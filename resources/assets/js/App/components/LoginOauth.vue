<template>
  <div>
    <v-btn round color="purple" @click="submit" :loading="btnLoading" :disabled="disabled" large>
      <v-icon left v-text="icon"/>
      {{ title }}
    </v-btn>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    disabled: {
      type: Boolean,
      default: false
    },
    icon: {
      type: String,
      required: true
    },
    title: {
      type: String,
      required: true
    },
    service: {
      type: String,
      required: true
    },
    is_streamer: {
      type: Boolean,
      default: true
    },
    redirect: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      btnLoading: false,
      // params: {
      //   code: this.$route.query.code,
      //   scope: this.$route.query.scope,
      //   state: this.$route.query.state,
      // },
    }
  },
  computed: {
    redirectDecode: function () {
      return window.atob(this.redirect)
    },
    redirectParams: function () {
      return this.redirectDecode.split('-')
    },
    redirectRoute: function () {
      if (this.redirectParams[0].length === 0) {
        return {href: ''}
      }
      let props = this.$router.resolve({ 
        name: this.redirectParams[0],
        params: { id: this.redirectParams[1] },
      });

      return props;
 
    },
    redirectHref: function () {
      return escape(this.redirectRoute.href)
    },
    locationHref: function () {
      let is_streamer =  this.is_streamer ? 1 : 0
      if (this.service === 'twitch') {
        return `/twitch/login?is_streamer=${is_streamer}&redirect=${this.redirectHref}`
      }
      if (this.service === 'google') {
        return `/oauth2callback?is_streamer=${is_streamer}&redirect=${this.redirectHref}`
      }

      return `/oauth/${this.service}?is_streamer=${is_streamer}&redirect=${this.redirectHref}`
    }
  },
  methods: {
    submit () {
      this.$store.dispatch('loader', true)
      this.btnLoading = true
      console.log( this.locationHref)
      window.location.href = this.locationHref
    }
  },
  created () {
    // console.log(this.redirectDecode.split('-'))
    // axios.get('/session/test').then(response => {
    //   console.log('sss', response.data)
    // })
    // axios.get('/twitch/login/rollback', {params: this.params}).then(response => {
    //   console.log('response', response.data)
    //   this.$store.dispatch('setToken', response.data.api_token)
    //   // this.$router.push({name: 'MyProfile'})
    // })

    // console.log(this.params)
  }
}
</script>
