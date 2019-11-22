<template>
  <div>
    <text-marquee
      :style="style"
      v-if="settings.presentationMethod === 'marquee'" 
      :content="message.fullMessage" 
      :speed="settings.speed"
    ></text-marquee>
    <div v-else-if="settings.presentationMethod === 'slider'">
      <div :style="`${style}; font-size: ${settings.size}em;`">{{message.name}}</div>
      <vue-swimlane
        :scale="settings.size"
        :style="style"
        :transitionDuration="duration" 
        :words="message.items"
      ></vue-swimlane>
    </div>
    <div v-else-if="settings.presentationMethod === 'block'">
      <div :style="style">{{message.name}}</div>
      <div :style="style" v-for="(item, i) in message.items" :key="`template_item_${i}`">
        {{item}}
      </div>
    </div>
    <span 
      v-else 
      v-text="message.fullMessage"
      :style="style"
    ></span>
  </div>
</template>

<script>
import { VTextMarquee } from 'vue-text-marquee'

export default {
  components: {
    TextMarquee: VTextMarquee
  },
  props: {
    message: {
      required: true
    },
    settings: {
      required: true
    }
  },
  computed: {
    duration: function () {
      return Number(this.settings.duration)
    },
    style: function () {
      let style = ''
      if (this.settings.color.hex8) {
        style = style + `color:${this.settings.color.hex8};`
      }
      if (this.settings.size) {
        style = style + `font-size:${this.settings.size}pt;`
      }
      return style
    }
  },
}
</script>
