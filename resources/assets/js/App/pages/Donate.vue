<template>
  
  <div>
    <video-bg 
      v-if="pageSettingstest.main.bg === 'video'" 
      :sources="[pageSettingstest.main.bgVideo]"
    >
      <DonateForm/>
    </video-bg>
    <v-img :src="pageSettingstest.main.bgImage" v-if="pageSettingstest.main.bg === 'image'">
      <DonateForm/>
    </v-img>
    <div v-else>
      <DonateForm/>
    </div>
  </div>
</template>

<style lang="scss">
.application {
  line-height: 2;
}
</style>


<script>
  import VideoBg from 'vue-videobg'

  import DonateForm from '../components/DonateForm'

  export default {
    components: {
      DonateForm, VideoBg
    },
    computed: {
      pageSettingstest: function () {
        return this.$store.state.settings.donate
      },
    }
  }
</script>
