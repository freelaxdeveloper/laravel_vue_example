<template>
  <v-text-field
    readonly
    :label="label"
    v-model="link"
    outline
    append-icon="mdi-content-copy"
    @click:append="doCopy(link)"
  >
  </v-text-field>
</template>

<script>
// ссылка для вставки в стрим
export default {
  props: {
    link: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: true
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
  }
}
</script>