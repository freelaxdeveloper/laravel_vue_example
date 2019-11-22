<template>
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
        <v-container>

          <!-- <v-list-tile> -->
            <v-text-field
              v-model="settings.donatevideolimit"
              label="Минимальная сумма доната для заказа видео"
            ></v-text-field>
          <!-- </v-list-tile> -->

        </v-container>
      </v-card>

  </v-menu>
</template>

<script>
export default {
  props: {
    settings: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
      menu: false,
    }
  }
}
</script>