<template>
  <div>
    <p>Ваш донат: {{mydonat}}руб.</p>
    <p>Чем больше донат, тем больше бонусов вы получаете!</p>

    <v-autocomplete
      v-model="badge"
      :items="badges"
      box
      chips
      color="blue-grey lighten-2"
      label="Выберите бейджик"
      item-text="name"
      item-value="id"
      item-disabled="disabled"
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
        >
          <v-avatar>
            <img :src="data.item.src">
          </v-avatar>
          {{ form.ank.login }}
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
      box
      v-model="selectMusic"
      :items="music"
      chips
      color="blue-grey lighten-2"
      label="Мелодии"
      item-value="src"
      item-text="name"
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

    <v-select
      v-model="animation"
      :items="animations"
      item-text="animate"
      item-value="pivot.id"
      box
      label="Анимация"
      clearable
    ></v-select>

    <v-text-field
      box
      v-model="youtube"
      label="Видео YouTube"
      :rules="youtubeRules"
      :disabled="youtubeDisabled"
    ></v-text-field>
    <small v-if="youtubeDisabled">Что бы добавить видео, необходима сумма доната не меньше {{settings.other.donatevideolimit}}руб.</small>
  </div>
</template>

<script>
  import Play from '../../pages/StreamSettings/components/Milestones/Play'
  import axios from 'axios'

  export default {
    components: {
      Play
    },
    props: {
      mydonat: {
        type: String,
        default: 0
      },
      user_id: {
        required: true
      },
      form: {
        type: Object,
        required: true
      },
      settings: {
        type: Object,
        required: true
      }
    },
    data () {
      return {
        badge: '',
        animation: '',
        selectMusic: '',
        music: [],
        badges: [],
        animations: [],
        youtube: '',
        youtubeRules: [
          v => v.match(/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/) || 'Не корректный адресс видео'
        ],
     }
    },
    computed: {
      amount () {
        return this.form.amount
      },
      youtubeDisabled () {
        return this.settings.other.donatevideolimit > this.amount
      },
      jwt_token() {
        return this.$store.state.jwt_token
      }
    },
    watch: {
      'form.amount': function () {
        if (this.youtubeDisabled) {
          this.youtube = ''
        }
      },
      youtube (v) {
        if (v && this.youtubeDisabled) {
          this.youtube = ''
          return
        }
        this.$emit('update-youtube', this.youtube)
      },
      badge () {
        this.$emit('update-badge', this.badge)
      },
      animation () {
        this.$emit('update-animation', this.animation)
      },
      selectMusic () {
        this.$emit('update-music', this.selectMusic)
      }
    },

    methods: {
      fetchMlestones () {
        axios.get(`/premium/${this.user_id}/milestones`).then(response => {
          this.badges = response.data.badges
          this.animations = response.data.animations
          this.music = response.data.music
        })
      },
      remove (item) {
        this.badge = ''
        this.animation = ''
        // const index = this.friends.indexOf(item.name)
        // if (index >= 0) this.friends.splice(index, 1)
      }
    },
    created () {
      if (this.jwt_token) {
        this.fetchMlestones()
      }
    }
  }
</script>