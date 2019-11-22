<template>
  <div>
    <v-list>
      <v-list-tile>
        <v-list-tile-content>
          <v-list-tile-title>Основное</v-list-tile-title>
        </v-list-tile-content>
        <v-list-tile-action>
          <!-- <v-btn
            icon
            @click="musicPicker = true"
          >
            <v-icon>settings</v-icon>
          </v-btn> -->
          <v-menu
            bottom
            origin="center center"
            transition="scale-transition"
            :close-on-content-click="false"
            :nudge-width="200"
            offset-x
            dark
          >
            <v-btn
              icon
              slot="activator"
            >
              <v-icon>settings</v-icon>
            </v-btn>

            <v-card>
              <!-- <v-list>
                <v-list-tile @click="picker = true">
                  <v-list-tile-action>
                    <v-avatar size="36px" :color="settings.bgColor"> </v-avatar>
                  </v-list-tile-action>
                  <v-list-tile-title>Цвет</v-list-tile-title>
                </v-list-tile>
              </v-list> -->
              <v-list>
                <v-list-tile @click="musicPicker = true">
                  <v-list-tile-action>
                    <v-icon>mdi-music</v-icon>
                  </v-list-tile-action>
                  <v-list-tile-title>Мелодия</v-list-tile-title>
                </v-list-tile>
                <!-- <v-list-tile @click="locationPicker = true">
                  <v-list-tile-action>
                    <v-icon>mdi-arrow-all</v-icon>
                  </v-list-tile-action>
                  <v-list-tile-title>Расположение</v-list-tile-title>
                </v-list-tile> -->
                <v-list-tile v-if="type === 'donate'">
                  <v-list-tile-content>
                    <v-text-field
                      label="Мин. сумма доната"
                      v-model="settings.minDonate"
                    ></v-text-field>
                  </v-list-tile-content>
                </v-list-tile>
                <v-list-tile v-if="type === 'donate'">
                  <v-list-tile-content>
                    <v-text-field
                      label="Мин. сумма для чтения"
                      v-model="settings.minVoice"
                    ></v-text-field>
                  </v-list-tile-content>
                </v-list-tile>
                <v-list-tile>
                  <!-- <v-list-tile-content> -->
                    <v-text-field
                      :rules="[
                        () => !!settings.duration || 'Обязательно',
                        () => Number(settings.duration) >= 1000 || 'Не меньше 1000',
                        ]"
                      label="Продолжительность показа"
                      v-model="settings.duration"
                    ></v-text-field>
                  <!-- </v-list-tile-content> -->
                </v-list-tile>
              </v-list>
            </v-card>
          </v-menu>
        </v-list-tile-action>
      </v-list-tile>
    </v-list>

    <color-picker
      v-if="picker"
      :model="settings.bgColor"
      @update-color="settings.bgColor = $event.hex"
      @close="picker = false"
    ></color-picker>


    <v-dialog v-model="musicPicker" scrollable persistent max-width="700">
      <v-card>
        <v-card-text>
          <!-- <div v-for="i in 19" :key="i">
            <sound
              :settings="settings.sound"
              :src="`/${i}.mp3`"
              @update-music="settings.sound = $event"
            ></sound>
          </div> -->
          <div v-for="(file, i) in sounds" :key="`sound_${i}`">
            <sound
              :settings="settings.sound"
              :music="file"
              @update-music="settings.sound = $event"
            ></sound>
          </div>
        <file-pond
          allowMultiple="true"
          ref="pond"
          label-idle="Перетащите файлы..."
          v-on:init="handleFilePondInit"
          :server="server"/>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" flat @click.native="musicPicker = false">Закрыть</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="locationPicker" scrollable persistent max-width="700">
      <v-card>
        <v-card-text>
          
          


      <v-layout row wrap>
        <v-flex xs6>
            <v-card
              color=""
              class="d-flex align-center ma-2"
              dark
              height="200"
              @click="setLocation(false, true, 'right')"
            >
              <v-layout wrap>
                <v-flex xs12
                  class="display-1 text-xs-center"
                >
                  Текст
                </v-flex>
                <v-flex xs12
                  class="display-1 text-xs-center"
                >
                  Картинка
                </v-flex>
              </v-layout>
            </v-card>
        </v-flex>
        <v-flex xs6>
            <v-card
              color=""
              class="d-flex align-center ma-2"
              dark
              height="200"
              @click="setLocation(true, false, 'right')"
            >
              <v-layout wrap>
                <v-flex xs6
                  class="display-1 text-xs-center"
                >
                  Текст
                </v-flex>
                <v-flex xs6
                  class="display-1 text-xs-center"
                >
                  Картинка
                </v-flex>
              </v-layout>
            </v-card>
        </v-flex>
        <v-flex xs6>
            <v-card
              color=""
              class="d-flex align-center ma-2"
              dark
              height="200"
              @click="setLocation(false, true, 'left')"
            >
              <v-layout wrap>
                <v-flex xs12
                  class="display-1 text-xs-center"
                >
                  Картинка
                </v-flex>
                <v-flex xs12
                  class="display-1 text-xs-center"
                >
                  Текст
                </v-flex>
              </v-layout>
            </v-card>
        </v-flex>
        <v-flex xs6>
            <v-card
              color=""
              class="d-flex align-center ma-2"
              dark
              height="200"
              @click="setLocation(true, false, 'left')"
            >
              <v-layout wrap>
                <v-flex xs6
                  class="display-1 text-xs-center"
                >
                  Картинка
                </v-flex>
                <v-flex xs6
                  class="display-1 text-xs-center"
                >
                  Текст
                </v-flex>
              </v-layout>
            </v-card>
        </v-flex>
        <v-flex xs6>
            <v-card
              color=""
              class="d-flex align-center ma-2"
              dark
              height="200"
              @click="setLocation(true, false, 'text_over_image')"
            >
              <v-layout wrap>
                <v-flex xs12
                  class="display-1 text-xs-center"
                >
                  Текст по верх картинки
                </v-flex>
                <!-- <v-flex xs6
                  class="display-1 text-xs-center"
                >
                  Текст
                </v-flex> -->
              </v-layout>
            </v-card>
        </v-flex>
      </v-layout>





        </v-card-text>
       <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" flat @click.native="locationPicker = false">Закрыть</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import ColorPicker from '../../../App/components/ColorPicker.vue'
