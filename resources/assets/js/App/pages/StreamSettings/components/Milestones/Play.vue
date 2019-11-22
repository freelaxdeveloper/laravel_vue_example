<template>
  <div>
    <v-btn @click.stop="start" icon>
      <v-icon v-text="!play ? 'mdi-play' : 'mdi-stop'"
      ></v-icon>
    </v-btn>
    {{ music.name }}
  </div>
</template>

<script>
import howler from 'howler'

export default {
  // components: {
  //   Sound
  // },
  props: {
    music: {
      type: Object,
      required: true
    }
  },
  watch: {
    play: function (val) {
      if (!this.sound) {
        return
      }
      if (val === true) {
      // console.log('play')
        this.sound.play()
      } else {
        this.sound.stop(this.id)
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
      id: null,
      play: false,
      sound: null,
      volume: 5,
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
      this.sound = new Howl({
        src: this.music.src,
        volume: `0.${this.volume}`,
        onplay: (id) => {
          this.id = id
          // this.$store.dispatch('stopAll', this.id)
          // console.log('start!', this.sound.duration(id));
        },
        onend: () => {
          this.play = false
          // console.log('Finished!');
        }
      });
    }
  },
}
</script>