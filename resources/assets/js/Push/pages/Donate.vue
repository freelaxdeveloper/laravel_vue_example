<template>
  <v-app id="inspire" :dark="setupMode ? true : false">
      <video-bg v-if="completed && notification.title" :sources="[settings.video.src]">
        <arbitrary-position 
          :item="settings.position.title" 
          @update="settings.position.title = $event" 
          style="z-index: 2; position: absolute;"
        >
          <v-avatar slot="activator" :size="`${settings.name.size * 2}`" v-if="notification.image">
            <img :src="notification.image">
          </v-avatar>
          <animate-text
            v-if="notification.title"
            :text="notification.title" 
            :duration="notification.animate ? notification.animate.duration : 0" 
            :animate="notification.animate ? notification.animate.animate.animate : ''"
            :class="settings.name.font"
            :style="`font-size:${settings.name.size}px;color:${settings.name.color}`"
          ></animate-text>
        </arbitrary-position>

        <arbitrary-position 
          :item="settings.position.counter" 
          @update="settings.position.counter = $event"
          style="z-index: 2; position: absolute;"
        >
          <span 
            :class="settings.amount.font"
            :style="`font-size:${settings.amount.size}px;color:${settings.amount.color}`"
          >{{ notification.counter }}</span>
        </arbitrary-position>

      <arbitrary-position 
        :item="settings.position.message" 
        @update="settings.position.message = $event"
        style="z-index: 2; position: absolute;"
      >
        <p 
          :class="`text-xs-center ${settings.message.font}`" 
          :style="`font-size:${settings.message.size}px;color:${settings.message.color}`"
          v-text="notification.message"
        ></p>
      </arbitrary-position>

      <arbitrary-position 
        :item="settings.position.attachment" 
        @update="settings.position.attachment = $event"
        v-if="settings.attachment.type === 'image' && settings.attachment.src"
      >   
        <img @click.prevent.stop="" :src="settings.attachment.src" alt="image donate">
        <video-bg style="max-height:500px;" :sources="[settings.attachment.src]" v-if="settings.attachment.type === 'video'"></video-bg>
      </arbitrary-position>
    <!-- <v-btn
      v-if="setupMode"
      color="pink"
      dark
      @click.stop="$store.dispatch('rightDrawerToggle')"
    >
      Настроить
    </v-btn>
    <v-btn
      v-if="setupMode"
      color="primary"
      :disabled="!sound || stopBtnDisable"
      @click.stop="sound.stop(), stopBtnDisable = true"
    >
      Стоп
    </v-btn> -->

      <right-menu v-if="setupMode" :settings="settings" :notification="notification"></right-menu>
    </video-bg>
  </v-app>
</template>