// import howler from 'howler'
import Sound from '../Sound'

// Import Vue FilePond
import vueFilePond from 'vue-filepond';

// Import FilePond styles
import 'filepond/dist/filepond.min.css';

// Import FilePond plugins
// Please note that you need to install these plugins separately

// Import image preview plugin styles
// import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';

// Import image preview and file type validation plugins
// import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
// import FilePondPluginImagePreview from 'filepond-plugin-image-preview';

// Create component
const FilePond = vueFilePond();

export default {
  components: {
    ColorPicker, Sound, FilePond
  },
  props: {
    settings: {
      type: Object,
      required: true
    }
  },
  computed: {
    user: function () {
      return this.$store.state.user
    },
    token: function () {
      return this.$store.state.token
    },
    sounds: function () {
      return this.$store.state.settings.music
    },
    type: function () {
      return this.$store.state.type
    }
  },
  data () {
    return {
      picker: false,
      locationPicker: false,
      musicPicker: false,
      server: {
        url: '',
        process: {
          method: 'POST',
          withCredentials: false,
          headers: {},
          timeout: 7000,
          onload: (response) => {
            response = JSON.parse(response)
            this.$store.dispatch('addMusic', response)
            // this.sounds.push(response.src)
            console.log('response', response.src)
          },
          onerror: null
        }
      }
    }
  },
  methods: {
    setLocation (xs6, xs12, image) {
      this.locationPicker = false
      this.settings.grid.xs12 = xs12
      this.settings.grid.xs6 = xs6
      this.settings.grid.image = image
    },
    handleFilePondInit: function() {
      console.log('FilePond has initialized');

      // example of instance method call on pond reference
      this.$refs.pond.getFiles();
    }
  },
  created () {
    this.server.url = `/api/push/music/${this.user.id}/${this.token}`
  }
}
</script>
