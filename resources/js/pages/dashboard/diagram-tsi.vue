<template>
  <v-card  >
    <v-card-title>100% TSI</v-card-title> 
    <v-card-text><line-chart  :height="chartHeight" :chart-data="datacollection"></line-chart>  
     <v-card-actions><v-spacer></v-spacer> Cresta zone<v-spacer></v-spacer></v-card-actions>
      </v-card-text>
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
        chartHeight: 175,
        datacollection: {}
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
              backgroundColor: 'blue',
              data: [this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt()]
            }, 
          ]
        }
      },
      getRandomInt () {
        return Math.floor(Math.random() * (50 - 5 + 1)) + 0
      } 
    }
  }
</script>

 