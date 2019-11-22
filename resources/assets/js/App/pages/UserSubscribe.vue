<template>
  <v-layout>
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md5>
            <v-card v-if="user.id">
              <v-toolbar
                color="deep-purple accent-4"
                cards
                dark
                flat
              >
                <v-btn icon @click="$router.push({name: 'Profile', params: {id: user_id}})">
                  <v-icon>mdi-arrow-left</v-icon>
                </v-btn>
                <v-card-title class="title font-weight-regular" v-text="user.name">Sign up</v-card-title>
              </v-toolbar>
              <v-card-title primary-title>
                Какой-то текст о том, как классно иметь премиум подписку
              </v-card-title>
              <v-card-title v-if="subscribe">
                Подписка оформлена до: {{ subscribe }}
              </v-card-title>
              <v-card-title>
                <v-btn
                  v-if="!premiumsubscribe"
                  color="primary"
                  @click="premiumsubscribe = true"
                  v-text="subscribe ? 'Продлить подписку' : 'Подписаться'"
                >
                  Подписаться
                </v-btn>
              </v-card-title>
              <div v-if="premiumsubscribe">
                <div class="text-xs-center">
                  Выберите на сколько месяцев подписываетесь:
                  <v-rating v-model="mounth" :length="length" :readonly="loading">
                    <v-icon
                      slot="item"
                      slot-scope="props"
                      :color="props.isFilled ? genColor(props.index) : 'grey lighten-1'"
                      large
                      @click="props.click"
                    >
                      {{ props.isFilled ? 'mdi-star-circle' : 'mdi-circle-outline' }}
                    </v-icon>
                  </v-rating>
                </div>
                <p class="pa-2">
                  Месяцев: {{mounth}}<br>
                  Всего к оплате: {{ totalPayment }}руб.
                </p>
                <p class="pa-2">
                  <v-card-actions>
                    <v-btn flat @click="cancel">Отмена</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="primary"
                      :loading="loading" 
                      @click="subscribed"
                      v-text="subscribe ? 'Продлить' : 'Подписаться'"
                    ></v-btn>
                  </v-card-actions>
                </p>
              </div>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-layout>
</template>

<script>
import axios from 'axios'

export default {
  data () {
    return {
      loading: false,
      premiumsubscribe: false,
      user_id: this.$route.params.id,
      subscribe: null,
      user: {
        id: ''
      },
      colors: ['white', 'white', 'green', 'green', 'orange', 'red'],
      mounth: 1,
    }
  },
  computed: {
    price: function () {
      return this.settings.subscribers.costPremium
    },
    settings: function () {
      return this.$store.state.mainSettings
    },
    length () {
      let length = this.mounth + 1

      if (length < 6) {
        length = 6
      }
      return length
    },
    totalPayment () {
      return this.mounth * this.price
    }
  },
  methods: {
    cancel () {
      this.premiumsubscribe = false
      this.loading = false
      this.mounth = 1
    },
    subscribed () {
      this.loading = true
      axios.post(`/premium/${this.user_id}/premiumsubscribe`, {mounth: this.mounth}).then(response => {
        this.$store.dispatch('snackbar', {text: response.data.message})
        this.$router.push({name: 'MakePayment', params: {
          orderId: response.data.order_id,
          userId: this.user_id
        }})
        // this.subscribe = response.data
        this.cancel()
      }).catch(error => {
        this.$store.dispatch('errors', error.response.data.errors)
        this.cancel()
      })
    },
    genColor (i) {
      return i < this.colors.length ? this.colors[i] : 'red'
    },
    checkSubscribe () {
      axios.get(`/premium/${this.user_id}/checksubscribe/`).then(response => {
        this.subscribe = response.data
        this.$store.dispatch('loader', false)
      })
    },
    fetchUser () {
      this.$store.dispatch('loader', true)
      axios.get('/user/info/' + this.user_id).then(response => {
        this.user = response.data
      }).catch(() => {
        this.$store.dispatch('snackbar', {text: 'Пользователь не найден', color: 'error'})
        // this.$router.go(-1)
      })
    },
  },
  created () {
    this.fetchUser()
    this.checkSubscribe()
  }
}
</script>
