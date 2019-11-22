<template>
  <v-layout>
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>

            
            <!-- <v-card class="elevation-12">
              <v-toolbar dark color="primary">
                <v-toolbar-title>Авторизация</v-toolbar-title>
                <v-spacer></v-spacer>
              </v-toolbar>
              <v-card-text>

                <v-form>

                  <v-text-field
                    prepend-icon="mail" 
                    v-model="form.email" 
                    label="E-mail" 
                    type="email"
                  ></v-text-field>

                  <v-text-field 
                    prepend-icon="lock" 
                    v-model="form.password"
                    label="Пароль" 
                    type="password"
                  ></v-text-field>

                </v-form>

              </v-card-text>
              <v-card-actions>
                <login-twitch></login-twitch>
                <v-spacer></v-spacer>
                <v-btn color="primary" :disabled="!disabled" :loading="loading" @click="submit">Войти</v-btn>
              </v-card-actions>
            </v-card> -->
            <!-- {{getRouter().href}} -->
            <v-switch
              :label="`Войти как ${label}`"
              v-model="is_streamer"
            ></v-switch>

            <login-oauth 
              :redirect="redirect" 
              :is_streamer="is_streamer"
              icon="mdi-twitch"
              title="TWITCH"
              service="twitch"
            />

            <login-oauth 
              :redirect="redirect" 
              :is_streamer="is_streamer"
              icon="mdi-youtube"
              title="YouTube"
              service="google"
            />

            <login-oauth 
              :redirect="redirect" 
              :is_streamer="is_streamer"
              icon="mdi-vk"
              title="VK"
              service="vkontakte"
            />
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-layout>
</template>

<script>
  import axios from 'axios'
  import LoginOauth from '../components/LoginOauth'

  export default {
    components: {
      LoginOauth
    },
    data() {
      return {
        // form: {
        //   email: '',
        //   password: '',
        // },
        is_streamer: true,
        loading: false,
        redirect: this.$route.params.redirect
      }
    },
    computed: {
      label () {
        return this.is_streamer ? 'стример' : 'пользователь'
      }
      // disabled: function () {
      //   return this.form.email.length > 2 && this.form.password.length > 5
      // }
    },
    methods: {
      // getRouter () {
      //   let props = this.$router.resolve({ 
      //     name: 'Payment',
      //     params: { id: 9 },
      //   });

      //   return props;
      // }
    //  submit() {
    //     this.loading = true
    //     axios.post('/login', this.form).then(response => {
    //       this.loading = false
    //       let api_token = response.data.api_token
    //       this.$store.dispatch('setToken', api_token)
    //       this.$router.push({name: 'MyProfile'})
    //     }).catch(error => {
    //       this.loading = false
    //     })
        
    //   }
    },
  }
</script>