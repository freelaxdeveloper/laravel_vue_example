<template>
  <v-list>
    <v-list-tile>
      <v-list-tile-content>
        <v-list-tile-title>Расположение формы</v-list-tile-title>
      </v-list-tile-content>
      <v-list-tile-action>
        <v-menu
          :close-on-content-click="false"
          :nudge-width="200"
          offset-x
        >
          <v-btn
            icon
            slot="activator"
            dark
          >
            <v-icon>settings</v-icon>
          </v-btn>

          <v-list>
            <v-list-tile @click="settings.main.justify = 'start'">
              <v-list-tile-title>Лево</v-list-tile-title>
            </v-list-tile>
            <v-list-tile @click="settings.main.justify = 'center'">
              <v-list-tile-title>Центр</v-list-tile-title>
            </v-list-tile>
            <v-list-tile @click="settings.main.justify = 'end'">
              <v-list-tile-title>Право</v-list-tile-title>
            </v-list-tile>
          </v-list>
        </v-menu>
      </v-list-tile-action>
    </v-list-tile>
    <v-list-tile>
      <v-list-tile-title>Фон страницы</v-list-tile-title>
      <v-list-tile-action>
        <!-- <image-upload
          v-if="imageUpload" 
          :preview="false" 
          :show-model="true"
          @show="imageUpload = $event"
          @success="settings.main.bgImage = $event, settings.main.bg = 'image'"
        ></image-upload> -->
        
        <v-menu
          :close-on-content-click="false"
          :nudge-width="200"
          offset-x
        >
          <v-btn
            icon
            slot="activator"
            dark
          >
            <v-icon>settings</v-icon>
          </v-btn>

          <v-list>
            <v-list-tile @click="imageUpload = true">
              <v-list-tile-title>Изображение</v-list-tile-title>
            </v-list-tile>
            <!-- <v-list-tile @click="videoUpload = true">
              <v-list-tile-title>Видео</v-list-tile-title>
            </v-list-tile> -->
            <v-list-tile @click="$store.dispatch('rightDrawerToggle', false), picker = 'mainbg'">
              <v-list-tile-title>Цвет</v-list-tile-title>
            </v-list-tile>

            <file-upload
              v-if="imageUpload"
              url="/api/image/upload"
              @show="imageUpload = $event"
              @success="imageSuccess($event)"
            ></file-upload>

            <file-upload
              v-if="videoUpload"
              url="/api/video/upload"
              @show="videoUpload = $event"
              @success="videoSuccess($event)"
            ></file-upload>

          </v-list>
        </v-menu>
      </v-list-tile-action>
    </v-list-tile>

    <v-list-tile>
      <v-list-tile-title>Верхняя панель</v-list-tile-title>
      <v-list-tile-action>
        <v-menu
          :close-on-content-click="false"
          :nudge-width="200"
          offset-x
        >
          <v-btn
            icon
            slot="activator"
            dark
          >
            <v-icon>settings</v-icon>
          </v-btn>

          <v-list>
            <v-list-tile @click="showPicker('headerbg')">
              <v-list-tile-title>Фон</v-list-tile-title>
            </v-list-tile>
            <v-list-tile @click="showPicker('headercolor')">
              <v-list-tile-title>Цвет</v-list-tile-title>
            </v-list-tile>
            <v-list-tile @click="fontPicker = true, $store.dispatch('rightDrawerToggle', false)">
              <v-list-tile-title>Шрифт</v-list-tile-title>
            </v-list-tile>
            <!-- <v-list-tile @click="headerfontSize = true">
              <v-list-tile-title>Размер</v-list-tile-title>
            </v-list-tile> -->
            <v-list-tile>
              <v-list-tile-title>
                <v-slider
                  v-model="settings.header.fontSize"
                  :min="7"
                  :max="27"
                  thumb-label
                ></v-slider>
              </v-list-tile-title>
            </v-list-tile>          
          </v-list>
        </v-menu>
      </v-list-tile-action>
    </v-list-tile>


    <v-list-tile>
      <v-list-tile-title>Кнопка вернуться</v-list-tile-title>
      <v-list-tile-action>
        <next-btn :fonts="fonts" :settings="settings.btnBack"></next-btn>
      </v-list-tile-action>
    </v-list-tile>

    <v-list-tile>
      <v-list-tile-title>Кнопка продолжить</v-list-tile-title>
      <v-list-tile-action>
        <next-btn :fonts="fonts" :settings="settings.btnNext"></next-btn>
      </v-list-tile-action>
    </v-list-tile>

    <v-list-tile>
      <v-list-tile-title>Кнопка доната</v-list-tile-title>
      <v-list-tile-action>
        <next-btn :fonts="fonts" :settings="settings.btnDonat"></next-btn>
      </v-list-tile-action>
    </v-list-tile>

    <v-list-tile>
      <v-list-tile-title>Кнопка отмены</v-list-tile-title>
      <v-list-tile-action>
        <next-btn :fonts="fonts" :settings="settings.btnCanel"></next-btn>
      </v-list-tile-action>
    </v-list-tile>

    <v-list-tile>
      <v-list-tile-title>Другие настройки</v-list-tile-title>
      <v-list-tile-action>
        <other-settings v-if="settings.other" :settings="settings.other"></other-settings>
      </v-list-tile-action>
    </v-list-tile>

    <v-list-tile>
      <v-switch
        color="primary"
        label="Светлая тема"
        v-model="settings.main.light"
      ></v-switch>
    </v-list-tile>

    <v-list-tile>
      <v-spacer></v-spacer>
      <!-- <v-btn small color="red" flat @click="cancel">Выйти</v-btn> -->
      <v-btn small color="red" @click="reset" :loading="resetLoading">Сбросить</v-btn>
      <v-btn small color="primary" @click="save" :loading="saveLoading">Сохранить</v-btn>
    </v-list-tile>

     <v-list-tile>
      <v-btn 
        small 
        color="primary" 
        @click="$store.dispatch('rightDrawerChange', 'default')" 
        :loading="resetLoading"
      >
        Закрыть редактор
      </v-btn>
    </v-list-tile>

    <color-picker
      v-if="picker"
      :model="getPicker(picker)"
      @update-color="setPicker(picker, $event.hex)"
      @close="closePicker"
    ></color-picker>

    <font-picker
      v-if="fontPicker"
      :model="settings.header.fontFamily"
      :fonts="fonts"
      @update="settings.header.fontFamily = $event"
      @close="fontPicker = false, $store.dispatch('rightDrawerToggle', true)"
    ></font-picker>

  </v-list>
