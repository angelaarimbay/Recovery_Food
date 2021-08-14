<template>
  <v-card  >
    <v-card-title>Full TSI / Our TSI</v-card-title> 
    <v-card-text><bar-chart :options="options" :height="chartHeight" :chart-data="datacollection"></bar-chart>  
     <v-card-actions><v-spacer></v-spacer> Cresta zone<v-spacer></v-spacer></v-card-actions></v-card-text> 
     
  </v-card>
</template>

<script>
  import axios from 'axios' 
  import BarChart from '../charts/BarChart'
  export default {
    components: {
      BarChart
    },
    data () {
      return {
        zone: [],
        amount: [],
        options: {  
          animation: false,  
          responsiveAnimationDuration: 0,
            tooltips: {
                    enabled: true,
                    mode: 'single', 
                    callbacks: {
                     
                          label: function (tooltipItems, data) {
                              return '₱' + tooltipItems.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") ;
                          }
                    }
              },
             
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  callback: function(value, index, values) {
                    if(parseInt(value) >= 1000){ 
                      return '₱' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    } else {
                      return '₱' + value;
                    }
                  }
                }
              },
              ]
            },
          },
        chartHeight: 175,
        datacollection: {}

      }
    },
    mounted () {
      this.chartvalue() 
    },
    methods: {
      fillData () { 
        this.datacollection = {
          labels: this.zone,   
            datasets: [
                {
                label: 'Our Share',
                backgroundColor: '#cc0022',
                data:  this.amount,    
             
                }
            ], 
          } 
      },
      getRandomInt () {
        return Math.floor(Math.random() * (50 - 5 + 1)) + 0
      },
     
      async chartvalue(){  
        this.progressBar = true
          await axios.get("/api/get/accumulation/chart1")
          .then(result =>{     
            console.log(result.data)
              this.zone  = result.data.zone;
              this.amount = result.data.amount;
              this.fillData();
              this.progressBar = false
          }).catch(res=>{ 
              this.progressBar = false
          });
      },
    }
  }
</script>

 