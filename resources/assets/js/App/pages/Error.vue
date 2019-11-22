<template>
  <v-container>
    <v-alert
      :value="true"
      type="error"
      outline
    >
      {{message}}
      <v-btn
        small
        @click="$router.push({name: 'Login'})"
        flat
      >
        Повторить попытку
      </v-btn>
    </v-alert>
    <!-- <v-alert
      :value="true"
      type="error"
    >
      При авторизации возникла ошибка, повторите попытку позже.
      <v-btn
        small
        @click="$router.push({name: 'Login'})"
        flat
      >
        Авторизоваться
      </v-btn>
    </v-alert> -->
  </v-container>
</template>

<script>
export default {
  data () {
    return {
      error: this.$route.params.message
    }
  },
  computed: {
    message: function () {
      return decodeURI(this.error)
    }
  }
}
</script>