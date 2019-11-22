<template>
  <div>
    <v-list>
      <v-list-tile>
        <v-list-tile-content>
          <v-list-tile-title>Видео</v-list-tile-title>
        </v-list-tile-content>
        <v-list-tile-action>
          <v-menu
            bottom
            origin="center center"
            :close-on-content-click="false"
            transition="scale-transition"
            offset-x
            dark
            :max-width="300"
          >
            <v-btn
              icon
              slot="activator"
            >
              <v-icon>settings</v-icon>
            </v-btn>

            <v-card>

              <v-text-field
                solo
                label="URL видео"
                v-model="settings.src"
                hint="Что бы изменения вступили в силу необходимо нажать кнопку 'Применить'"
              ></v-text-field>

              <v-btn color="primary" small @click="save">Прменить</v-btn>

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

// Import Vue FilePond
import vueFilePond from 'vue-filepond';

// Import FilePond styles
import 'filepond/dist/filepond.min.css';

// Create component
const FilePond = vueFilePond();

export default {
  components: {
    FilePond
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
    this.server.url = `/api/push/video/${this.user.id}/${this.push_id}/${this.token}`
  }
}
</script>
