<template>
  <div class="text-xs-center">
    <v-menu
      v-model="menu"
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

      <v-card>
        <!-- <v-list v-if="settings.text">
          <v-list-tile>

            <v-list-tile-content>
                <v-text-field
                  solo
                  label="Regular"
                  v-model="settings.text"
                ></v-text-field>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>

        <v-divider v-if="settings.text"></v-divider> -->

        <v-list>
          <v-list-tile @click="picker = true, $store.dispatch('rightDrawerToggle', false)">
            <v-list-tile-action>
              <v-avatar size="36px" :color="settings.bgColor"> </v-avatar>
            </v-list-tile-action>
            <v-list-tile-title>Цвет</v-list-tile-title>
          </v-list-tile>
          <v-list-tile @click="fontSize = !fontSize">
            <v-list-tile-action>
              <v-avatar size="36px" color="primary" v-text="settings.size"></v-avatar>
            </v-list-tile-action>
            <v-list-tile-title>Размер</v-list-tile-title>
          </v-list-tile>
          <v-list-tile v-if="fontSize">
            <v-slider
              v-model="settings.size"
              :min="7"
              :max="22"
              thumb-label
            ></v-slider>
          </v-list-tile>          
          <v-list-tile @click="fontPicker = true">
            <v-list-tile-action>
              <v-avatar size="36px" color="primary">F</v-avatar>
            </v-list-tile-action>
            <v-list-tile-title :class="settings.fontFamily">FontFamily</v-list-tile-title>
          </v-list-tile>
          <v-list-tile @click="iconPicker = true">
            <v-list-tile-action>
              <v-avatar size="36px" color="primary"><v-icon dark v-text="settings.icon"></v-icon></v-avatar>
            </v-list-tile-action>
            <v-list-tile-title>Иконка</v-list-tile-title>
          </v-list-tile>
          <v-list-tile>
            <v-switch
              color="primary"
              label="Flat"
              v-model="settings.flat"
            ></v-switch>
          </v-list-tile>
          <v-list-tile>
            <v-switch
              :disabled="settings.flat"
              color="primary"
              label="Light"
              v-model="settings.light"
            ></v-switch>
          </v-list-tile>
        </v-list>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn color="primary" flat @click="menuClose">Закрыть</v-btn>
        </v-card-actions>
      </v-card>
    </v-menu>

    <color-picker
      v-if="picker"
      :model="settings.bgColor"
      @update-color="settings.bgColor = $event.hex"
      @close="picker = false"
    ></color-picker>

    <font-picker
      v-if="fontPicker"
      :model="settings.fontFamily"
      :fonts="fonts"
      @update="settings.fontFamily = $event"
      @close="fontPicker = false, $store.dispatch('rightDrawerToggle', true)"
    ></font-picker>

    <icon-picker
      v-if="iconPicker"
      :model="settings.icon"
      @update="settings.icon = $event"
      @close="iconPicker = false"
    ></icon-picker>

  </div>
</template>

<script>
import ColorPicker from '../ColorPicker.vue'
import FontPicker from '../FontPicker.vue'
import IconPicker from '../IconPicker.vue'

export default {
  components: {
    ColorPicker, FontPicker, IconPicker
  },
  props: {
    fonts: {
      type: Array,
      required: true,
    },
    settings: {
      type: Object,
      required: true,
    }
  },
  data(){
    return {
      menu: false,
      picker: false,
      fontPicker: false,
      iconPicker: false,
      fontSize: false
    }
  },
  methods: {
    menuClose () {
      this.menu = false
      this.fontSize = false
    }
  }
}
</script>
