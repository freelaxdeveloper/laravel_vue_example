<template>
  <v-app :dark="design == 'dark'" :light="design == 'light'">
    <v-toolbar fixed app :clipped-left="clipped">
     
      <!-- <v-list-tile-avatar class="logo" size="56" @click="$router.push('/')"> -->
        <img :src="logo" class="logo" width="150px" @click="$router.push('/')">
      <!-- </v-list-tile-avatar> -->

      <!-- <v-toolbar-title class="logo" v-text="title" @click="$router.push('/')"></v-toolbar-title> -->

      <v-spacer></v-spacer>
      <v-btn
        icon
        :dark="design == 'dark'"
        :light="design == 'light'"
        @click.stop="$store.dispatch('rightDrawerToggle')"
      >
        <v-icon>menu</v-icon>
      </v-btn>
    </v-toolbar>
    <v-content>
      
        <router-view></router-view>

    </v-content>
    <v-navigation-drawer
      temporary
      :right="right"
      v-model="rightDrawer"
      fixed
    >
      <v-list v-if="$store.state.settings.menu === 'donate'">
        <v-list-tile>
          <v-list-tile-content>
            <v-list-tile-title>Редактор формы  для доната</v-list-tile-title>
          </v-list-tile-content>
          <v-list-tile-action>
            <v-btn small light color="white" icon @click.stop="$store.dispatch('rightDrawerChange', 'default')">
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-list-tile-action>
        </v-list-tile>
        <v-divider></v-divider>
        <donate-settings></donate-settings>
      </v-list>
      <v-list v-if="$store.state.settings.menu === 'default'">

        <v-list-tile avatar v-if="user.id">

          <v-list-tile-avatar>
            <img :src="user.avatar">
          </v-list-tile-avatar>

          <v-list-tile-content>
            <v-list-tile-title v-text="user.name"></v-list-tile-title>
          </v-list-tile-content>
          <v-list-tile-action>
            <v-btn icon @click.stop="$store.dispatch('rightDrawerToggle')">
              <v-icon v-text="chevron"></v-icon>
            </v-btn>
          </v-list-tile-action>
        </v-list-tile>
        <v-list-tile avatar v-else>

          <v-list-tile-avatar>
            <img src="/img/logo_small.png">
          </v-list-tile-avatar>

          <v-list-tile-content>
            <v-list-tile-title>{{ title }} {{ $store.state.api_token }}</v-list-tile-title>
          </v-list-tile-content>
          <v-list-tile-action>
            <v-btn icon @click.stop="$store.dispatch('rightDrawerToggle')">
              <v-icon v-text="chevron"></v-icon>
            </v-btn>
          </v-list-tile-action>
        </v-list-tile>



        <v-divider></v-divider>
        <v-list-tile 
          class="nav-link" 
          v-for="(item, index) in menu" 
          :key="index" 
          :to="item.link"
          v-if="!item.is_streamer || user.profile_mode === 'streamer'"
        >
          <v-list-tile-action>
            <v-icon :dark="design == 'dark'" :light="design == 'light'" v-text="item.icon"></v-icon>
          </v-list-tile-action>
          <v-list-tile-title v-text="item.title"></v-list-tile-title>
        </v-list-tile>

        <v-divider></v-divider>
        <v-list-tile @click="settings = true, $store.dispatch('rightDrawerToggle', false)">
          <v-list-tile-action>
            <v-icon :dark="design == 'dark'" :light="design == 'light'">settings</v-icon>
          </v-list-tile-action>
          <v-list-tile-title>Настройки</v-list-tile-title>
        </v-list-tile>
        <v-list-tile @click="right = !right">
          <v-list-tile-action>
            <v-icon :dark="design == 'dark'" :light="design == 'light'">compare_arrows</v-icon>
          </v-list-tile-action>
          <v-list-tile-title>Сменить</v-list-tile-title>
        </v-list-tile>
      </v-list>

    </v-navigation-drawer>



    <v-dialog
      v-model="loader"
      hide-overlay
      persistent
      width="300"
    >
      <v-card
        dark
      >
        <v-card-text>
          Подождите...
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>


    <v-snackbar
      v-model="$store.state.snackbar.model"
      :bottom="true"
      :right="true"
      :timeout="$store.state.snackbar.timeout"
      :color="$store.state.snackbar.color"
    >
      {{ $store.state.snackbar.text }}
    </v-snackbar>

    <settings 
      :settingsDialog="settings"
      v-on:setting-dialog-update="settings = $event"
    ></settings>

    <app-footer :title="title"></app-footer>

  </v-app>
</template>

