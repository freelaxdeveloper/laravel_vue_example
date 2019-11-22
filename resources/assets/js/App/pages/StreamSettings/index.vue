<template>
  <v-container fluid>
    <v-layout>
      <v-flex xs4>
        <v-navigation-drawer
          stateless
          value="true"
        >
          <v-toolbar
            card
            color="purple"
          >
            <v-icon>mdi-view-list</v-icon>
            <v-toolbar-title class="font-weight-light">Разделы</v-toolbar-title>
          </v-toolbar>

          <v-list>
            <v-list-tile @click="editDonatePage">
              <v-list-tile-action>
                <v-icon>mdi-currency-rub</v-icon>
              </v-list-tile-action>
              <v-list-tile-title>Форма доната</v-list-tile-title>
            </v-list-tile>
            <!-- <v-list-tile @click="section = {name: 'statistic'}">
              <v-list-tile-action>
                <v-icon>mdi-chart-bar</v-icon>
              </v-list-tile-action>
              <v-list-tile-title>Статистика</v-list-tile-title>
            </v-list-tile> -->
            <v-list-group
              prepend-icon="mdi-settings"
              :value="false"
            >
              <v-list-tile slot="activator">
                <v-list-tile-title>Уведомления</v-list-tile-title>
              </v-list-tile>

              <v-list dark>
                <template v-for="(item, index) in items">
                  <v-list-tile 
                    v-if="item.type" 
                    :key="item.title" 
                    @click="section = {name: 'notification_settings', param: item.type}"
                  >
                    <v-list-tile-action>
                      <v-icon>mdi-settings-outline</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content class="white--text">
                      <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                    </v-list-tile-content>
                  </v-list-tile>
                  <v-divider v-else-if="item.divider" :key="index"></v-divider>
                  <v-subheader v-else-if="item.header" :key="item.header" class="grey--text text--lighten-4">{{ item.header }}</v-subheader>
                </template>
              </v-list>

              <!-- <v-list-tile 
                @click=""
              >
                <v-list-tile-title>Донат</v-list-tile-title>
              </v-list-tile>

              <v-list-tile 
                @click=""
              >
                <v-list-tile-title>Премиум подписка</v-list-tile-title>
              </v-list-tile> -->
              
            </v-list-group>

            <milestones @section-update="section = $event"></milestones>
            <widgets 
              :widgets="widgets"
              @section-update="section = $event"
            ></widgets>
          </v-list>
        </v-navigation-drawer>
      </v-flex>

      <v-flex xs8>
        <section-notification-settings 
          v-if="section.name === 'notification_settings'"
          :type="section.param"
        ></section-notification-settings>
        <section-milestone 
          v-if="section.name === 'milestone'" 
          :milestone="section.param"
          @close="section = {name: '', param: {}}"
        ></section-milestone>
        <section-statistic 
          v-if="section.name === 'statistic'" 
          @close="section = {name: '', param: {}}"
          @create-widget="widgets.push($event)"
          @update-widget-list="widgets = $event"
          :param="section.param"
        ></section-statistic>
        <section-widget 
          v-if="section.name === 'widget'"
          :widget="section.param"
          @close="section = {name: '', param: {}}"
          @widget-settings="section = {name: 'statistic', param: $event}"
        ></section-widget>
      </v-flex>

    </v-layout>
  </v-container>
</template>


<script>
  import axios from 'axios'

  import Milestones from './components/Milestones/index'
  import Widgets from './components/Widgets/index'
  import SectionNotificationSettings from './components/Sections/NotificationSettings'
  import SectionMilestone from './components/Sections/Milestone'
  import SectionStatistic from './components/Sections/Statistic'
  import SectionWidget from './components/Sections/Widget'

  export default {
    components: {
      Milestones, Widgets, SectionNotificationSettings, SectionMilestone, SectionStatistic, SectionWidget
    },
    computed: {
      user: function () {
        return this.$store.state.user
      }
    },
    data: () => ({
        widgets: [],
        items: [
        {
          type: 'donate',
          title: 'Донат'
        },
        { divider: true },
        { header: 'Подписки' },
        {
          type: 'premium',
          title: 'Премиум'
        },
        {
          type: 'paid',
          title: 'Платная'
        },
        // {
        //   type: 'free',
        //   title: 'Бесплатная'
        // }
      ],
      section: {
        name: '',
        param: {},
      },
    }),
    methods: {
      editDonatePage () {
        this.$router.push({name: 'Payment', params: {id: this.user.id}})
        this.$store.dispatch('rightDrawerToggle', true)
        this.$store.dispatch('rightDrawerChange', 'donate')
      },
      fetchWidgets () {
        axios.get('/widget/list').then(response => {
          this.widgets = response.data
        })
      }
    },
    created () {
      this.fetchWidgets()
    }
  }
</script>