<template>
<v-layout row justify-center>
  <v-dialog v-model="dialog" width="600px">
  <v-item-group>
    <v-container grid-list-md>
      <v-layout wrap>
        <v-flex
          v-for="(item, i) in icons"
          :key="i"
          xs1
        >
          <v-item>
            <v-card
              slot-scope="{ active, toggle }"
              :color="active ? 'primary' : ''"
              class="d-flex align-center"
              dark
              height="48"
              @click.native="toggle"
            >
              <v-scroll-y-transition>
                <v-icon left dark @click="icon = !active ? item : ''" v-text="item"></v-icon>
              </v-scroll-y-transition>
            </v-card>
          </v-item>
        </v-flex>
      </v-layout>
    </v-container>
  </v-item-group>
  </v-dialog>
  </v-layout>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    model: {
      required: true
    },
  },
  watch: {
    icon: function (val) {
      this.$emit('update', val)
    },
    dialog: function (val) {
      if (val === false) {
        this.$emit('close')
      }
    }
  },
  data () {
    return {
      dialog: true,
      icon: '',
      icons: []
    }
  },
  methods: {
    fetchIcons () {
      axios.get('/icons').then(response => {
        this.icons = response.data
      })
    }
  },
  created () {
    this.fetchIcons()
  }
}
</script>
