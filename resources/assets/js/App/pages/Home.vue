<template>
  <v-content class="padding-clear">
    <section>
      <v-parallax src="/img/bg.jpg" height="600">
        <v-layout
          column
          align-center
          justify-center
          class="white--text"
        >
          <!-- <img src="/img/logo.png" height="100"> -->
          <h1 class="white--text mb-2 display-1 text-xs-center">DonateSupp</h1>
          <div class="subheading mb-3 text-xs-center">Начни получать донат прямо сейчас!</div>
          <v-btn
            v-if="!$store.state.api_token"
            color="primary"
            dark
            large
            @click="$router.push({name: 'Login'})"
          >
            Начать использовать
          </v-btn>
          <v-btn
            v-else
            color="primary"
            dark
            large
            @click="$router.push({name: 'MyProfile'})"
          >
            Мой профиль
          </v-btn>
        </v-layout>
      </v-parallax>
    </section>

    <section>
      <v-layout
        column
        wrap
        class="my-5"
        align-center
      >
        <v-flex xs12 sm4 class="my-3">
          <div class="text-xs-center">
            <h2 class="headline">Уникальный сервис.</h2>

            <span class="subheading">
              Оцени новый подход к сервису!
            </span>
          </div>
        </v-flex>
        <v-flex xs12>
          <v-container grid-list-xl>
            <v-layout wrap row align-space-around justify-space-around>
              <v-flex xs12 md4>
                <v-hover>
                  <v-card :class="`elevation-${hover ? 20 : 2}`" class="transparent resultContainer" slot-scope="{ hover }">
                    <v-parallax
                      height="450"
                      src="https://images.wallpaperscraft.ru/image/call_of_duty_black_ops_3_activision_publishing_103670_540x960.jpg"
                    >
                      <!-- <v-card-text class="text-xs-center">
                        <img src="/img/info2.png">
                      </v-card-text> -->
                      <v-card-title primary-title class="layout justify-center">
                        <div class="headline text-xs-center">Гибкая настройка положения элементов уведомлений.</div>
                      </v-card-title>
                      <v-card-text>
                        Забудь о рамках в настройке уведомлений. Настраивай положение элементов уведомления как угодно! Удобный интерфейс поможет тебе создать уникальную форму уведомлений. 
                      </v-card-text>
                    </v-parallax>
                  </v-card>
                </v-hover>
              </v-flex>
              <v-flex xs12 md4>
                <v-hover>
                  <v-card :class="`elevation-${hover ? 20 : 2}`" slot-scope="{ hover }" class="transparent resultContainer">
                    <v-parallax
                      height="450"
                      src="https://images.wallpaperscraft.ru/image/killzone_shlem_svet_glaza_soldat_21150_540x960.jpg"
                    >
                      <!-- <v-card-text class="text-xs-center">
                        <img src="/img/info2.png">
                      </v-card-text> -->
                      <v-card-title primary-title class="layout justify-center">
                        <div class="headline">Кастомизируй свои сообщения для стримера!</div>
                      </v-card-title>
                      <v-card-text>
                        Хочешь чтобы твое сообщения для стримера было уникальным? Нет проблем! Настраивай сообщение, которое ты выводишь на стрим любимого стримера! Будь уникальным.
                      </v-card-text>
                    </v-parallax>
                  </v-card>
                </v-hover>
              </v-flex>
              <v-flex xs12 md4>
                
                <v-hover>
                  <v-card :class="`elevation-${hover ? 20 : 2}`" slot-scope="{ hover }" class="transparent resultContainer">
                    <v-parallax
                      height="450"
                      src="https://images.wallpaperscraft.ru/image/alien_isolation_pc_playstation_3_playstation_4_xbox_360_xbox_one_creative_assembly_sega_total_war_ellen_ripli_93431_540x960.jpg"
                    >
                      <!-- <v-card-text class="text-xs-center">
                        <img src="/img/info2.png">
                      </v-card-text> -->
                      <v-card-title primary-title class="layout justify-center">
                        <div class="headline text-xs-center">Автоматические публикации в соцсетях.</div>
                      </v-card-title>
                      <v-card-text>
                        Не трать время на создание публикаций о начале стрима! Вступай в сообщество SCL и о начале стрима узнают все подписчики SCL.
                      </v-card-text>
                    </v-parallax>
                  </v-card>
                </v-hover>
              </v-flex>
            </v-layout>
          </v-container>
        </v-flex>
      </v-layout>
    </section>

    <section>
      <v-parallax src="/img/bg2.jpg">
        <v-layout column align-center justify-center>
          <div class="headline white--text mb-3 text-xs-center">Надоели разрозненные сервисы?</div>
          <em>Попробуй комплексное решение!</em>
          <v-btn
            v-if="!$store.state.api_token"
            color="primary"
            dark
            large
            @click="$router.push({name: 'Login'})"
          >
            Начать использовать
          </v-btn>
          <v-btn
            v-else
            color="primary"
            dark
            large
            @click="$router.push({name: 'MyProfile'})"
          >
            Мой профиль
          </v-btn>
        </v-layout>
      </v-parallax>
    </section>

    <section>
      <v-container grid-list-xl>
        <v-layout row wrap justify-center class="my-5">
          <!-- <v-flex xs12 sm4>
            <v-card class="elevation-0 transparent">
              <v-card-title primary-title class="layout justify-center">
                <div class="headline">Mattis rhoncus urna</div>
              </v-card-title>
              <v-card-text>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Tortor id aliquet lectus proin. Felis donec et odio pellentesque diam volutpat. Tellus orci ac auctor augue.
              </v-card-text>
            </v-card>
          </v-flex> -->
          <v-flex xs12 offset-sm1>
            <v-card class="elevation-0 transparent">
              <v-card-title primary-title class="layout justify-center">
                <div class="headline">Контакты</div>
              </v-card-title>
              <v-card-text>
                Вы можете связаться с нами по следующим контактным данным:
              </v-card-text>
              <v-list class="transparent">
                <!-- <v-list-tile>
                  <v-list-tile-action>
                    <v-icon class="blue--text text--lighten-2">phone</v-icon>
                  </v-list-tile-action>
                  <v-list-tile-content>
                    <v-list-tile-title>+7441 143 4785</v-list-tile-title>
                  </v-list-tile-content>
                </v-list-tile> -->
                <v-list-tile>
                  <v-list-tile-action>
                    <v-icon class="blue--text text--lighten-2">place</v-icon>
                  </v-list-tile-action>
                  <!-- <v-list-tile-content> -->
                    Адрес: 129090, г. Москва, проспект Мира, д. 19, стр. 1, этаж 1, помещение I, комната 6, офис 16.
                  <!-- </v-list-tile-content> -->
                </v-list-tile>
                <v-list-tile>
                  <v-list-tile-action>
                    <v-icon class="blue--text text--lighten-2">mdi-email</v-icon>
                  </v-list-tile-action>
                  <!-- <v-list-tile-content> -->
                    support@donatesupp.com
                  <!-- </v-list-tile-content> -->
                </v-list-tile>
              </v-list>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </section>

  </v-content>
</template>

<script>
export default {
  data () {
    return {
    }
  }
}
</script>

<style scoped>
.margin-top {
  margin-top: 55px;
}
.height-fill {
  height: 100vh!important;
}
.resultContainer {
  min-height: 450px;
}

h1, h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
.padding-clear {
  padding: 0 !important;
}
</style>
