<template>
  <v-container grid-list-md align-center justify-center>
    <v-layout fluid fill-height row wrap>

      <div class="chart-container">
        <chart height="100%" width="100%"/>
      </div>

      <v-flex xs6>
        <v-menu
          ref="menu2"
          :close-on-content-click="false"
          v-model="menu2"
          :nudge-right="40"
          :return-value.sync="dateFrom"
          lazy
          transition="scale-transition"
          offset-y
          full-width
          min-width="290px"
        >
          <v-text-field
            slot="activator"
            v-model="dateFrom"
            label="От"
            prepend-icon="event"
            readonly
          ></v-text-field>
          <v-date-picker v-model="dateFrom" @input="$refs.menu2.save(dateFrom)"></v-date-picker>

        </v-menu>
      </v-flex>
      <v-flex xs6>
        <v-menu
          ref="menu3"
          :close-on-content-click="false"
          v-model="menu3"
          :nudge-right="40"
          :return-value.sync="dateTo"
          lazy
          transition="scale-transition"
          offset-y
          full-width
          min-width="290px"
        >
          <v-text-field
            slot="activator"
            v-model="dateTo"
            label="До"
            prepend-icon="event"
            readonly
          ></v-text-field>
          <v-date-picker v-model="dateTo" @input="$refs.menu3.save(dateTo)"></v-date-picker>

        </v-menu>
      </v-flex>
      <v-flex xs12>      
        <v-data-table
          :headers="headers"
          :items="transactions"
          :pagination.sync="pagination"
          :total-items="transactionsTotal"
          :loading="loading"
          :must-sort="true"
          class="elevation-1"
        >
          <template slot="items" slot-scope="props">
            <td>{{ props.item.id }}</td>
            <td>{{ props.item.name }} <v-icon small color="red" v-if="props.item.info.donate.is_paid">mdi-heart</v-icon></td>
            <td class="text-xs-right">
              {{ props.item.info.donate.donate }} руб. 
              <span 
                class="caption grey--text text--darken-1"
                v-text="props.item.info.donate.is_paid ? '-0 руб.' : `-${props.item.info.donate.commission} руб.`"
              ></span>
            </td>
            <td class="text-xs-right">{{ props.item.platform }}</td>
            <td class="text-xs-right">{{ props.item.message }}</td>
            <td class="text-xs-right">{{ props.item.created_at_humans }}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import axios from 'axios'
import Chart from '../components/Charts/lineMarker'

export default {
  components: {
    Chart
  },
    data () {
      return {
        dateFrom: null,
        dateTo: null,
        menu2: null,
        menu3: null,
        test: '',
        totalDesserts: 0,
        desserts: [],
        loading: true,
        pagination: {
          sortBy: 'id',
          descending: true,
          rowsPerPage: 10,
        },
        headers: [
          { text: '№', sortable: true, value: 'id' },
          { text: 'Имя пользователя', align: 'left', sortable: false, value: 'name' },
          { text: 'Донат', value: 'amount' },
          { text: 'Платформа', value: 'platform' },
          { text: 'Сообщение', value: 'message', sortable: false },
          { text: 'Дата', value: 'created_at', sortable: true },
        ],
        transactions: [],
        transactionsTotal: 0,
      }
    },
    watch: {
      dateFrom: function (val) {
        this.fetchTransactions()
          .then(data => {
            this.transactions = data.items
            this.transactionsTotal = data.total
          })
      },
      dateTo: function (val) {
        this.fetchTransactions()
          .then(data => {
            this.transactions = data.items
            this.transactionsTotal = data.total
          })
      },
      pagination: {
        handler () {
          this.fetchTransactions()
            .then(data => {
              this.transactions = data.items
              this.transactionsTotal = data.total
            })
        },
        deep: true
      }
    },
    mounted () {
      this.fetchTransactions()
        .then(data => {
          this.transactions = data.items
          this.transactionsTotal = data.total
        })
    },
    methods: {
      async fetchTransactions() {
        this.loading = true
        return new Promise((resolve, reject) => {
          const { sortBy, descending, page, rowsPerPage } = this.pagination
          this.getTransactions(this.pagination).then(items => {
            // console.log('items', items)
            const total = items.total
            items = items.data

            if (this.pagination.sortBy) {
              items = items.sort((a, b) => {
                this.test = sortBy
                const sortA = 'name' == sortBy ? a['who'][sortBy] :  a[sortBy]
                const sortB = 'name' == sortBy ? b['who'][sortBy] :  b[sortBy]

                if (descending) {
                  if (sortA < sortB) return 1
                  if (sortA > sortB) return -1
                  return 0
                } else {
                  if (sortA < sortB) return -1
                  if (sortA > sortB) return 1
                  return 0
                }
              })
            }

            // if (rowsPerPage > 0) {
            //   items = items.slice((page - 1) * rowsPerPage, page * rowsPerPage)
            // }

            this.loading = false
            resolve({
              items,
              total
            })
          })
        })
      },

      async getTransactions(params) {
        this.$store.dispatch('loader', true)
        if (this.dateFrom) {
          params.dateFrom = this.dateFrom
        }
        if (this.dateTo) {
          params.dateTo = this.dateTo
        }
        let transactions = await axios.get('/transactions', {params})
        this.$store.dispatch('loader', false)
        return {data: transactions.data.data, total: transactions.data.total}
      },

    }
  }
</script>

<style lang="scss" scoped>
.chart-container{
  position: relative;
  width: 100%;
  height: calc(100vh - 84px);
}

</style>
