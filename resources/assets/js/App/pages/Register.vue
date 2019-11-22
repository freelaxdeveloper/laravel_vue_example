<template>
  <v-layout id="inspire">
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="primary">
                <v-toolbar-title>Регистрация</v-toolbar-title>
                <v-spacer></v-spacer>
              </v-toolbar>
              <v-card-text>

                <v-form>

                  <v-text-field
                    prepend-icon="person" 
                    v-model="form.name" 
                    label="Ваше имя" 
                    type="text"
                  ></v-text-field>

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

                  <v-text-field 
                    prepend-icon="lock" 
                    v-model="form.password_confirmation"
                    label="Повторите пароль" 
                    type="password"
                  ></v-text-field>
                </v-form>

              </v-card-text>
              <v-card-actions>
                <login-twitch></login-twitch>
                <v-spacer></v-spacer>
                <v-btn color="primary" :disabled="!disabled" :loading="loading" @click="submit">Зарегистрироваться</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-layout>
</template>

<script>
  import axios from 'axios'

  import LoginTwitch from '../components/LoginTwitch'

  export default {
    components: {
      LoginTwitch
    },
    data() {
      return {
        form: {
          name: '',
          email: '',
          password: '',
          password_confirmation: '',
        },
        loading: false,
      }
    },
    computed: {
      disabled: function () {
        return this.form.name.length > 2 && this.form.email.length > 2 && this.form.password.length > 5 && this.form.password === this.form.password_confirmation
      }
    },
    methods: {
      submit() {
        this.loading = true
        axios.post('/register', this.form).then(response => {
          this.loading = false
          console.log('register', response.data.user.api_token)
          this.$store.dispatch('setToken', response.data.user.api_token)
          this.$router.push({name: 'MyProfile'})
        }).catch(error => {
          this.loading = false
        })
        
      }
    },
    created() {
      // axios.get('/user').then(response => {
      //   console.log('response', response.data)
      // }).catch(error => {
      //   console.log('response', error.response.data)
      // })
    }
  }
</script>