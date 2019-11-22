<template>
  <v-card-actions>
    <!-- кнопка отмены -->
    <v-btn
      :light="settings.btnCanel.light"
      :flat="settings.btnCanel.flat"
      @click="backClick"
      :class="settings.btnCanel.fontFamily"
      :color="settings.btnCanel.bgColor"
      :style="btnCanelStyle"
    >
      <v-icon 
        left 
        dark 
        v-text="settings.btnCanel.icon" 
        v-if="settings.btnCanel.icon"
      ></v-icon> {{ settings.btnCanel.text }}
    </v-btn>

    <v-spacer></v-spacer>
    <v-chip color="primary">
      <v-avatar>
        <img :src="user.avatar" alt="trevor">
      </v-avatar>
      <span class="white--text">{{ user.name }}</span>
    </v-chip>
    <v-spacer></v-spacer>
    <v-btn
      :flat="settings.btnNext.flat"
      :light="settings.btnNext.light"
      :disabled="!valid"
      @click="nextClick"
      :color="settings.btnNext.bgColor"
      :class="settings.btnNext.fontFamily"
      :style="`font-size:${settings.btnNext.size}px;`"
    >
      {{ settings.btnNext.text }} 
      <v-icon 
        right 
        dark 
        v-text="settings.btnNext.icon" 
        v-if="settings.btnNext.icon"
      ></v-icon>
    </v-btn>
  </v-card-actions>
</template>

<script>
export default {
  props: {
    btnCanelStyle: {
      type: String,
      required: true
    },
    valid: {
      type: Boolean,
      required: true
    },
    settings: {
      type: Object,
      required: true
    },
    user: {
      type: Object,
      required: true
    },
    backClick: {
      required: true
    },
    nextClick: {
      required: true
    }
  },
  computed: {

  },
  data () {
    return {

    }
  }
}
</script>
