<template>
  <div>
    <v-list-group
      prepend-icon="mdi-gamepad"
      :value="false"
    >
      <v-list-tile slot="activator">
        <v-list-tile-title>Майлстоуны</v-list-tile-title>
        <v-list-tile-action>
          <v-btn 
            icon 
            @click.stop="dialog.new = true"
          >
            <v-icon>add</v-icon>
          </v-btn>
        </v-list-tile-action>
      </v-list-tile>

      <v-list-tile 
        v-for="(milestone, i) in milestones" 
        :key="`milestone_${milestone.id}`"
        avatar
        @click="updateSection(milestone)"
      >
        <v-list-tile-avatar>
          <v-icon>mdi-currency-rub</v-icon>
        </v-list-tile-avatar>
        <v-list-tile-title v-text="milestone.donate"></v-list-tile-title>
        <v-list-tile-action>
          <v-btn 
            icon 
            @click.stop="deleteMilestone(milestone, i)"
          >
            <v-icon>delete</v-icon>
          </v-btn>
        </v-list-tile-action>
      </v-list-tile>
      <v-list-tile 
        v-if="!milestones.length" 
      >
        <v-list-tile-title>Данных нет</v-list-tile-title>
      </v-list-tile>
    </v-list-group>

    <new-milestone 
      :show="dialog.new" 
      @update-show="dialog.new = $event"
      @create-milestone="milestones.push($event)"
    ></new-milestone>

  </div>
</template>

<script>
import axios from 'axios'

import NewMilestone from './New'

export default {
  components: {
    NewMilestone
  },
  data: () => ({
    dialog: {
      new: false,
    },
    milestones: []
  }),
  methods: {
    updateSection (milestone) {
      this.$emit('section-update', {name: 'milestone', param: milestone})
    },
    deleteMilestone (milestone, index) {
      axios.delete(`/mailstone/${milestone.id}`).then(response => {
        this.$store.dispatch('snackbar', {text: response.data})
        this.milestones.splice(index, 1)
        this.$emit('section-update', {name: '', param: ''})
      }).catch(error => {
        this.$store.dispatch('errors', error.response.data.errors)
      })
      
    },
    fetchMilestone () {
      axios.get('/mailstone/list').then(response => {
        this.milestones = response.data
      })
    }
  },
  created () {
    this.fetchMilestone()
  }
}
</script>