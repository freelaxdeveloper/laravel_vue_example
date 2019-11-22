<template>
  <v-container>
    <v-flex xs12>
      <file-pond
        :allowMultiple="false"
        ref="pond"
        label-idle="Перетащите файлы..."
        v-on:init="handleFilePondInit"
        :server="server"/>

    </v-flex>
  </v-container>
</template>

<script>
// Import Vue FilePond
import vueFilePond from 'vue-filepond';

// Import FilePond styles
import 'filepond/dist/filepond.min.css';

// Import FilePond plugins
// Please note that you need to install these plugins separately

// Import image preview plugin styles
// import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';

// Import image preview and file type validation plugins
// import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
// import FilePondPluginImagePreview from 'filepond-plugin-image-preview';

// Create component
const FilePond = vueFilePond();

export default {
  components: {
    FilePond
  },
  props: {
    url: {
      type: String,
      required: true
    }
  },
  /**
   * Authorization: Bearer TbaraVOly3nr3Em3M4joy5z2PsLB5a4RGic9pnbvyjUsY1A7NH3nU0D4rCORrPGDE4Xq0dBbbpackHwRi5WKaMvifDetGDcitwOhr8vLrilpIwGgOdeLmwK8NJjQJWRs
   */
  computed: {
    api_token() {
      return this.$store.state.jwt_token
    },
  },
  data () {
    return {
      server: {
        url: this.url,
        process: {
          method: 'POST',
          withCredentials: false,
          headers: {
            Authorization: ''
          },
          timeout: 7000,
          onload: (response) => {
            response = JSON.parse(response)
            this.$emit('success', response.src)
            this.$emit('show', false)
          },
          onerror: error => {
            this.$store.dispatch('errors', JSON.parse(error))
          }
        }
      }
    }
  },
  created () {
    this.server.process.headers = {
      Authorization: `Bearer ${this.api_token}`
    }
  },
  methods: {
    handleFilePondInit: function() {
      console.log('FilePond has initialized');

      // example of instance method call on pond reference
      this.$refs.pond.getFiles();
    }
  },
}
</script>
