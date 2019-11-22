<template>
  <div>
    <v-list-group
      prepend-icon="mdi-widgets"
      :value="false"
    >
      <v-list-tile slot="activator">
        <v-list-tile-title>Виджеты</v-list-tile-title>
        <v-list-tile-action>
          <v-btn 
            icon 
            @click.stop="$emit('section-update', {name: 'statistic'})"
          >
            <v-icon>add</v-icon>
          </v-btn>
        </v-list-tile-action>
      </v-list-tile>

      <v-list-tile 
        v-for="(widget, i) in widgets" 
        :key="`widget_${widget.slug}`"
        avatar
        @click="updateSection(widget)"
      >
        <v-list-tile-title v-text="`${widget.id}) ${widget.name}`"></v-list-tile-title>
        <v-list-tile-action>
          <v-btn 
            icon 
            @click.stop="deleteWidget(widget, i)"
          >
            <v-icon>delete</v-icon>
          </v-btn>
        </v-list-tile-action>
      </v-list-tile>
      <v-list-tile 
        v-if="!widgets.length" 
      >
        <v-list-tile-title>Данных нет</v-list-tile-title>
      </v-list-tile>
    </v-list-group>

  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    widgets: {
      type: Array,
      required: true
    }
  },
  data: () => ({
    // widgets: [],
  }),
  methods: {
    updateSection (widget) {
      this.$emit('section-update', {name: 'widget', param: widget})
    },
    deleteWidget (widget, index) {
      axios.delete(`/widget/${widget.slug}`).then(response => {
        this.$store.dispatch('snackbar', {text: response.data})
        this.widgets.splice(index, 1)
        this.$emit('section-update', {name: '', param: ''})
      }).catch(error => {
        this.$store.dispatch('errors', error.response.data.errors)
      })
      
    },
    // fetchWidgets () {
    //   axios.get('/widget/list').then(response => {
    //     this.widgets = response.data
    //   })
    // }
  },
  created () {
    // this.fetchWidgets()
  }
}
</script>