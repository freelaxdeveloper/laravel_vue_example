<template>
  <v-container fluid>
    <v-layout>
      <v-flex xs12>
        <div class="resultContainer">
          <v-layout align-space-around justify-center>
            <v-hover>
              <div slot-scope="{ hover }" :class="`elevation-${hover ? 12 : 2}`" class="item elevation-5 pointer">
                <p class="pa-2">
                  <a 
                    @click="paykeeper" 
                    :href="payment.payment_link" 
                    target="_blank"
                  >
                    <v-img src="/paykeeper.png"></v-img>
                  </a>
                </p>
              </div>
            </v-hover>
              <div class="item elevation-5 item-disabled">
                <v-img src="/visa_clasic.png"></v-img>
              </div>
          </v-layout>
        </div>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import axios from 'axios'

export default {
  data () {
    return {
      order_id: this.$route.params.orderId,
      user_id: this.$route.params.userId,
      payment: [],
      subscribe: false,
    }
  },
  computed: {
   jwt_token() {
      return this.$store.state.jwt_token
    },
  },
  methods: {
    paykeeper () {
      if (this.jwt_token && !this.subscribe && this.payment.service_name !== 'subscription') {
        this.$router.push({name: 'UserSubscribe', params: {id: this.user_id}})
      } else {
        this.$router.push({name: 'Profile', params: {id: this.user_id}})
      }
    },
    fetchPayment () {
      axios.get(`/paykeeper/${this.order_id}`).then(response => {
        this.payment = response.data
      }).catch(error => {

      })
    },
    checkSubscribe () {
      axios.get(`/premium/${this.user_id}/checksubscribe/`).then(response => {
        this.subscribe = response.data
      })
    },
  },
  created () {
    this.fetchPayment()
    this.checkSubscribe()
  }
}
</script>

<style scoped>
  .item-disabled {
    cursor:not-allowed;
    opacity: 0.5;
  }
  .resultContainer {
    height: 350px;
  }

  .item {
    min-height: 100px;
    min-width: 200px;
    margin: 10px;
  }
</style>