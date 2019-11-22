<template>

  <div>
  <v-container v-if="pageLoaded" fluid fill-height :style="pageSettings.main.bg === 'color' ? `background-color: ${pageSettings.main.bgColor};` : ''">

    <v-layout :justify-center="justifyCenter" :justify-start="justifyStart" :justify-end="justifyEnd" wrap>
      <v-flex xs12 class="text-xs-center">
        <v-btn v-if="!jwt_token" @click="$router.push({name: 'Login', params: {redirect: redirectAfterAuth}})">Авторизоваться</v-btn>
        <v-btn v-else-if="!subscribe" @click="$router.push({name: 'UserSubscribe', params: {id: user_id}})">Подписаться</v-btn>
      </v-flex>
      <v-flex xs12 md6>
      <v-stepper :light="pageSettings.main.light" v-model="e1" v-if="user.id && settings && donateInfo">
        <v-stepper-header :class="pageSettings.header.fontFamily" :style="`background: ${pageSettings.header.bgColor};`">
          <v-stepper-step :complete="e1 > 1" step="1"><span :style="headerStyle">Анкета</span></v-stepper-step>

          <v-divider></v-divider>

          <!-- <v-stepper-step :complete="e1 > 2" step="2"><span :style="headerStyle">Карта</span></v-stepper-step>

          <v-divider></v-divider> -->

          <v-stepper-step :complete="e1 > 3" step="3"><span :style="headerStyle">Вид</span></v-stepper-step>

          <v-divider></v-divider>

          <v-stepper-step step="4"><span :style="headerStyle">Проверка данных</span></v-stepper-step>
        </v-stepper-header>

        <v-stepper-items>
          <v-stepper-content step="1">
            <v-card>
              <v-card-text>

                <!-- <animate-text text="Animate mnogo texta" animate="bounce"></animate-text>

                <text-marquee content="Я бегаю =)" :speed="50"></text-marquee> -->
                <v-form v-model="valid">
                  <v-layout row wrap>
                    <v-flex xs12>
                      <v-switch
                        color="primary"
                        label="Анонимно"
                        v-model="anonim"
                      ></v-switch>
                      <v-text-field
                        :readonly="anonim"
                        v-model="form.ank.login"
                        :rules="nameRules"
                        label="Ваш логин"
                        :counter="15"
                        required
                        box
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                      <v-textarea
                        box
                        required
                        :counter="256"
                        label="Сообщение"
                        :rules="messageRules"
                        v-model="form.ank.message"
                      ></v-textarea>
                    </v-flex>
                    <v-flex xs12>
                      <v-text-field
                        v-model="form.amount"
                        :rules="amountRules"
                        label="Сколько донатить? (руб.)"
                        required
                        box
                      ></v-text-field>
                      <span 
                        v-if="pageSettingstest.main.minDonate"
                        class="caption grey--text text--darken-1"
                        v-text="`Минимальная сумма доната: ${pageSettingstest.main.minDonate}руб.`"
                      ></span>
                    </v-flex>
                  </v-layout>
                </v-form>
              </v-card-text>
            </v-card>

            <actions
              :settings="pageSettings"
              :backClick="() => {$router.go(-1)}"
              :nextClick="() => {e1 = 3}"
              :user="user"
              :btnCanelStyle="btnCanelStyle"
              :valid="valid"
            ></actions>
              
          </v-stepper-content>

          <v-stepper-content step="2">
            <v-card>
              <credit-card 
                :card="mycard"
                v-on:update-card="cardUpdate($event)"
              ></credit-card>
            </v-card>


            <actions
              :settings="pageSettings"
              :backClick="() => { e1 = 1 }"
              :nextClick="() => { e1 = 3 }"
              :user="user"
              :btnCanelStyle="btnCanelStyle"
              :valid="btn.validCard"
            ></actions>

          </v-stepper-content>

          <v-stepper-content step="3">
            <v-card>
              <v-container>
                <mailstones 
                  :user_id="user_id"
                  :mydonat="mydonat"
                  :form="form"
                  :settings="pageSettings"
                  @update-youtube="form.youtube = $event"
                  @update-badge="form.badge_id = $event"
                  @update-animation="form.animate_id = $event"
                  @update-music="form.music_src = $event"
                ></mailstones>
              </v-container>
            </v-card>

            <actions
              :settings="pageSettings"
              :backClick="() => { e1 = 1 }"
              :nextClick="() => { e1 = 4 }"
              :user="user"
              :btnCanelStyle="btnCanelStyle"
              :valid="true"
            ></actions>

          </v-stepper-content>

          <v-stepper-content step="4">
            <v-card>
              <!-- <v-container>
                <card v-model="mycard"></card>
              </v-container> -->
              <v-card-text>
                <v-layout row wrap>
                  <v-flex xs12>
                    <v-text-field
                      :disabled="true"
                      v-model="form.ank.login"
                      label="Ваш логин"
                      box
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12>
                    <v-textarea
                      box
                      label="Сообщение"
                      v-model="form.ank.message"
                      :disabled="true"
                    ></v-textarea>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field
                      v-model="donate"
                      :disabled="true"
                      label="Сколько донатить? (руб.)"
                      required
                      box
                    ></v-text-field>
                    <div class="caption grey--text text--darken-1"
                      v-if="form.commission"
                      v-text="`Сумма доната: ${form.amount}руб. + ${donateInfo.commission}руб. комиссия`"
                    ></div>
                    <div class="caption grey--text text--darken-1"
                      v-text="`Стример получит: ${form.commission ? donateInfo.donate : donateInfo.amount}руб.`"
                    ></div>
                  </v-flex>
                  <v-flex xs12 v-if="donateInfo.commission">
                    <v-switch
                      color="primary"
                      :label="`Оплатить комиссию: ${donateInfo.commission} руб.`"
                      v-model="form.commission"
                    ></v-switch>
                  </v-flex>
                </v-layout>
              </v-card-text>
            </v-card>

            <actions
              :settings="pageSettings"
              :backClick="() => { e1 = 3 }"
              :nextClick="() => { donat() }"
              :user="user"
              :btnCanelStyle="btnCanelStyle"
              :valid="true"
            ></actions>

          </v-stepper-content>
        </v-stepper-items>
      </v-stepper>
      </v-flex>
    </v-layout>
    
  </v-container>
  </div>
