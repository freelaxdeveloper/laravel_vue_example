<template>
  <v-container>
    <v-flex xs12>

      <my-upload :preview="true" btn-name="Загрузить"></my-upload>

    </v-flex>
  </v-container>
</template>

<style scoped>

</style>


<script>
import myUpload from '../components/upload/Image.vue'

export default {
  components: {
    myUpload
  },
  data () {
    return {

    }
  },
  methods: {

  },
  created() {

  }
}
</script>
