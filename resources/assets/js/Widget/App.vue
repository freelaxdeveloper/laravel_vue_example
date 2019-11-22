<template>
  <v-app id="inspire">
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 v-if="message">
          <v-card>
            <v-card-text class="text-xs-center" v-if="message">
                <message-template-new
                :message="message"
                :settings="widget.settings2"
                />
            </v-card-text>
          </v-card>
          <!-- <div class="custom-widget">
            <div :class="['custom-widget-message', widget.settings2.widget_animation.class_name]" :style="{ color: widget.settings2.widget_color, fontSize: widget.settings2.widget_font_size + 'px' , 'animation-duration': (widget.settings2.widget_animation_delay/1000) +'s' }" v-html="message.fullMessage">
            </div>
          </div> -->

          <!-- <v-card color="#00000000" flat>
            <v-card-text class="text-xs-center" v-if="message">
              <message-template
                :message="message"
                :settings="widget.settings"
              ></message-template>
            </v-card-text>
          </v-card> -->
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import axios from 'axios'
import MessageTemplate from '../App/pages/StreamSettings/components/Widgets/template'
import MessageTemplateNew from '../App/pages/StreamSettings/components/Widgets/template-new'

export default {
  components: {
    MessageTemplate, MessageTemplateNew
  },
  data () {
    return {
      widget: null,
      category: null,
      message: null
    }
  },
  methods: {
    setWidget () {
      let widget = document.head.querySelector('meta[name="widget"]')
      let category = document.head.querySelector('meta[name="category"]')
      this.widget = JSON.parse(widget.content)
      this.category = JSON.parse(category.content)

      this.getInsideStreaming()
    },
    getInsideStreaming () {
      axios.post(`/insidestreaming/${this.widget.user.id}/${this.widget.stream_hash_link}/${this.category.method}`, this.widget.settings2).then(response => {
        this.message = response.data
      })
    }
  },
  created () {
    this.setWidget()
  }
}
</script>

<style>
  ::-webkit-scrollbar
{
  width: 0;  /* for vertical scrollbars */
  height: 0; /* for horizontal scrollbars */
}
</style>

<style>
div.widget-slider, div.crawl-line {
  width: 100%;
  overflow: hidden;
  animation: widget-slider;
  margin-top: 0%;
  animation-iteration-count: infinite;
}

@keyframes widget-slider {
  from {
    margin-left: 100%;
  }
  to {
    margin-left: 0%;
  }
}
</style>
<style lang="scss">
.v-card {
  box-shadow: none;
}
.theme--light.application {
  overflow:  hidden;
  background-color: #0000;
}
</style>
