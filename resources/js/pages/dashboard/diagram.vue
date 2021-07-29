<template>
  <v-card  >
    <v-card-title>Typhoon</v-card-title> 
    <line-chart  height="175" :chart-data="datacollection"></line-chart> 
  </v-card>
</template>

<script>
  import LineChart from '../charts/BarChart'
  export default {
    components: {
      LineChart
    },
    data () {
      return {
        datacollection: null
      }
    },
    mounted () {
      this.fillData()
    },
    methods: {
      fillData () {
        this.datacollection = {
          labels:["0","1", "2", "3","4","5","6","7","8","9"],
          datasets: [
            {
              label: 'TSI',
              backgroundColor: 'red',
              data: [this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt()]
            }, {
              label: 'Our Share',
              backgroundColor: 'green',
              data: [this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt()]
            }, 
          ]
        }
      },
      getRandomInt () {
        return Math.floor(Math.random() * (50 - 5 + 1)) + 500000
      }
    }
  }
</script>

 