<template>
  <div :class="className" :id="id" :style="{height:height,width:width}"/>
</template>

<script>
import echarts from 'echarts'
import resize from './mixins/resize'
import axios from 'axios'

export default {
  mixins: [resize],
  props: {
    className: {
      type: String,
      default: 'chart'
    },
    id: {
      type: String,
      default: 'chart'
    },
    width: {
      type: String,
      default: '200px'
    },
    height: {
      type: String,
      default: '200px'
    }
  },
  data() {
    return {
      chart: null,
      statistic: {
        labels: [],
        series: [],
        sum_donate: [],
        sum_commission: []
      }
    }
  },
  mounted() {
    this.initChart()
  },
  beforeDestroy() {
    if (!this.chart) {
      return
    }
    this.chart.dispose()
    this.chart = null
  },
  created () {
    this.fetchStatistic()
  },
  methods: {
    fetchStatistic () {
      console.log('fetchStatistic =)')
      axios.get('/statistic/donate').then(response => {
        console.log('fetchStatistic =)', response.data)
        const data = response.data
        this.statistic = data
        this.initChart()
      })
      // request({
      //   url: '/statistic/donate',
      //   method: 'get',
      // }).then(response => {
      //   const data = response.data
      //   this.statistic = data
      //   this.initChart()
      // })
    },
    initChart() {
      this.chart = echarts.init(document.getElementById(this.id))

      this.chart.setOption({
        backgroundColor: '#394056',
        title: {
          top: 20,
          text: 'Статистика',
          textStyle: {
            fontWeight: 'normal',
            fontSize: 16,
            color: '#F1F1F3'
          },
          left: '1%'
        },
        tooltip: {
          trigger: 'axis',
          axisPointer: {
            lineStyle: {
              color: '#57617B'
            }
          }
        },
        legend: {
          top: 20,
          icon: 'rect',
          itemWidth: 14,
          itemHeight: 5,
          itemGap: 13,
          data: ['Доход', 'Донатов'],
          right: '4%',
          textStyle: {
            fontSize: 12,
            color: '#F1F1F3'
          }
        },
        grid: {
          top: 100,
          left: '2%',
          right: '2%',
          bottom: '2%',
          containLabel: true
        },
        xAxis: [{
          type: 'category',
          boundaryGap: false,
          axisLine: {
            lineStyle: {
              color: '#57617B'
            }
          },
          data: this.statistic.labels
          // data: ['01/10', '02/10', '03/10', '04/10', '05/10', '06/10', '07/10', '08/10', '09/10', '10/10', '11/10', '12/10','13/10', '14/10', '15/10', '16/10', '17/10', '18/10', '19/10', '20/10', '21/10', '22/10', '23/10', '24/10', '25/10', '26/10', '27/10', '28/10', '29/10', '30/10', '31/10']
        }],
        yAxis: [{
          type: 'value',
          name: '(%)',
          axisTick: {
            show: false
          },
          axisLine: {
            lineStyle: {
              color: '#57617B'
            }
          },
          axisLabel: {
            margin: 10,
            textStyle: {
              fontSize: 14
            }
          },
          splitLine: {
            lineStyle: {
              color: '#57617B'
            }
          }
        }],
        series: [{
          name: 'Доход',
          type: 'line',
          smooth: true,
          symbol: 'circle',
          symbolSize: 5,
          showSymbol: false,
          lineStyle: {
            normal: {
              width: 1
            }
          },
          areaStyle: {
            normal: {
              color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: 'rgba(137, 189, 27, 0.3)'
              }, {
                offset: 0.8,
                color: 'rgba(137, 189, 27, 0)'
              }], false),
              shadowColor: 'rgba(0, 0, 0, 0.1)',
              shadowBlur: 10
            }
          },
          itemStyle: {
            normal: {
              color: 'rgb(137,189,27)',
              borderColor: 'rgba(137,189,2,0.27)',
              borderWidth: 12

            }
          },
          data: this.statistic.sum_donate
          // data: [220, 182, 191, 134, 150, 120, 110, 125, 145, 122, 165, 122, 220, 182, 191, 134, 150, 120, 110, 125, 145, 122, 165, 122, 120, 110, 125, 145, 122, 165, 122]
        }, 
        // {
        //   name: 'Комиссия',
        //   type: 'line',
        //   smooth: true,
        //   symbol: 'circle',
        //   symbolSize: 5,
        //   showSymbol: false,
        //   lineStyle: {
        //     normal: {
        //       width: 1
        //     }
        //   },
        //   areaStyle: {
        //     normal: {
        //       color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
        //         offset: 0,
        //         color: 'rgba(0, 136, 212, 0.3)'
        //       }, {
        //         offset: 0.8,
        //         color: 'rgba(0, 136, 212, 0)'
        //       }], false),
        //       shadowColor: 'rgba(0, 0, 0, 0.1)',
        //       shadowBlur: 10
        //     }
        //   },
        //   itemStyle: {
        //     normal: {
        //       color: 'rgb(0,136,212)',
        //       borderColor: 'rgba(0,136,212,0.2)',
        //       borderWidth: 12

        //     }
        //   },
        //   data: this.statistic.sum_commission
        //   // data: [120, 110, 125, 145, 122, 165, 122, 220, 182, 191, 134, 150, 120, 110, 125, 145, 122, 165, 122, 220, 182, 191, 134, 150, 165, 122, 220, 182, 191, 134, 150]
        // },
        {
          name: 'Донатов',
          type: 'line',
          smooth: true,
          symbol: 'circle',
          symbolSize: 5,
          showSymbol: false,
          lineStyle: {
            normal: {
              width: 1
            }
          },
          areaStyle: {
            normal: {
              color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: 'rgba(219, 50, 51, 0.3)'
              }, {
                offset: 0.8,
                color: 'rgba(219, 50, 51, 0)'
              }], false),
              shadowColor: 'rgba(0, 0, 0, 0.1)',
              shadowBlur: 10
            }
          },
          itemStyle: {
            normal: {
              color: 'rgb(219,50,51)',
              borderColor: 'rgba(219,50,51,0.2)',
              borderWidth: 12
            }
          },
          data: this.statistic.series
          // data: [220, 182, 125, 145, 122, 191, 134, 150, 120, 110, 165, 122]
        }
        ]
      })
    }
  }
}
</script>
