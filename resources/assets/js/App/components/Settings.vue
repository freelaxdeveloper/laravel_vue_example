<template>
  <div>
    <v-dialog
      v-model="dialog"
      fullscreen
      hide-overlay
      transition="dialog-bottom-transition"
      scrollable
    >
      <v-card tile>
        <v-toolbar card dark :color="design == 'light' ? 'primary' : ''">
          <v-btn icon dark @click.native="dialog = false">
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>Настройки</v-toolbar-title>
        </v-toolbar>
        <v-card-text>
          <v-list three-line subheader>
            <v-subheader>Основной цвет сайта</v-subheader>
                <v-radio-group v-model="design">
                  <v-radio
                    label="Темный"
                    value="dark"
                  ></v-radio>
                  <v-radio
                    label="Светлый"
                    value="light"
                  ></v-radio>
                </v-radio-group>
          </v-list>
        </v-card-text>

        <div style="flex: 1 1 auto;"></div>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  import axios from 'axios'

  export default {
    props: {
      settingsDialog: Boolean,
    },
    data () {
      return {
        links: []
      }
    },
    computed: {
      dialog: {
        get: function () {
          return this.settingsDialog
        },
        set: function (val) {
          this.$emit('setting-dialog-update', val)
        },
      },
      user: function () {
        return this.$store.state.user
      },
      design: {
        get: function () {
          return this.$store.state.settings.design
        },
        set: function (design) {
          this.$store.dispatch('setDesign', design)
        }
      }
    }
  }
</script>