<script>
  import Vue from 'vue'
  import axios from 'axios'

  import Settings from './components/Settings'
  import AppFooter from './components/App/Footer'
  import DonateSettings from './components/App/DonateSettings'

  export default {
    components: {
      Settings, AppFooter, DonateSettings
    },
    computed: {
      errors: function () {
        return this.$store.state.errors
      },
      loader() {
        return this.$store.state.loader
      },
      design() {
        return this.$store.state.settings.design
      },
      logo() {
        return this.$store.state.settings.logo
      },
      user() {
        return this.$store.state.user
      },
      api_token() {
        return this.$store.state.api_token
      },
      jwt_token() {
        return this.$store.state.jwt_token
      },
      chevron() {
        return !this.right ? 'chevron_left' : 'chevron_right'
      },
      menu () {
        if (this.user.id) {
          return [
            {icon: 'mdi-home', link: '/', title: 'Главная'},
            {icon: 'mdi-account-group', link: '/follows', title: 'Подписчики', is_streamer: true},
            {icon: 'mdi-home-currency-usd', link: '/transaction', title: 'Транзакции', is_streamer: true},
            {icon: 'mdi-video', link: '/stream/settings', title: 'Управление стримом', is_streamer: true},
            {icon: 'mdi-account', link: '/profile', title: 'Мой профиль'},
            {icon: 'mdi-account', link: '/profile/social', title: 'Мои соц.аккаунты'},
            {icon: 'mdi-logout', link: '/logout', title: 'Выход'},
          ]
        }
        return [
          {icon: 'mdi-login', link: '/login', title: 'Авторизация'},
          // {icon: 'mdi-account-multiple-plus', link: '/register', title: 'Регистрация'},
          // {icon: 'mdi-security-account', link: '/recoverpassword', title: 'Восстановление пароля'},
        ]
      },
      rightDrawer: {
        set(val) {
          if (val === false) {
            this.$store.dispatch('rightDrawerToggle', val)
          }
        },
        get() {
          return this.$store.state.settings.rightDrawer
        }
      }
    },
    data () {
      return {
        clipped: true,
        settings: false,
        right: true,
        // rightDrawer: false,
        title: 'DonateSupp',
        // logo: '/logo.png',
      }
    },
    created () {
      // console.log(this.$route.query)
      if (this.$route.query.locked) {
        this.$toast.error({
          title: 'Ошибка авторизации',
          message: 'Ваша учетная запись заблокирована!'
        })
      }

      let api_token = document.head.querySelector('meta[name="api-token"]');
      let jwt_token = document.head.querySelector('meta[name="jwt-token"]');
      let redirect = document.head.querySelector('meta[name="redirect"]');
      if (api_token && jwt_token) {
        this.$store.dispatch('setToken', api_token.content)
        this.$store.dispatch('setJWTToken', jwt_token.content)
        this.updateUserData()
        this.$router.push({name: 'MyProfile'})
        window.location.href = redirect ? redirect.content : "/#/profile";
      }
      if (this.jwt_token) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.jwt_token
      }

      if (!!this.jwt_token) {
        this.updateUserData()
      }
      this.interceptors()
      this.fetchSettings()
    },
    methods: {
      fetchSettings () {
        axios.get('/mainsettings').then(response => {
          this.$store.dispatch('mainSettings', response.data)
        })
      },
      interceptors() {
        axios.interceptors.response.use((response) => {
          return response;
        }, (error) => {
          if (401 == error.response.status) {
            this.$store.dispatch('logout')
            this.$router.push({name: 'Login'})
            this.$toast.error({
              title: 'Ошибка авторизации',
              message: 'Не удалось получить доступ к аккаунту'
            })
          }
          return Promise.reject(error);
        });    
      },
      updateUserData() {
        axios.get('/user').then(response => {
          this.$store.dispatch('setUser', response.data)
        }).catch(error => {
          if (401 == error.response.status) {
            this.$store.dispatch('logout')
          }
          
        })
      },
    },
    watch: {
      api_token: function (newApiToken, oldApiToken) {
        if (newApiToken) {
          this.updateUserData()
        }
      },
      errors: function (errors) {
        // if (errors.error) {
        //   this.$toast.error({
        //     title: errors.error,
        //     message: 'Authentication error'
        //   })
        // }
        let int = setInterval(() => {
          if (!errors.length) {
            return clearInterval(int)
          }
          let error = errors.shift()
          error = Object.values(error)
          if (!error.length) {
            return clearInterval(int)
          }
          if (!error) {
            return clearInterval(int)
          }
          this.$toast.error({
            title: error[0],
            message: 'Ошибка при отправке данных'
          })
        }, 600)
      }
    }
  }
</script>

<style lang="scss" scoped>
  .logo {
    cursor: pointer;
  }
</style>

<style>
  .cxlt-toastr-container>div {
    opacity: 1!important;
  }
</style>