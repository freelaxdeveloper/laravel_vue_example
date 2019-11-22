<template>
  <div>

    <div
      v-for="(item, index) in array"
      :key="`animate_${index}_${item}`"
      style="display:inline-block;"
    >
      &nbsp;
      <div 
        v-animate-css="{ 
          classes: animate, 
          delay: item.delay, 
          duration: duration, 
          iteration: 60 
        }"
        v-text="item.symbol"
      >
      </div>
    </div>

  </div>
</template>

<script>
import { VTextMarquee } from 'vue-text-marquee'

export default {
  components: {
    VTextMarquee
  },
  props: {
    text: {
      type: String,
      required: true
    },
    duration: {
      type: Number,
      default: 1000
    },
    animate: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      array: []
    }
  },
  methods: {
    getRandomInt(min, max) {
      return Math.floor(Math.random() * (max - min)) + min;
    },
    toArray () {
      let delays = [100, 200, 300, 400, 500, 400, 200]

      for(let i = 0, b = 0; i < this.text.length; i++, b++) {
        if (b > delays.length) {
          b = 0
        }
        this.array.push({
          symbol: this.text[i],
          delay: delays[b]
        })
      }
    }
  },
  created () {
    this.toArray()
  }
}
</script>
