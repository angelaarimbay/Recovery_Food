<template>
<v-card class="p-4 rounded-tr-xl">
        <v-card-title class="p-0 h6"> <v-icon color="red" size="25">mdi-magnify</v-icon> Quick Search</v-card-title> 
        <hr class="m-0">
    <v-card flat >    
        <v-text-field  v-model="search" label="search company"> </v-text-field>   
        <v-card  flat style="overflow-y: auto;" height="250" >
            <v-data-table 
                :headers="headers" 
                :sort-by="['name']"
                :page.sync="page"
                :items="data" dense
                :search="search" 
                hide-default-footer
                :items-per-page="6" > 
                        <template v-slot:[`item.iron`]="{ item }">  
                        <v-hover v-slot="{ hover }" >
                            <v-btn class="px-1" text :class="hover ? 'btn btn-info text-white':'btn btn-link text-info'"  small @click="dialog = true"  > 
                            <v-icon> mdi-eye </v-icon> 
                            <small> - View </small>   
                            </v-btn>
                        </v-hover> 
                    </template>   
            </v-data-table> 
        </v-card>
        <hr>
           <v-card-actions class="p-0">
            <v-pagination 
            v-model="page"
            :length="Math.ceil(data.length / 6)"
            ></v-pagination>
            <v-spacer></v-spacer>
        </v-card-actions> 


    <!-- dialog -->

    <v-dialog
        transition="dialog-top-transition"
        max-width="600"
        v-model="dialog"
      > 
       
          <v-card>
            <v-toolbar color="danger" dark >Accumulation Details</v-toolbar>
            <br>
            <v-card-text>
                <div class="text-h5">Company name</div><br>         
              <v-row>
                <v-col class="p-0 pl-2 border-bottom" xl="4">test</v-col>
                <v-col class="p-0 pl-2 border-bottom"  xl="4">test</v-col>
                <v-col class="p-0 pl-2 border-bottom"  xl="4">test</v-col>
              </v-row>
              <v-row>
                <v-col class="p-0 pl-2 border-bottom" xl="4">test</v-col>
                <v-col class="p-0 pl-2 border-bottom"  xl="4">test</v-col>
                <v-col class="p-0 pl-2 border-bottom"  xl="4">test</v-col>
              </v-row>
              <v-row>
                <v-col class="p-0 pl-2 border-bottom" xl="4">test</v-col>
                <v-col class="p-0 pl-2 border-bottom"  xl="4">test</v-col>
                <v-col class="p-0 pl-2 border-bottom"  xl="4">test</v-col>
              </v-row>
            </v-card-text>
            <v-card-actions class="justify-end">
              <v-btn
                text
                @click="dialog = false"
              >Close</v-btn>
            </v-card-actions>
          </v-card> 
    </v-dialog>

 

</v-card>
</v-card>
</template>
<script> 
export default { 
    data: () => ({
        page:1, 
        dialog: false,
        search: '',
        headers: [  
          {class:'border', text: 'Company',  value: 'name' }, 
          {class:'border', text: 'Action', value: 'iron' },  
        ],
        data: [
          {
            name: 'Frozen Yogurt', 
            iron: '1%',
          },
          {
            name: 'Ice cream sandwich Ice cream sandwich Ice cream sandwich', 
            iron: '1%',
          },
          {
            name: 'Eclair', 
            iron: '7%',
          },
          {
            name: 'Cupcake', 
            iron: '8%',
          },
          {
            name: 'Gingerbread', 
            iron: '16%',
          },
          {
            name: 'Jelly bean', 
            iron: '0%',
          },
          {
            name: 'Lollipop', 
            iron: '2%',
          },
          {
            name: 'Honeycomb', 
            iron: '45%',
          },
          {
            name: 'Donut', 
            iron: '22%',
          },
          {
            name: 'KitKat', 
            iron: '6%',
          },
          {
            name: 'KitKat', 
            iron: '6%',
          },
        ],

    }),
}
</script>