</template>

<style lang="scss">
.application {
  line-height: 2;
}
</style>


<script>
  import axios from 'axios'
  import VideoBg from 'vue-videobg'

  import CreditCard from './CreditCard/CreditCardField'
  import Card from './CreditCard/Card'
  import AnimateText from './Animate'
  import Actions from './FormDonate/Actions'
  import Mailstones from './FormDonate/Mailstones'
  import { VTextMarquee } from 'vue-text-marquee'

  export default {
    components: {
      CreditCard, Card, AnimateText, TextMarquee: VTextMarquee, Actions, Mailstones, VideoBg
    },
    data () {
      return {
        anonim: false,
        valid: false,
        e1: 1,
        nameRules: [
          v => !!v || 'Обязательно к заполнению',
          v => String(v).length <= 15 || 'Не больше 10ти символов'
        ],
        amountRules: [
          v => !!v || 'Обязательно к заполнению',
          v => Number.isInteger(Number(v)) || 'Цолько цифры',
          v => Number(v) >= this.pageSettingstest.main.minDonate || `Сумма должна не меньше ${this.pageSettingstest.main.minDonate}руб.`
        ],
        messageRules: [
          v => !!v || 'Обязательно к заполнению',
          v => String(v).length <= 256 || 'Не больше 256 символов'
        ],
        cards: [],
        pageLoaded: false,
        form: {
          youtube: '',
          amount: 500,
          commission: false,
          ank: {
            login: '',
            message: 'Message'
          },
          card: {
            number: '4111111111111111',
            name: 'test',
            expiry: '12/23',
            cvc: '566',
          }
        },
        btn: {
          validCard: false,
          donatDisable: false,
        },
        user: null,
        donateInfo: null,
        settings: null,
        subscribe: false,
        mydonat: '0',
        redirectAfterAuth: ''
      }
    },
    computed: {
      mycard: function () {
        return this.form.card
      },
      pageSettings: {
        set () {
          this.$store.dispatch('settingsDonatePage', this.pageSettings)
        },
        get () {
          return this.$store.state.settings.donate
        }
      },
      btnBackStyle: function () {
        let fontSize = this.pageSettings.btnBack.size ? `font-size:${this.pageSettings.btnBack.size}px;` : ''

        return fontSize 
      },
      btnCanelStyle: function () {
        let fontSize = this.pageSettings.btnCanel.size ? `font-size:${this.pageSettings.btnCanel.size}px;` : ''

        return fontSize 
      },
      headerStyle: function () {
        let color = this.pageSettings.header.color ? `color: ${this.pageSettings.header.color};text-shadow:none;` : ''
        let fontSize = `font-size:${this.pageSettings.header.fontSize}px;`
        return color + fontSize
      },
      donate: function () {
        if (this.form.commission) {
          return Number(this.donateInfo.donate) + Number(this.donateInfo.commission)
        }
        return this.form.amount
      },
      user_id: function () {
        return this.$route.params.id
      },
      pageSettingstest: function () {
        return this.$store.state.settings.donate
      },
      justifyStart: function () {
        return this.pageSettingstest.main.justify === 'start'
      },
      justifyCenter: function () {
        return this.pageSettingstest.main.justify === 'center'
      },
      justifyEnd: function () {
        return this.pageSettingstest.main.justify === 'end'
      },
      bgImage: function () {
        if (this.pageSettings.main.bg !== 'image') {
          return ''
        }
        return this.pageSettings.main.bgImage
      },
      currentUser: function () {
        return this.$store.state.user
      },
      jwt_token() {
        return this.$store.state.jwt_token
      },
      youtubeVideoID: function () {
        const video = this.form.youtube.match(/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/)
        if (video) {
          return video[1]
        }
        return ''
      }
    },
    methods: {
      fetchUser () {
        this.pageLoaded = false
        this.$store.dispatch('loader', true)
        axios.get('/user/info/' + this.user_id).then(response => {
          this.user = response.data
          this.fetchSettings(this.user)
        }).catch(() => {
          this.$store.dispatch('snackbar', {text: 'Пользователь не найден', color: 'error'})
          this.$router.go(-1)
        })
      },
      fetchDonateInfo () {
        axios.get('/donate', {
          params: {
            amount: this.form.amount
          }
        }).then(response => {
          const data = response.data
          this.settings = data.settings
          this.donateInfo = data.donate
        })
      },
      cardUpdate (data) {
        this.form.card = data.card
        this.btn.validCard = data.valid
      },
      donat () {
        this.btn.donatDisable = true
        this.$store.dispatch('loader', true)
        this.form.youtubeVideoID = this.youtubeVideoID
        this.form.user_id = this.user.id
        this.form.card.number = this.form.card.number.replace(/ /g, '')
        axios.post('/donate', this.form).then(response => {
          this.btn.donatDisable = false
          this.$store.dispatch('loader', false)
          // this.$router.go(-1)
          this.$store.dispatch('snackbar', {text: response.data.message})
          
          this.$router.push({name: 'MakePayment', params: {
            orderId: response.data.order_id,
            userId: this.user_id
          }})
          if (this.jwt_token && !this.subscribe) {
            this.$router.push({name: 'UserSubscribe', params: {id: this.user_id}})
          }
        }).catch(error => {
          this.btn.donatDisable = false
          this.$store.dispatch('loader', false)
          this.$store.dispatch('errors', error.response.data.errors)
        })
      },
      fetchSettings (user) {
        axios.get(`/donate/settings/${user.id}`).then(response => {
          this.$store.dispatch('settingsDonatePage', response.data)
          this.$store.dispatch('loader', false)
          this.pageLoaded = true
        })
      },
      fetchMyCards () {
        axios.get('/mycards').then(response => {
          if (response.data.length) {
            this.cards = response.data
            this.form.card = this.cards[0].card
          }
        })
      },
      checkSubscribe () {
        axios.get(`/premium/${this.user_id}/checksubscribe/`).then(response => {
          this.subscribe = response.data
        })
      },
      fetchMydonat () {
        axios.get(`/${this.user_id}/mydonat`).then(response => {
          this.mydonat = response.data
        })
      }
    },
    created () {
      this.redirectAfterAuth = window.btoa(`Payment-${this.user_id}`)
      this.fetchUser()
      this.fetchDonateInfo()
      if (this.jwt_token) {
        this.checkSubscribe()
        this.fetchMydonat()
        if (this.currentUser) {
          this.form.ank.login = this.currentUser.login
        }
      }
      
    },
    watch: {
      currentUser: function (user) {
        if (user) {
          // this.fetchMyCards()
          this.form.ank.login = user.login
        }
      },
      anonim: function (val) {
        if (val === true) {
          this.form.ank.login = 'Аноним'
        }
      },
      user_id: function () {
        this.fetchUser()
      },
      e1: function (val) {
        if (val === 3) {
          this.fetchDonateInfo()
        }
      }
    }
  }
</script>
