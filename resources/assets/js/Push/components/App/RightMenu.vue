<template>
  <div>
    <v-navigation-drawer
      absolute
      permanent
      :right="true"
    >

      <settings-main :settings="settings.main"></settings-main>
      <settings-image :saveLoading="save" :settings="settings.attachment"></settings-image>
      <!-- <settings-video :saveLoading="save" :settings="settings.video"></settings-video> -->
      <settings-text :settings="settings.name" title="Имя донатера"></settings-text>
      <settings-text :settings="settings.amount" title="Сумма доната"></settings-text>
      <settings-text :settings="settings.message" title="Сообщение"></settings-text>

    <!-- <v-list>
      <v-list-tile>
        <v-text-field
          :rules="[
            () => !!settings.main.duration || 'Обязательно',
            () => Number(settings.main.duration) >= 1000 || 'Не меньше 1000',
            ]"
          :error-messages="errorMessages"
          label="Продолжительность (в миллисекундах)"
          v-model="settings.main.duration"
        ></v-text-field>
      </v-list-tile>
    </v-list> -->

    <v-list-tile>
      <v-btn 
        small 
        color="red" 
        flat 
        @click="reset" 
        :loading="resetLoading"
      >Сбросить</v-btn>
      <v-spacer></v-spacer>
      <v-btn 
        small 
        color="primary" 
        @click="save" 
        :loading="saveLoading"
      >Сохранить</v-btn>
    </v-list-tile>
    <v-list-tile>
      <v-btn 
        small 
        color="primary" 
        @click="testNotification" 
        :loading="testLoading"
      >Тестовое уведомление</v-btn>
    </v-list-tile>

    <v-list-tile>
      <v-btn 
        small 
        dark
        @click="goHome" 
      >Вернуться на сайт</v-btn>
    </v-list-tile>

    <v-container @click="$store.dispatch('positionChangeMode', !positionChangeMode)">
      Для изменения местоположение блоков, кликните по нему два раза левой кнопоко мыши.
      Или нажмите на этот текст!
    </v-container>

    </v-navigation-drawer>

  </div>
</template>

<script>
import axios from 'axios'
import SettingsMain from '../Settings/Main'
import SettingsImage from '../Settings/Image'
import SettingsVideo from '../Settings/Video'
import SettingsText from '../Settings/Text'

export default {
  components: {
    SettingsMain, SettingsImage, SettingsText, SettingsVideo
  },
  props: {
    settings: {
      type: Object,
      required: true
    },
    notification: {
      type: Object,
      required: true
    }
  },
  computed: {
    positionChangeMode: function () {
      return this.$store.state.positionChangeMode
    },
    drawer: {
      set (val) {
        if (val === false) {
          this.$store.dispatch('rightDrawerToggle', val)
        }
      },
      get () {
        return this.$store.state.settings.rightDrawer
      }
    },
    user: function () {
      return this.$store.state.user
    },
    token: function () {
      return this.$store.state.token
    },
    push_id: function () {
      return this.$store.state.push_id
    },
  },
  data () {
    return {
      drawerOpen: true,
      errorMessages: '',
      saveLoading: false,
      resetLoading: false,
      testLoading: false
    }
  },
  methods: {
    testNotification () {
      this.testLoading = true
      axios.put(`/push/test_notification/${this.user.id}/${this.push_id}/${this.token}`).then(response => {
        this.testLoading = false
      })
    },
    save () {
      this.saveLoading = true
      axios.post(`/push/settings/${this.user.id}/${this.push_id}/${this.token}`, {settings: this.settings}).then(response => {
        this.saveLoading = false
      })
    },
    reset () {
      this.resetLoading = true
      axios.put(`/push/settings/${this.user.id}/${this.push_id}/${this.token}`, {settings: this.settings}).then(response => {
        this.resetLoading = false
        this.$store.dispatch('settingsDonatePage', response.data)
      })
    },
    goHome () {
      window.location.href = '/#/stream/settings'
    }
  }
}
</script>

<style lang="scss" scoped>
.v-navigation-drawer {
  opacity: 0.1;
  -webkit-transition: 1s; /* Safari */
  transition: 1s;
  &:hover {
    opacity: 1;
  }
}
</style>