<script>
  import axios from 'axios'
  import RightMenu from '../components/App/RightMenu'
  import howler from 'howler'
  import AnimateText from '../components/Animate'
  import VideoBg from 'vue-videobg'
  import ArbitraryPosition from '../components/ArbitraryPosition'


  export default {
    components: {
      RightMenu, AnimateText, VideoBg, ArbitraryPosition
    },
    computed: {
      positionChangeMode: function () {
        return this.$store.state.positionChangeMode
      },
      drawer: {
        set (val) {
          if (val === false) {
            this.$store.dispatch('rightDrawerToggle', val)
          }
        },
        get () {
          return this.$store.state.settings.rightDrawer
        }
      },
      settings: {
        set () {
          this.$store.dispatch('settingsDonatePage', this.settings)
        },
        get () {
          return this.$store.state.settings.donate
        }
      },
      user: function () {
        return this.$store.state.user
      },
      token: function () {
        return this.$store.state.token
      },
      push_id: function () {
        return this.$store.state.push_id
      },
      type: function () {
        return this.$store.state.type
      },
      flexAttributes () {
        return {
          xs6: this.settings.main.grid.xs6,
          xs12: this.settings.main.grid.xs12,
        }
      },
    },
    data () {
      return {
        completed: false,
        sound: null,
        run: false,
        setupMode: false,
        notification: {
          id: '',
          title: '',
          counter: '',
          image: '',
          animate: {
            id: '',
            duration: 1000,
            animate: {
              id: '',
              animate: ''
            }
          },
          message: ''
        },
        stopBtnDisable: false,
      }
    },
    watch: {
      setupMode: function (val) {
        if (val) {
          this.notification.title = 'Vasya Pupkin'
          this.notification.counter = '456 руб.'
          this.notification.animate.animate.animate = ''
          this.notification.message = 'Тащи бро! Тащи!!!'
        }
      },
      run: function (val) {
        if (val === true) {
          setTimeout(() => {
            this.run = false
            if (this.sound) {
              this.sound.stop()
            }

            if (this.notification.counter >= this.settings.main.minVoice) {
              setTimeout(() => {
                var sound = new Howl({
                  src: `/storage/google/${this.notification.id}.mp3`,
                  autoplay: true,
                  loop: false,
                  volume: 0.7,
                  onend: function() {
                    console.log('Finished!');
                  }
                });
              }, 2000);
            }
            this.notification = {}
          }, this.settings.main.duration);
        }
      }
    },
    methods: {
      playsound () {
        if (this.settings.main.sound.src) {
          this.sound = new Howl({
            src: this.settings.main.sound.src,
            autoplay: false,
            loop: false,
            volume: `0.${this.settings.main.sound.volume}`,
          });
          if (this.setupMode) {
            this.sound.play()
          }
        }
      },
      setUser () {
        let user = document.head.querySelector('meta[name="user"]');
        this.$store.dispatch('setUser', JSON.parse(user.content))
      },
      setToken () {
        let token = document.head.querySelector('meta[name="token"]');
        this.$store.dispatch('setToken', token.content)
      },
      setPushId () {
        let push_id = document.head.querySelector('meta[name="push_id"]');
        this.$store.dispatch('setPushId', push_id.content)
      },
      setType () {
        let type = document.head.querySelector('meta[name="type"]')
        this.$store.dispatch('setType', type.content)
      },
      fetchSettings () {
        if (!this.push_id) {
          this.completed = true
          return
        }
        axios.get(`/push/settings/${this.user.id}/${this.push_id}/${this.token}`).then(response => {
          this.$store.dispatch('settingsDonatePage', response.data)
          this.playsound()
          this.completed = true
        })
      },
      serverConnect () {
        var es = new EventSource(`/api/push/server/${this.user.id}/${this.type}/${this.token}`);

        var open = function (event) 
        {
            // console.log('Открытие');
        }; 
        var listener = (event) =>
        {
          if (this.run) {
            return
          }
          // console.log('OK');
          var response = JSON.parse(event.data)
          var notification = response.notification
          var settings = response.settings
          if (typeof settings !== 'undefined') {
            this.$store.dispatch('settingsDonatePage', settings)
            this.playsound()
          }
          if (typeof notification !== 'undefined') {
            this.notification = notification
            this.run = true
            if (this.sound) {
              this.sound.play()
            }
          }
        };  
            
          
        
        var error = function (event) 
        {
            console.log('Ошибка');
        }; 

        es.addEventListener("open", open);
        es.addEventListener("message", listener);
        es.addEventListener("error", error);

      }
    },
    mounted () {
      if (!this.setupMode) {
        this.serverConnect()
      }
    },
    created () {
      // new Howl({
      //   src: this.settings.main.sound.src,
      //   autoplay: true,
      //   loop: false,
      //   volume: 0.9,
      // });

      this.setupMode = this.$route.query.settings
      this.setPushId()
      this.setType()
      this.setToken()
      this.setUser()
      this.fetchSettings()
    }
  }
</script>

<style>
  ::-webkit-scrollbar
{
  width: 0;  /* for vertical scrollbars */
  height: 0; /* for horizontal scrollbars */
}
.VideoBg__content {
  /* top: 25%!important; */
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
