<template>
<v-flex xs12>
    <v-layout align-space-around justify-space-around row fill-height wrap>
      
      <v-flex xs12>
        <v-card>
          <v-toolbar color="purple" dark>
            <v-toolbar-title v-text="title"></v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn dark icon @click="dialog = true">
              <v-icon>mdi-plus</v-icon>
            </v-btn>
          </v-toolbar>
          <v-list>
            <template v-for="notifi in notifications[typeCurrent]">
              <v-list-tile
                :key="`notifi_${notifi.id}`" 
              >
                <v-list-tile-content>
                  <v-list-tile-title>От {{ notifi.activate }}</v-list-tile-title>
                </v-list-tile-content>
                <v-list-tile-action>
                  <v-layout>
                    <v-flex>
                      <v-btn icon @click="goLink(notifi.id)">
                        <v-icon>mdi-settings</v-icon>
                      </v-btn>
                    </v-flex>
                    <v-flex>
                      <v-btn icon @click="deleteNotification(notifi)">
                        <v-icon>mdi-delete</v-icon>
                      </v-btn>
                    </v-flex>
                  </v-layout>
                </v-list-tile-action>
              </v-list-tile>
            </template>

          </v-list>
        </v-card>
        <link-for-obs :label="title" :link="currentLink.link"></link-for-obs>
      </v-flex>
    </v-layout>

    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">Новое уведомление</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12>
                <v-text-field v-model="value" :label="label" mask="######"></v-text-field>
              </v-flex>
           </v-layout>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click="close">Отмена</v-btn>
          <v-btn color="blue darken-1" flat @click="save">Добавить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>


    </v-flex>
</template>

<script>
  import axios from 'axios'
  import LinkForObs from '../../../../components/LinkForObs'

  export default {
    components: {
      LinkForObs
    },
    props: {
      type: {
        type: String,
        required: true
      }
    },
    data () {
      return {
        dialog: false,
        notifications: [],
        links: [],
        value: ''
      }
    },
    computed: {
      user: function () {
        return this.$store.state.user
      },
      typeCurrent: function () {
        return this.type
      },
      currentLink: function () {
        return this.links.find(x => x.type === this.typeCurrent);
      },
      title: function () {
        switch (this.typeCurrent) {
          case 'donate':
            return 'Донат'
            break;
          case 'free':
            return 'Бесплатная'
            break;
          case 'paid':
            return 'Платная'
            break;
          case 'premium':
            return 'Премиум'
            break;
        }
      },
      label: function () {
        switch (this.typeCurrent) {
          case 'donate':
            return 'Сумма доната от'
            break;
          default:
            return 'Продолжительность (в месяцах) от'
        }
      }
    },
    methods: {
      goLink (push_id) {
        window.location = `/api/push/client/${this.user.id}/${push_id}/${this.user.stream_hash_link}/#/?settings=1`
      },
      close () {
        this.value = ''
        this.dialog = false
      },
      save () {
        let option = {
          value: this.value,
          type: this.typeCurrent
        }
        axios.post('/mynotification', option).then(response => {
          let data = response.data
          this.notifications = data
          this.close()
        }).catch(error => {
          this.$store.dispatch('errors', error.response.data.errors)
        })
      },
      deleteNotification (notifi) {
        axios.put(`/mynotification/${notifi.id}`).then(response => {
          this.notifications = response.data
        })
      },
      fetchNotification () {
        return axios.get('/mynotification')
      },
      fetchLinks () {
        return axios.get('/fetchlinks')
      },
      fetchAll () {
        axios.all([this.fetchLinks(), this.fetchNotification()])
          .then(axios.spread((links, notifications) => {
            this.notifications = notifications.data
            this.links = links.data
          }));
      }
    },
    created () {
      this.fetchAll()
    }
  }
</script>