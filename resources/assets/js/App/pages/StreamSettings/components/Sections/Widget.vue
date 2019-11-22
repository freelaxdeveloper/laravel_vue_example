<template>
  <div>
    <v-toolbar
      card
      color="purple"
    >
      <v-icon>mdi-widgets</v-icon>
      <v-toolbar-title class="font-weight-light" v-text="widget.name"></v-toolbar-title>
      <v-spacer></v-spacer>

      <v-btn icon @click="$emit('widget-settings', widget)">
        <v-icon>mdi-settings</v-icon>
      </v-btn>

      <v-btn icon @click="$emit('close')">
        <v-icon>close</v-icon>
      </v-btn>

    </v-toolbar>

    <v-list class="pa-2" v-if="message">
      <message-template
        :message="message"
        :settings="settings"
      ></message-template>

      <!-- <text-marquee
        :style="style"
        v-if="settings.marquee" 
        :content="message" 
        :speed="settings.speed"
      ></text-marquee>
      <span 
        v-else 
        v-text="message"
        :style="style"
      ></span> -->

      <v-card flat>
        <v-text-field
          readonly
          label="Ссылка для вставки в стрим"
          v-model="widget.link"
          outline
          append-icon="mdi-content-copy"
          @click:append="doCopy(widget.link)"
        ></v-text-field>
      </v-card>

    </v-list>

  </div>
</template>

<script>
import axios from 'axios'
import MessageTemplate from '../Widgets/template'

export default {
  components: {
    MessageTemplate
  },
  props: {
    widget: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
      message: '',
      streamLink: ''
    }
  },
  computed: {
    settings: function () {
      return this.widget.settings
    },
    style: function () {
      let style = ''
      if (this.settings.color.hex8) {
        style = style + `color:${this.settings.color.hex8};`
      }
      if (this.settings.size) {
        style = style + `font-size:${this.settings.size}px;`
      }
      return style
    }
  },
  watch: {
    'widget.slug': function () {
      this.fetchMessage()
    }
  },
  methods: {
    doCopy (text) {
      this.$copyText(text).then((e) => {
        this.$store.dispatch('snackbar', {text: 'Скопировано в буфер обмена'})
      }, (e) => {
        this.$store.dispatch('snackbar', {text: 'Ошибка при копировании', color: 'error'})
      })
    },
    fetchStramLink () {
      axios.get(`/mystreamlink`).then(response => {
        this.streamLink = response.data
        this.fetchMessage()
        // console.log(this.streamLink)
      })
    },
    fetchMessage () {
      axios.post(`/insidestreaming/${this.widget.user_id}/${this.streamLink}/${this.widget.uri}`, this.widget.options).then(response => {
        this.message = response.data
      })
    }
  },
  created () {
    this.fetchStramLink()
  }
}
</script>