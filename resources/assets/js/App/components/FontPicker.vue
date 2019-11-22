<template>
  <div>
    <v-dialog v-model="dialog" scrollable persistent max-width="290">
      <v-card>
        <v-card-text>
          <v-radio-group v-model="font" column>
            <v-radio
              :class="font.class"
              :label="font.name"
              :value="font.class"
              :key="i" 
              v-for="(font, i) in fonts" 
            ></v-radio>
          </v-radio-group>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" flat @click.native="close">Закрыть</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: {
    model: {
      required: true
    },
    fonts: {
      type: Array,
      required: true
    }
  },
  watch: {
    font: function (val) {
      this.$emit('update', val)
    }
  },
  data () {
    return {
      dialog: true,
      font: this.model
    }
  },
  methods: {
    close () {
      this.$store.dispatch('rightDrawerToggle', true)
      this.$emit('close')
    }
  }
}
</script>
