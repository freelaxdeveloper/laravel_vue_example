<template>
  <div>
    <v-toolbar
      card
      color="purple"
    >
      <v-icon>mdi-chart-bar</v-icon>
      <v-toolbar-title 
        class="font-weight-light"
        v-text="widget ? widget.name : 'Новый виджет'"
      ></v-toolbar-title>
      <v-spacer></v-spacer>

      <v-btn icon @click="$emit('close')">
        <v-icon>close</v-icon>
      </v-btn>

    </v-toolbar>
    <v-list class="pa-2">

      <message-template
        :message="message"
        :settings="settings"
      ></message-template>
      
      <v-layout wrap>
        <v-flex xs6>
          <v-radio-group v-model="selectType">
            <v-radio
              v-for="item in list"
              :key="`type_${item.id}`"
              :label="item.name"
              :value="item.id"
            ></v-radio>
          </v-radio-group>
        </v-flex>
        <v-flex xs3 v-if="selectStat.subscribe">
          <v-radio-group v-model="selectSubscriber">
            <v-radio
              v-for="item in listSubscribers"
              :key="`subscriber_${item.id}`"
              :label="item.name"
              :value="item.id"
            ></v-radio>
          </v-radio-group>
        </v-flex>
        <v-flex xs3 v-if="selectStat.period">
          <v-radio-group v-model="selectPeriod">
            <v-radio
              v-for="item in listPeriod"
              :key="`period_${item.id}`"
              :label="item.name"
              :value="item.id"
            ></v-radio>
          </v-radio-group>
        </v-flex>
        <v-flex xs12>
          <v-card flat>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                small
                color="primary"
                @click="save"
                v-if="!widget"
              >Добавить</v-btn>
              <v-btn
                small
                color="primary"
                @click="editWidget"
                v-else
              >Сохранить</v-btn>
            </v-card-actions>
          </v-card>
        </v-flex>
      </v-layout>
    </v-list>

    <v-toolbar
      card
      color="purple"
    >
      <v-icon>mdi-settings</v-icon>
      <v-toolbar-title class="font-weight-light">Настройки</v-toolbar-title>
    </v-toolbar>
    <v-list class="pa-2">
      <v-text-field
        v-model="nameWidget"
        label="Сообщение"
        :hint="selectStat.hint"
      ></v-text-field>

      <div v-if="selectStat.limit">
        <v-subheader class="pl-0">Количество</v-subheader>
        <v-slider
          v-model="limit"
          thumb-label="always"
          min="0"
        ></v-slider>
      </div>

      <!-- <v-checkbox
        v-model="settings.marquee"
        label="Бегущая строка"
        :disabled="settings.vertical"
      ></v-checkbox> -->

      <v-radio-group v-model="settings.presentationMethod" row>
        <v-radio label="Бегщая строка" value="marquee"></v-radio>
        <v-radio label="Слайдер" value="slider" :disabled="selectStat.disableSlider"></v-radio>
        <v-radio label="Список" value="block"></v-radio>
        <v-radio label="Стандартно" value=""></v-radio>
      </v-radio-group>

      <!-- <v-switch
        :label="settings.vertical ? 'Отображать вертикально' : 'Отображать горизонтально'"
        v-model="settings.vertical"
      ></v-switch> -->

      <v-text-field
        v-if="settings.presentationMethod === 'slider'"
        v-model="settings.duration"
        label="Задержка между слайдами (микросекунды)"
        hint="Чем меньше значение, тем быстрее переключается"
      ></v-text-field>
      <v-subheader class="pl-0" v-if="settings.presentationMethod === 'marquee'">
        Скорость прокрутки
      </v-subheader>

      <v-slider
        v-if="settings.presentationMethod === 'marquee'"
        :max="255"
        v-model="settings.speed"
        thumb-label="always"
      ></v-slider>

      <v-subheader class="pl-0">
        Размер текста
      </v-subheader>
      <v-slider
        :max="settings.presentationMethod === 'slider' ? 10 : 100"
        v-model="settings.size"
        thumb-label="always"
      ></v-slider>

      <v-btn 
        @click="colorPicker = true"
        color="primary"
      >Цвет</v-btn>

    </v-list>


    <color-picker
      v-if="colorPicker"
      :model="settings.color"
      @update-color="settings.color = $event"
      @close="colorPicker = false"
      :openMenuWhenClosing="false"
    ></color-picker>

  </div>
