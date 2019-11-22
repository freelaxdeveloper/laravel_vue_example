<template>
  <v-container>
    <v-flex xs12>
      <v-btn small color="primary" @click="toggleShow" v-if="btnName" v-text="btnName"></v-btn>
      <v-avatar
        @click="toggleShow"
        v-if="src"
        :tile="false"
        :size="36"
        class="pointer"
        color="grey lighten-4"
      >
        <img :src="src" alt="">
      </v-avatar>
      <my-upload field="img"
        @crop-success="cropSuccess"
        @crop-upload-success="cropUploadSuccess"
        @crop-upload-fail="cropUploadFail"
        v-model="show"
        :width="1600"
        :height="900"
        url="/api/image/upload"
        :params="params"
        :headers="headers"
        langType="ru"
        :noRotate="true"
        img-format="jpg"></my-upload>
      <img v-if="preview" :src="imgDataUrl">
    </v-flex>
  </v-container>
</template>

<style>
.v-list__tile__action--stack {
  white-space: unset!important;
}
</style>


<script>
// import axios from 'axios'
import myUpload from 'vue-image-crop-upload'

export default {
  components: {
    myUpload
  },
  props: {
    src: {
      type: String,
      default: ''
    },
    fileName: {
      type: String,
      default: 'form_bg'
    },
    preview: {
      type: Boolean,
      default: false
    },
    btnName: {
      type: String,
      default: ''
    },
    showModel: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
			show: this.showModel,
			params: {
				name: this.fileName
			},
			headers: {
				Authorization: 'Bearer ' + this.$store.state.api_token
			},
			imgDataUrl: '' // the datebase64 url of created image
    }
  },
  watch: {
    show: function (val) {
      if (val === false) {
        this.$emit('show', false)
      }
    }
  },
  methods: {
    toggleShow() {
      this.show = !this.show;
    },
    /**
     * crop success
     *
     * [param] imgDataUrl
     * [param] field
     */
    cropSuccess(imgDataUrl, field){
      // console.log('-------- crop success --------');
      this.imgDataUrl = imgDataUrl;
      this.$emit('success', imgDataUrl)
      // this.$emit('show', false)
    },
    /**
     * upload success
     *
     * [param] jsonData  server api return data, already json encode
     * [param] field
     */
    cropUploadSuccess(jsonData, field){
      // console.log('-------- upload success --------');
      // console.log(jsonData);
      // console.log('field: ' + field);
    },
    /**
     * upload fail
     *
     * [param] status    server api return error status, like 500
     * [param] field
     */
    cropUploadFail(status, field){
      // console.log('-------- upload fail --------');
      // console.log(status);
      console.log('field: ' + field);
    }
  },
  created() {

  }
}
</script>
