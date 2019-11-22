<template>
  <div>
    <v-list>
      <v-list-tile>
        <v-list-tile-content>
          <v-list-tile-title>Изображение</v-list-tile-title>
        </v-list-tile-content>
        <v-list-tile-action>
          <v-menu
            bottom
            origin="center center"
            :close-on-content-click="false"
            transition="scale-transition"
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
              <v-list>
                <v-list-tile>

                  <v-list-tile-content>
                      <v-text-field
                        solo
                        label="URL изображения"
                        v-model="settings.src"
                      ></v-text-field>
                  </v-list-tile-content>
                </v-list-tile>
              </v-list>

              <v-list v-if="settings.src">
                <!-- <v-list-tile @click="picker = true">
                  <v-list-tile-action>
                    <v-avatar size="36px" :color="settings.color"> </v-avatar>
                  </v-list-tile-action>
                  <v-list-tile-title>Цвет</v-list-tile-title>
                </v-list-tile> -->
                <!-- <v-list-tile @click="imageSize = true">
                  <v-list-tile-action>
                    <v-avatar size="36px" color="primary" v-text="settings.size"></v-avatar>
                  </v-list-tile-action>
                  <v-list-tile-title>Размер</v-list-tile-title>
                </v-list-tile> -->
                <v-list-tile v-if="imageSize">
                  <v-slider
                    v-model="settings.size"
                    :min="175"
                    :max="1000"
                    thumb-label
                  ></v-slider>
                </v-list-tile>          
                <!-- <v-list-tile>
                  <v-switch
                    color="primary"
                    label="Tile"
                    v-model="settings.tile"
                  ></v-switch>
                </v-list-tile> -->
              </v-list>
              <v-list class="uploadimage">
                <v-list-tile>
                  <v-list-tile-title>
                    <file-pond
                      :allowMultiple="false"
                      ref="pond"
                      label-idle="Загрузить файл"
                      v-on:init="handleFilePondInit"
                      :server="server"
                    />
                  </v-list-tile-title>
                </v-list-tile>
              </v-list>
            </v-card>
          </v-menu>
        </v-list-tile-action>
      </v-list-tile>
    </v-list>

    <color-picker
      v-if="picker"
      :model="settings.color"
      @update-color="settings.color = $event.hex8"
      @close="picker = false"
    ></color-picker>

  </div>
</template>

<style lang="scss" scoped>
.uploadimage {
  .v-list__tile__title {
    height: 65px;
  }
}
</style>


<script>
import ColorPicker from '../../../App/components/ColorPicker.vue'


// Import Vue FilePond
import vueFilePond from 'vue-filepond';

// Import FilePond styles
import 'filepond/dist/filepond.min.css';

// Create component
const FilePond = vueFilePond();

export default {
  components: {
    ColorPicker, FilePond
  },
  props: {
    settings: {
      type: Object,
      required: true
    },
    saveLoading: {
      type: Function,
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
    push_id: function () {
      return this.$store.state.push_id
    }
  },
  data () {
    return {
      imageSize: false,
      picker: false,
      server: {
        url: '',
        process: {
          method: 'POST',
          withCredentials: false,
          headers: {},
          timeout: 7000,
          onload: (response) => {
            response = JSON.parse(response)
            this.settings.src = response.src
            this.settings.name = response.name
            this.settings.type = response.type

            this.save()
          },
          onerror: null
        }
      }
    }
  },
  methods: {
    save () {
      this.saveLoading()

      location.reload()
    },
    handleFilePondInit: function() {
      console.log('FilePond has initialized');

      // example of instance method call on pond reference
      this.$refs.pond.getFiles();
    }

  },
  created () {
    this.server.url = `/api/push/image/${this.user.id}/${this.push_id}/${this.token}`
    console.log(this.server.url)
  }
}
</script>