</template>

<script>
import axios from 'axios'
import imageUpload from '../upload/Image.vue'
import fileUpload from '../upload/File.vue'
import NextBtn from '../SettingsDonate/NextBtn.vue'
import OtherSettings from '../SettingsDonate/OtherSettings.vue'
import ColorPicker from '../ColorPicker.vue'
import FontPicker from '../FontPicker.vue'

export default {
  components: {
    imageUpload, NextBtn, ColorPicker, FontPicker, fileUpload, OtherSettings
  },
  computed: {
    user: function () {
      return this.$store.state.user
    },
    settings: {
      set () {
        this.$store.dispatch('settingsDonatePage', this.settings)
      },
      get () {
        return this.$store.state.settings.donate
      }
    }
  },
  data () {
    return {
      saveLoading: false,
      resetLoading: false,
      picker: '',
      dialog: false,
      fontPicker: false,
      imageUpload: false,
      videoUpload: false,
      headerfontSize: false,
      fonts: []
    }
  },
  methods: {
    imageSuccess (event) {
      this.save()

      this.settings.main.bgImage = event
      this.settings.main.bg = 'image'

      location.reload()
    },
    videoSuccess(event) {
      this.save()

      this.settings.main.bgVideo = event
      this.settings.main.bg = 'video'

      location.reload()
    },
    reset () {
      this.resetLoading = true
      axios.put(`/donate/settings/${this.user.id}`).then(response => {
        let data = response.data
        this.$store.dispatch('settingsDonatePage', data.settings)
        this.$store.dispatch('snackbar', {text: data.message, color: 'warning'})
        this.resetLoading = false
      }).catch(error => {
        this.resetLoading = false
        this.$store.dispatch('errors', error.response.data.errors)
      })
    },
    save () {
      console.log('userinfo', this.user)
      this.saveLoading = true
      axios.post(`/donate/settings/${this.user.id}`, {settings: this.settings}).then(response => {
        this.saveLoading = false
        this.$store.dispatch('snackbar', {text: response.data})
      }).catch(error => {
        this.saveLoading = false
        this.$store.dispatch('errors', error.response.data.errors)
      })
    },
    fetchFonts() {
      axios.get('/fonts').then(response => {
        this.fonts = response.data
      })
    },
    getPicker (picker) {
      switch (picker) {
        case 'headerbg':
          return this.settings.header.bgColor
          break;
        case 'headercolor':
          return this.settings.header.color
          break;
        case 'mainbg':
          return this.settings.main.bgColor
          break;
        case 'headerfont':
          this.dialog = true
          break;
      }
      return '#232323'
    },
    setPicker (picker, value) {
      switch (picker) {
        case 'headerbg':
          this.settings.header.bgColor = value
          break;
        case 'headercolor':
          this.settings.header.color = value
          break;
        case 'mainbg':
          if (this.settings.main.bg !== 'color') {
            this.save()
            location.reload()
          }
          this.settings.main.bgColor = value
          this.settings.main.bg = 'color'
          break;
      }
    },
    showPicker (picker) {
      this.$store.dispatch('rightDrawerToggle', false)
      this.picker = picker
    },
    closePicker () {
      this.picker = ''
    }
  },
  created() {
    this.fetchFonts()
  }
}
</script>

<style lang="scss" scoped>
.v-list__tile__action {
  justify-content: flex-end;
}
</style>
