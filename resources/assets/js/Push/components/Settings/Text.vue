<template>
  <div>
    <v-list>
      <v-list-tile>
        <v-list-tile-content>
          <v-list-tile-title v-text="title"></v-list-tile-title>
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
              <v-divider></v-divider>

              <v-list>
                <v-list-tile @click="picker = true">
                  <v-list-tile-action>
                    <v-avatar size="36px" :color="settings.color"> </v-avatar>
                  </v-list-tile-action>
                  <v-list-tile-title>Цвет текста</v-list-tile-title>
                </v-list-tile>
                <!-- <v-list-tile @click="fontSize = !fontSize">
                  <v-list-tile-action>
                    <v-avatar size="36px" color="primary" v-text="settings.size"></v-avatar>
                  </v-list-tile-action>
                  <v-list-tile-title>Размер</v-list-tile-title>
                </v-list-tile> -->
                <v-list-tile v-if="fontSize">
                  <v-slider
                    v-model="settings.size"
                    :min="5"
                    :max="80"
                    thumb-label
                  ></v-slider>
                </v-list-tile>          
                <v-list-tile @click="fontPicker = true">
                  <v-list-tile-action>
                    <v-avatar size="36px" color="primary">F</v-avatar>
                  </v-list-tile-action>
                  <v-list-tile-title :class="settings.font">Font</v-list-tile-title>
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

    <font-picker
      v-if="fontPicker"
      :model="settings.font"
      :fonts="fonts"
      @update="settings.font = $event"
      @close="fontPicker = false, $store.dispatch('rightDrawerToggle', true)"
    ></font-picker>

  </div>
</template>

<script>
import axios from 'axios'
import ColorPicker from '../../../App/components/ColorPicker.vue'
import FontPicker from '../../../App/components/FontPicker.vue'

export default {
  components: {
    ColorPicker, FontPicker
  },
  props: {
    title: {
      type: String,
      required: true
    },
    settings: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
      fontPicker: false,
      fontSize: false,
      picker: false,
      fonts: [],
    }
  },
  methods: {
    fetchFonts() {
      axios.get('/fonts').then(response => {
        this.fonts = response.data
      })
    }
  },
  created () {
    this.fetchFonts()
  }
}
</script>
