<template>
  <div>
    <v-toolbar
      card
      color="purple"
    >
      <v-icon>mdi-gamepad</v-icon>
      <v-toolbar-title class="font-weight-light">Майлстоун</v-toolbar-title>
      <v-spacer></v-spacer>

      <v-btn icon @click="$emit('close')">
        <v-icon>close</v-icon>
      </v-btn>

    </v-toolbar>

    <v-list dense>
      <v-list-tile>
        <v-list-tile-content>Донат:</v-list-tile-content>
        <v-list-tile-content class="align-end" v-text="`${milestone.donate}руб.`"></v-list-tile-content>
      </v-list-tile>

      <v-list-tile>
        <v-list-tile-content>Бейджиков:</v-list-tile-content>
        <v-list-tile-content class="align-end" v-text="`${milestone.badges_count}шт.`"></v-list-tile-content>
      </v-list-tile>

      <v-list-tile>
        <v-list-tile-content>Анимаций:</v-list-tile-content>
        <v-list-tile-content class="align-end" v-text="`${milestone.animations_count}шт.`"></v-list-tile-content>
      </v-list-tile>

      <v-list-tile>
        <v-list-tile-content>Мелодий:</v-list-tile-content>
        <v-list-tile-content class="align-end" v-text="`${milestone.music_count}шт.`"></v-list-tile-content>
      </v-list-tile>
    </v-list>


    <v-card>
      <v-container grid-list-sm fluid>
        <v-layout row wrap>
          <v-flex
            v-for="badge in milestone.badges"
            :key="`badge_${badge.id}`"
            xs2
            d-flex
          >
            <v-card flat tile class="d-flex">
              <v-img
                :src="badge.src"
                class="grey"
                contain
              >
                <v-layout
                  slot="placeholder"
                  fill-height
                  align-center
                  justify-center
                  ma-0
                >
                  <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                </v-layout>
              </v-img>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-card>

    <v-card>
      <v-container grid-list-sm fluid>
        <v-layout row wrap>
          <v-flex
            v-for="animate in milestone.animations"
            :key="`badge_${animate.id}`"
            xs2
            d-flex
          >
            <v-btn color="primary" v-text="animate.animate"></v-btn>
          </v-flex>
        </v-layout>
      </v-container>
    </v-card>

    <v-card>
      <sound
        v-for="music in milestone.music"
        :key="`badge_${music.id}`"
        :music="music"
      ></sound>
    </v-card>

  </div>
</template>

<script>
import Sound from '../../../../components/Sound'

export default {
  components: {
    Sound
  },
  props: {
    milestone: {
      type: Object,
      required: true
    }
  }
}
</script>