</template>

<script>
import axios from 'axios'
import ColorPicker from '../../../../components/ColorPicker.vue'
import MessageTemplate from '../Widgets/template'

export default {
  components: {
    ColorPicker, MessageTemplate
  },
  props: {
    param: {
      default: null
    }
  },
  data () {
    return {
      colorPicker: false,
      settings: {
        duration: 1000,
        presentationMethod: '',
        marquee: false,
        speed: 50,
        color: {
          hex8: ''
        },
        size: 17,
        vertical: false,
        slider: false
      },
      selectType: 1,
      selectSubscriber: 4,
      selectPeriod: 7,
      limit: 2,
      list: [
        {id: 1, name: 'Последнее сообщение', uri: 'lastmessage', period: false, subscribe: false, template: 'Последнее сообщение: {{message}}', hint: '<b>{{message}}</b> - сообщение', disableSlider: true},
        // {id: 2, name: 'Самое дорогое сообщение', uri: 'mostexpensive', period: false, subscribe: false, limit: false},
        {id: 3, name: 'Самый(-е) крупный(-е) донатер(-ы)', uri: 'largestdonater', period: false, subscribe: false, limit: true, template: 'Самый(-е) крупный(-е) донатер(-ы): {{users}} || {{name}} {{sum}}', hint: '<b>{{users}}</b> - список пользователей, <b>{{name}}</b> - имя пользователя, <b>{{sum}}</b> - сумма доната'},
        {id: 9, name: 'Последний(-е) донатер(-ы)', uri: 'largestdonater', period: false, subscribe: false, limit: true, template: 'Последний(-е) донатер(-ы): {{users}} || {{name}} {{sum}}', hint: '<b>{{users}}</b> - список пользователей, <b>{{name}}</b> - имя пользователя, <b>{{sum}}</b> - сумма доната', options: {sort: 'id'}},
        {id: 4, name: 'Последний(-е) подписчик(-и)', uri: 'lastsubscriber', period: false, subscribe: true, limit: true, template: 'Последний(-е) подписчик(-и): {{subscriber}}', hint: ' <b>{{subscriber}}</b> - имя подписчика'},
        {id: 5, name: 'Количество подписчиков', uri: 'numbersubscribers', period: false, subscribe: true, limit: false, template: 'Количество подписчиков: {{count}}', hint: ' <b>{{count}}</b> - количество подписчиков', disableSlider: true},
        {id: 6, name: 'Количество подписчиков за период', uri: 'numbersubscribers', period: true, subscribe: true, limit: false, template: 'Количество подписчиков за период: {{count}} {{type}} {{period}}', hint: '<b>{{count}}</b> - количество подписчиков, <b>{{type}}</b> - тип подписки, <b>{{period}}</b> - именование периода', disableSlider: true},
        {id: 7, name: 'Собранная сумма', uri: 'amountcollected', period: false, subscribe: false, limit: false, template: 'Собранная сумма: {{sum}}', hint: '<b>{{sum}}</b> - сумма донатов', disableSlider: true},
        // {id: 8, name: 'Проигрываемый медиафайл'},
      ],
      listSubscribers: [
        {id: 1, name: 'Премиум', type: 'premium'},
        {id: 2, name: 'Платный', type: 'paid'},
        {id: 3, name: 'Бесплатный', type: 'free'},
        {id: 4, name: 'Любой', type: ''},
      ],
      listPeriod: [
        {id: 1, name: 'День', period: 'subDay', value: 1},
        {id: 2, name: 'Неделя', period: 'subWeek', value: 1},
        {id: 3, name: 'Месяц', period: 'subMonth', value: 1},
        {id: 4, name: 'Квартал', period: 'subQuarter', value: 1},
        {id: 5, name: 'Пол года', period: 'subQuarter', value: 2},
        {id: 6, name: 'Год', period: 'subYear', value: 1},
        {id: 7, name: 'Всё время', period: '', value: ''},
      ],
      message: '',
      streamLink: '',
      is_update: false
    }
  },
  watch: {
    'settings.presentationMethod': function (val) {
      if (val === 'slider') {
        this.settings.size = 1
      } else {
        this.settings.size = 17
      }
    },
    'settings.vertical': function (val) {
      if (val === true) {
        this.settings.marquee = false
      }
    },
    limit: function () {
      if (this.is_update) {
        return
      }
      this.is_update = true
      setTimeout(() => {
        this.fetchStat()
        this.is_update = false
      }, 1000);
    },
    selectType: function () {
      this.selectPeriod = 7
      this.selectSubscriber = 4
      this.fetchStat()
    },
    selectSubscriber: function () {
      this.fetchStat()
    },
    selectPeriod: function () {
      this.fetchStat()
    },
  },
  computed: {
    user_id: function () {
      return this.$store.state.user.id
    },
    widget: function () {
      return this.param
    },
    nameWidget: {
      get: function () {
        return this.selectStat.template
      },
      set: function (val) {
        this.selectStat.template = val
        if (this.is_update) {
          return
        }
        this.is_update = true
        setTimeout(() => {
          this.fetchStat()
          this.is_update = false
        }, 1000);
      }
    },
    selectStat: function () {
      const index = this.list.findIndex(i => i.id === this.selectType)
      return this.list[index]
    },
    selectedSubscriber: function () {
      const index = this.listSubscribers.findIndex(i => i.id === this.selectSubscriber)

      return this.listSubscribers[index]
    },
    selectedPeriod: function () {
      const index = this.listPeriod.findIndex(i => i.id === this.selectPeriod)

      return this.listPeriod[index]
    },
    options : function () {
      return {
        name: this.selectStat.template,
        options: this.selectStat.options,
        period: this.selectedPeriod.period,
        value: this.selectedPeriod.value,
        type: this.selectedSubscriber.type,
        limit: this.limit,
        vertical: this.settings.vertical,
      }
    }
  },
  methods: {
    editWidget () {
      let options = {
        name: this.selectStat.name,
        uri: this.selectStat.uri,
        settings: this.settings,
        options: this.options
      }
      axios.put(`/widget/${this.widget.slug}`, options).then(response => {
        this.$store.dispatch('snackbar', {text: 'Виджет успешно изменён'})
        this.$emit('update-widget-list', response.data)
      }).catch(error => {
        this.$store.dispatch('errors', error.response.data.errors)
      })
    },
    save () {
      let options = {
        name: this.selectStat.name,
        uri: this.selectStat.uri,
        settings: this.settings,
        options: this.options
      }
      axios.post('/widget/add', options).then(response => {
        this.$emit('create-widget', response.data)
        this.$store.dispatch('snackbar', {text: 'Виджет успешно добавлен'})
      }).catch(error => {
        this.$store.dispatch('errors', error.response.data.errors)
      })
    },
    fetchStramLink () {
      axios.get(`/mystreamlink`).then(response => {
        this.streamLink = response.data
        this.fetchStat()

        if (this.widget) {
          const typeIndex = this.list.map(x => x.name).indexOf(this.widget.name)
          if (this.widget.options.type) {
            const subscriberIndex = this.listSubscribers.map(x => x.type).indexOf(this.widget.options.type)
            this.selectSubscriber = this.listSubscribers[subscriberIndex].id
          }
          if (this.widget.options.period) {
            const periodIndex = this.listPeriod.map(x => x.period).indexOf(this.widget.options.period)
            this.selectPeriod = this.listPeriod[periodIndex].id
          }
          this.selectType = this.list[typeIndex].id
          this.settings = this.widget.settings
          this.limit = this.widget.options.limit
        }

      })
    },
    fetchStat () {
      this.options.is_test = true
      axios.post(`/insidestreaming/${this.user_id}/${this.streamLink}/${this.selectStat.uri}`, this.options).then(response => {
        this.message = response.data
        if (this.is_update) {
          this.is_update = false
        }
      })
    }
  },
  created () {
    this.fetchStramLink()
  }
}
</script>

<style lang="scss">
.v-messages {
  font-size: 11px !important;
}
</style>
