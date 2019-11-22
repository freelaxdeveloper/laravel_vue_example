<template>
  <v-layout row wrap>
    <v-flex xs12>
      {{ music.name }}
    </v-flex>
    <v-flex xs4>
        <v-btn
          small
          color="primary"
          @click.stop="start"
        >
          <v-icon v-text="play ? 'mdi-pause' : 'mdi-play'"></v-icon>
        </v-btn>        
        <v-btn
          small
          color="primary"
          @click.stop="sound.stop(), play = false"
          :disabled="!play"
        >
          <v-icon>mdi-stop</v-icon>
        </v-btn>
    </v-flex>
    <v-flex xs4>
      <v-slider
        v-model="volume"
        append-icon="volume_up"
        prepend-icon="volume_down"
        :min="1"
        :max="9"
        style="width: 200px;margin-top: 4px;"
      ></v-slider>
    </v-flex>
    <v-flex xs1>
      <v-btn
        small
        color="primary"
        :disabled="currentSound === music.src && choose"
        @click="$emit('update-music', {src: music.src, volume}), choose = true, btnSaveText = 'Выбрать'"
        v-text="btnSaveText"
      >
        Выбрать
      </v-btn>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  props: {
    settings: {
      type: Object,
      required: true
    },
    music: {
      type: Object,
      required: true
    }
  },
  computed: {
    stopExecpt: function () {
      return this.$store.state.stopExecpt
    },
    currentSound: function (val) {
      return this.$store.state.settings.donate.main.sound.src
    }
  },
  watch: {
    stopExecpt: function (val) {
      if (!this.sound) {
        return
      }
      if (val !== this.id) {
        this.sound.stop()
        this.play = false
      }
    },
    play: function (val) {
      if (!this.sound) {
        return
      }
      if (val === true) {
      console.log('play')
        this.sound.play()
      } else {
        this.sound.pause(this.id)
      }
    },
    volume: function (val) {
      this.choose = false
      this.btnSaveText = 'Сохранить'
      this.sound.volume(`0.${val}`);
    }
  },
  data () {
    return {
      play: false,
      sound: null,
      id: null,
      volume: this.settings.volume,
      choose: true,
      btnSaveText: 'Выбрать'
    }
  },
  methods: {
    start () {
      if (!this.sound) {
        this.playsound()
      }
      this.play = !this.play
    },
    playsound () {
      console.log('music src = ', this.music.src)
      this.sound = new Howl({
        src: this.music.src,
        volume: `0.${this.volume}`,
        onplay: (id) => {
          this.id = id
          this.$store.dispatch('stopAll', this.id)
          // console.log('start!', this.sound.duration(id));
        },
        onend: () => {
          this.play = false
          // console.log('Finished!');
        }
      });
    }
  },
  created () {
    // this.playsound()
  }
}
</script>
