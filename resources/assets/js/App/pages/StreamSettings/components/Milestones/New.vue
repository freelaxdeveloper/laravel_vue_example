<template>
  <v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">Создание майлстоуна</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12>
                <v-text-field
                  v-model="donate"
                  label="Сумарный донат"
                  hint="Сумарный донат (общий донат за всё время) при которой бонусы из этого майлстоуна станут доступными"
                  suffix="руб."
                  required
                ></v-text-field>
              </v-flex>
              <v-flex xs12>

                <v-autocomplete
                  v-model="selectBadges"
                  :items="badges"
                  chips
                  color="blue-grey lighten-2"
                  label="Выберите бейджики"
                  item-text="name"
                  item-value="id"
                  multiple
                >
                  <template
                    slot="selection"
                    slot-scope="data"
                  >
                    <v-chip
                      :selected="data.selected"
                      close
                      class="chip--select-multi"
                      @input="remove(data.item)"
                      color="#716e6e"
                    >
                      <v-avatar>
                        <img :src="data.item.src">
                      </v-avatar>
                      <!-- {{ data.item.name }} -->
                    </v-chip>
                  </template>
                  <template
                    slot="item"
                    slot-scope="data"
                  >
                    <template v-if="typeof data.item !== 'object'">
                      <v-list-tile-content v-text="data.item"></v-list-tile-content>
                    </template>
                    <template v-else>
                      <v-list-tile-avatar>
                        <img :src="data.item.src">
                      </v-list-tile-avatar>
                      <v-list-tile-content>
                        <v-list-tile-title v-html="data.item.name"></v-list-tile-title>
                        <v-list-tile-sub-title v-html="data.item.group"></v-list-tile-sub-title>
                      </v-list-tile-content>
                    </template>
                  </template>
                </v-autocomplete>

                <v-autocomplete
                  v-model="selectAnimations"
                  :items="animations"
                  chips
                  color="blue-grey lighten-2"
                  label="Анимации"
                  item-value="animate"
                  item-text="animate"
                  multiple
                >
                  <template
                    slot="selection"
                    slot-scope="data"
                  >
                    <v-chip
                      :selected="data.selected"
                      close
                      class="chip--select-multi"
                      @input="removeAnimate(data.item)"
                      color="#716e6e"
                      @click.stop="data.item.test.duration = 2000"
                    >
                      {{ data.item.animate }}
                    </v-chip>
                  </template>
                  <template
                    slot="item"
                    slot-scope="data"
                  >
                    <template v-if="typeof data.item !== 'object'">
                      <v-list-tile-content v-text="data.item"></v-list-tile-content>
                    </template>
                    <template v-else>
                      <!-- <v-list-tile-avatar>
                        <img :src="data.item.src">
                      </v-list-tile-avatar> -->
                      <v-list-tile-content>
                        <!-- {{data.item.animate}} -->
                        <v-list-tile-title v-html="data.item.animate"></v-list-tile-title>
                        <!-- <v-list-tile-sub-title v-html="data.item.group"></v-list-tile-sub-title> -->
                      </v-list-tile-content>
                    </template>
                  </template>
                </v-autocomplete>

                <v-autocomplete
                  v-model="selectMusic"
                  :items="music"
                  chips
                  color="blue-grey lighten-2"
                  label="Мелодии"
                  item-value="src"
                  item-text="name"
                  multiple
                >
                  <template
                    slot="selection"
                    slot-scope="data"
                  >
                    <v-chip
                      :selected="data.selected"
                      close
                      class="chip--select-multi"
                      @input="removeMusic(data.item)"
                      color="#716e6e"
                    >
                      {{ data.item.name }}
                    </v-chip>
                  </template>
                  <template
                    slot="item"
                    slot-scope="data"
                  >
                    <template v-if="typeof data.item !== 'object'">
                      <v-list-tile-content v-text="data.item"></v-list-tile-content>
                    </template>
                    <template v-else>
                      <play :music="data.item"></play>
                    </template>
                  </template>
                </v-autocomplete>

              </v-flex>
            </v-layout>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click="dialog = false">Отмена</v-btn>

          <v-btn 
            color="blue darken-1" 
            flat
            @click="create"
            :loading="loading"
          >Создать</v-btn>

        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
import axios from 'axios'
import AnimateText from '../../../../components/Animate'
import Play from './Play'

export default {
  components: {
    AnimateText, Play
  },
  props: {
    show: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    user: function () {
      return this.$store.state.user
    },
    dialog: {
      get () {
        return this.show
      },
      set (val) {
        this.$emit('update-show', val)
      }
    }
  },
  data: () => ({
    loading: false,
    donate: '',
    badges: [],
    animations: [],
    music: [],
    selectMusic: [],
    selectBadges: [],
    selectAnimations: []
  }),
  methods: {
    create () {
      this.loading = true
      let options = {
        badges: this.selectBadges,
        music: this.selectMusic,
        animations: this.selectAnimations,
        donate: this.donate
      }
      axios.post('/mailstone/add', options).then(response => {
        this.loading = false
        this.$emit('create-milestone', response.data)
        this.selectBadges = []
        this.selectAnimations = []
        this.donate = ''
        this.dialog = false
      }).catch((error) => {
        this.loading = false
        this.$store.dispatch('errors', error.response.data.errors)
      });
      
    },
    removeAnimate (item) {
      const index = this.selectAnimations.indexOf(item.animate)
      if (index >= 0) this.selectAnimations.splice(index, 1)
    },
    remove (item) {
      const index = this.selectBadges.indexOf(item.id)
      if (index >= 0) this.selectBadges.splice(index, 1)
    },
    removeMusic (item) {
      const index = this.selectMusic.indexOf(item.src)
      if (index >= 0) this.selectMusic.splice(index, 1)
    },
    fetchBadges () {
      axios.get('/mailstone/badges').then(response => {
        this.badges = response.data
      })
    },
    fetchAnimations () {
      axios.get('/mailstone/animations').then(response => {
        this.animations = response.data
      })
    },
    fetchMusic () {
      axios.get(`/mailstone/${this.user.id}/music`).then(response => {
        this.music = response.data
      })
    }
  },
  watch: {
    user () {
      this.fetchBadges()
      this.fetchAnimations()
      this.fetchMusic()
    }
  }, 
  mounted () {
    if (this.user.id) {
      this.fetchBadges()
      this.fetchAnimations()
      this.fetchMusic()
    }
  }
}
</script>