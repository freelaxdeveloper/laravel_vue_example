<template>
  <v-container>
    <v-layout v-if="user" row wrap>
      <v-flex xs12 d-flex>
        <v-flex xs6>
        <img
          class="img-circle elevation-7 mb-1"
          :src="user.avatar"
        >
        </v-flex>
        <v-flex xs6>
        <div class="headline" v-text="user.name"></div>
        </v-flex>
      </v-flex>
      <v-flex xs12 v-if="subscribe">
        Вы пописаны до: {{ subscribe }}
      </v-flex>
      <v-flex xs12>
        <v-btn color="primary" @click="goTransaction">Донатить</v-btn>
        <v-btn 
          color="primary" 
          @click="premiumsubscribe"
          v-text="subscribe ? 'Продлить подписку' : 'Подписаться'"
        >Подписаться</v-btn>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import axios from 'axios'

export default {
  data () {
    return {
      user: null,
      subscribe: false
    }
  },
  computed: {
    user_id: function () {
      return this.$route.params.id
    }
  },
  methods: {
    goTransaction () {
      this.$router.push({name: 'Payment', params: {id: this.user_id}})
    },
    fetchUserInfo () {
      axios.get('/user/info/' + this.user_id).then(response => {
        this.user = response.data
      }).catch(() => {
        this.$store.dispatch('snackbar', {text: 'Пользователь не найден', color: 'error'})
        this.$router.go(-1)
      })
    },
    checkSubscribe () {
      axios.get(`/premium/${this.user_id}/checksubscribe/`).then(response => {
        this.subscribe = response.data
      })
    },
    premiumsubscribe () {
      this.$router.push({name: 'UserSubscribe', params: {id: this.user_id}})
      // axios.post(`/premium/${this.user_id}/premiumsubscribe`, {mounth: 2}).then(response => {
      //   this.subscribe = response.data
      // })
    }
  },
  created () {
    this.fetchUserInfo()
    this.checkSubscribe()
  },
  watch: {
    user_id: function () {
      this.fetchUserInfo()
      this.checkSubscribe()
    }
  }
}
</script>
