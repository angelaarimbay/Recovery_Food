<template>
<v-card class="p-4 rounded-tr-xl">
      
        <v-card-title class="p-0 h6"> <v-icon color="red" size="25">mdi-sort-variant</v-icon>Top Accumulation </v-card-title> 
        <hr class="m-0"> 
        <v-card flat style="overflow-y: auto;" height="320" > 
            <v-data-table class="small"
                 :headers="headers"  
                 loading="progress"
                :page.sync="page"
                :items="data"  dense  
                hide-default-footer
                :items-per-page="10" > 
                  <v-progress-linear
                    v-show="progressBar"
                    slot="progress"
                    color="primary"
                    indeterminate
                  ></v-progress-linear>
 
                  <template v-slot:[`item.our_si`]="{ item }">
                    ₱{{ item.our_si.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") }}
                  </template>
            </v-data-table>
        </v-card>
         <hr>
           <v-card-actions class="p-0">
            <v-pagination 
            v-model="page"
            :length="Math.ceil(data.length / 10)"
            ></v-pagination>
            <v-spacer></v-spacer>
        </v-card-actions>  
</v-card>

</template>
<script>
import axios from 'axios' 
import template from '../template.vue';
export default {
  components: { template },
    data: () => ({
        page: 1,
        progressBar:false,
        headers: [ 
          { text: 'Company', value: 'insured' },
          { text: 'Figures', value: 'our_si' }, 
        ],
        data: [], 
    }),
    created (){
      this.top();
    },
    methods: {
      async top(){  
        this.progressBar = true
          await axios.get("/api/get/accumulation/top")
          .then(result =>{     
              this.data  = result.data  
              this.progressBar = false
          }).catch(res=>{ 
              this.progressBar = false
          });
      },
    },
}
</script>