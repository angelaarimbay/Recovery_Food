<template>
<div>
      <v-card-title class="text-h5 grey lighten-2">
            Survey List
          </v-card-title>
        

          <v-card-text>  
            <v-card-text>
              <v-btn class="info" small @click="natcat_add_dialog = true">Add new</v-btn>
            </v-card-text>
              <v-data-table
                :headers="natcat_headers"
                :items="natcat_data"
                :items-per-page="5"
                class="elevation-1"
              >
                <template v-slot:[`item.filename`]="{ item }">
                <v-btn small color="blue" dark>Download</v-btn>
                </template>
              
              </v-data-table> 
          </v-card-text> 

 
      <v-dialog v-model="natcat_add_dialog" width="800" >  
        <v-card>
          <v-card-title class="text-h5 grey lighten-2">
            Add New Survey
          </v-card-title> 
          <v-card-text>
            <v-container>  
                <v-text-field label="Title" v-model="data.title"   hide-details="auto" ></v-text-field>
                <v-text-field label="Description" v-model="data.description"   hide-details="auto" ></v-text-field>
                <v-menu ref="menu" max-width="280" v-model="menu" :close-on-content-click="false" :return-value.sync="date" transition="scale-transition" offset-ymin-width="auto" >
                  <template  v-slot:activator="{ on, attrs }">
                  <v-text-field  v-model="data.dated" label="Date" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" ></v-text-field></template>
                  
                  <v-date-picker  v-model="data.dated" no-title scrollable >
                  <v-spacer></v-spacer>
                  <v-btn text color="primary" @click="menu = false" >
                      Cancel
                  </v-btn>
                  <v-btn text color="primary" @click="$refs.menu.save(data.dated)">
                      OK
                  </v-btn>
                  </v-date-picker>
                </v-menu>              
                <v-text-field label="Filename" v-model="data.lossratio"   hide-details="auto" ></v-text-field>
            </v-container>
          </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
              <v-spacer></v-spacer>
            <v-btn
              color="blue darken-1"
              text
              @click="natcat_add_dialog = false"
            >
              Close
            </v-btn>
             <v-btn
              color="primary darken-1"
              text
              @click="natcat_add_dialog = false"
            >
              Save
            </v-btn>
            </v-card-actions>
        </v-card>
      </v-dialog>
</div>
</template> 
<script> 
  export default {
    data () {
      return {
            menu: false,
            date: new Date().toISOString().substr(0, 10), 
            natcat_dialog: false, 
            natcat_headers: 
            [ 
                { text: 'Dated', value: 'date' },
                { text: 'Title', value: 'title' },
                { text: 'Description', value: 'description' },
                { text: 'Attachment', value: 'filename' },  
                { text: 'Action', value: 'id' },  
            ],
            natcat_data: [], 
            natcat_add_dialog: false,
            data:{
                title: '5%',
                description: 'Nil',
                dated: '2020-01-23',
                file: '2015 - Typhoon A, Claimed paid = 100k', 
            }
        }
    },
   
}
</script>
