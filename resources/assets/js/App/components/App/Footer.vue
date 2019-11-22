<template>
  <v-footer
    height="auto"
    grid-list-xl
  >
    <v-layout
      justify-center
      row
      wrap
    >
      <v-flex xs6 sm3 md2
        v-for="(link, i) in links"
        :key="`links_${i}_${link.name}`"
      >
        <v-btn
          color="white"
          @click="$router.push({name: link.name, params: {title: link.title}})"
          flat
          round
        >
          {{ link.title }}
        </v-btn>
      </v-flex>
      <v-flex xs12 class="text-xs-center">
        <img src="/img/logo3h.png"/>
      </v-flex>
      <v-flex
        primary
        py-3
        text-xs-center
        white--text
        xs12
        class="footer"
      >
        &copy;2018 — <strong v-text="title"></strong>
      </v-flex>
    </v-layout>
  </v-footer>

</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      links: [
        {title: 'Главная', name: 'Home'},
        // {title: 'О нас', name: 'Dev'},
        {title: 'Помощь', name: 'Help'},
        {title: 'Правила', name: 'Privacy'},
        // {title: 'Разработчикам', name: 'Dev'},
      ]
    }
  }
}
</script>

<style scoped>
  .footer {
    background-color: #131212!important;
  }
</style>
