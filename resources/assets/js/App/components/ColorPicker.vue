<template>
  <div>
    <v-dialog v-model="dialog" scrollable persistent max-width="290">
      <v-card>
        <v-card-text>
          <sketch v-model="color" />
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
import { Sketch } from 'vue-color'

export default {
  components: {
    Sketch
  },
  props: {
    model: {
      required: true
    },
    openMenuWhenClosing: {
      type: Boolean,
      default: true
    }
  },
  computed: {
    color: {
      set (val) {
        this.$emit('update-color', val)
      },
      get () {
        return this.model
      }
    }
  },
  data () {
    return {
      dialog: true
    }
  },
  methods: {
    close () {
      //this.dialog = false
      this.$emit('close')
      if (this.openMenuWhenClosing) {
        this.$store.dispatch('rightDrawerToggle', true)
      }
    }
  }
}
</script>
