<template> 
        <v-card-text>
        <p class="text-h6 text--primary">
          <v-icon>mdi-account-multiple</v-icon> - Manage Accounts
        </p>
        <p>adjective</p>




 <v-data-table
    :headers="headers"
    :items="desserts"
    :items-per-page="5"
    class="elevation-1" >
   
            

  </v-data-table>



        </v-card-text> 
</template>

<script>
  export default {
    data () {
      return {
        overlay: true,
        headers: [ 
          { text: 'id', value: 'id' },
          { text: 'Survey Pdf', value: 'calories' },
          { text: 'Action', value: 'fat' },
      
        ],
        desserts: [
          {
            name: 'Frozen Yogurt',
            calories: 159,
            fat: 6.0, 
          },
          {
            name: 'Ice cream sandwich',
            calories: 237,
            fat: 9.0, 
          },
          {
            name: 'Eclair',
            calories: 262,
            fat: 16.0, 
          },
          {
            name: 'Cupcake',
            calories: 305,
            fat: 3.7, 
          },
          {
            name: 'Gingerbread',
            calories: 356,
            fat: 16.0, 
          },
          {
            name: 'Jelly bean',
            calories: 375,
            fat: 0.0, 
          },
          {
            name: 'Lollipop',
            calories: 392,
            fat: 0.2, 
          },
          {
            name: 'Honeycomb',
            calories: 408,
            fat: 3.2, 
          },
          {
            name: 'Donut',
            calories: 452,
            fat: 25.0, 
          },
          {
            name: 'KitKat',
            calories: 518,
            fat: 26.0, 
          },
        ],
      }
    },
     created () {   
        setTimeout(() => {
            this.overlay = false
        }, 500)
        
    },   

    methods: {  
    },
  }
</script>