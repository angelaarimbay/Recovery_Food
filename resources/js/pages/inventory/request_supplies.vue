<template>
  <div> 
    <v-snackbar
      :vertical="$vuetify.breakpoint.xsOnly"
      min-width="auto"
      v-model="snackbar.active"
      timeout="2500"
    >
      <span
        ><v-icon :color="snackbar.iconColor">{{
          `mdi-${snackbar.iconText}`
        }}</v-icon></span
      >
      {{ snackbar.message }}
      <template v-slot:action="{ attrs }">
        <v-btn
          :small="$vuetify.breakpoint.smAndDown"
          v-bind="attrs"
          color="primary"
          text
          @click="snackbar.active = false"
          >Close</v-btn
        >
      </template>
    </v-snackbar>
    <v-container>
      <v-layout row wrap>
        <span
          class="
            text-h6 text-xl-h5 text-lg-h5 text-md-h6 text-sm-h6
            font-weight-bold
            my-auto
          "
        >
          Supplies Request
        </span>
        <v-spacer></v-spacer>

        <!-- Breadcrumbs -->
        <v-card-actions class="px-0 py-0">
          <v-btn
            :small="$vuetify.breakpoint.smAndDown"
            plain
            color="primary"
            v-ripple="false"
            to="/dashboard"
            class="px-0"
            style="text-decoration: none; text-transform: none"
            >Inventory</v-btn
          >
          /
          <v-btn
            :small="$vuetify.breakpoint.smAndDown"
            text
            disabled
            class="px-0"
            style="text-transform: none"
            >Supplies Request</v-btn
          >
        </v-card-actions>
      </v-layout>
    </v-container>
    <!-- Main Card -->
    <v-card elevation="6" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn small color="red" dark @click="addRequest">Add new</v-btn>
        </v-card-actions>
             <v-data-table
                :headers="headers"
                :items="table.data"
                :loading="progressbar"
                :page.sync="page"
                ref="progress"
                :items-per-page="itemsPerPage"
                hide-default-footer
                @page-count="pageCount = $event"
              >
                <!-- Progress Bar -->
                <v-progress-linear
                  color="red darken-2"
                  class="px-0 mx-0"
                  slot="progress"
                  indeterminate
                  rounded
                ></v-progress-linear>

                <template v-slot:[`item.supply_name`]="{ item }">
                  {{ item.supply_name }} {{ item.description }}</template
                >
                
              <template v-slot:[`item.status`]="{ item }">  
                <div v-if="item.status == 1" class="text-warning">Pending</div>
                <div v-else-if="item.status == 2" class="text-success">Confirmed / For Delivery</div>
                <div v-else-if="item.status == 3" class="text-success">Completed</div>
              </template>
              

                <template v-slot:[`item.id`]="{ item }">
                  <div v-if="item.status == 2">
                   <v-tooltip bottom>
                    <template #activator="data">
                      <v-btn
                        icon
                        color="success darken-2"
                        @click="completeRequest(item)"
                        small
                        :x-small="$vuetify.breakpoint.smAndDown"
                        v-on="data.on"
                      >
                        <v-icon>mdi-check</v-icon>
                      </v-btn>
                    </template>
                    <span>Complete</span>
                  </v-tooltip> 
                  </div> 
                  <div  v-else-if="item.status == 1">
                   <v-tooltip bottom>
                    <template #activator="data">
                      <v-btn
                        icon
                        color="blue darken-2"
                        @click="viewRequest(item)"
                        small
                        :x-small="$vuetify.breakpoint.smAndDown"
                        v-on="data.on"
                      >
                        <v-icon>mdi-pencil</v-icon>
                      </v-btn>
                    </template>
                    <span>Edit</span>
                  </v-tooltip>
                  <v-tooltip bottom>
                    <template #activator="data">
                      <v-btn
                        icon
                        color="red darken-2"
                        @click="cancelRequest(item)"
                        small
                        :x-small="$vuetify.breakpoint.smAndDown"
                        v-on="data.on"
                      >
                        <v-icon>mdi-cancel</v-icon>
                      </v-btn>
                    </template>
                    <span>Cancel</span>
                  </v-tooltip></div>
                </template>
              </v-data-table>
               <div class="text-center pt-2">
            <v-pagination
              v-model="page"
              :total-visible="7"
              :length="table.last_page"
              color="red darken-2"
            ></v-pagination>
          </div>
        <!-- Table -->
      </v-container>
    </v-card>

      <v-dialog v-model="dialog_list" 
      hide-overlay fullscreen>
        <v-form ref="form"> 
        <v-toolbar
          dense
          dark
          class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
        >
          Enter Quantity
        <v-spacer></v-spacer>
        <v-btn text @click="closeRequest"><v-icon>mdi-close</v-icon></v-btn> 
        </v-toolbar> 
       
        <v-card tile height="710" style="background-color: #f5f5f5">
          <v-card-text class="py-2">
            <v-container class="pa-xl-3 pa-lg-3 pa-md-2 pa-sm-0 pa-0">
            <v-row>
          <v-col xl="6" lg="6" cols="6">
            <span>Supplies list</span>
            <v-card >
              <v-data-table :headers="headers1"
                height="390"  
               :items="table1" ref="progress">
                <!-- Progress Bar -->
                <v-progress-linear
                  color="red darken-2"
                  class="px-0 mx-0"
                  slot="progress"
                  indeterminate 
                  rounded
                ></v-progress-linear>

                <template v-slot:[`item.supply_name`]="{ item }">
                  {{ item.supply_name }} {{ item.description }}</template
                >

                <template v-slot:[`item.id`]="{ item }">
                  <v-tooltip bottom>
                    <template #activator="data">
                      <v-btn
                        icon
                        color="red darken-2"
                        @click="validateAdd(item,'Add')"
                        small
                        :x-small="$vuetify.breakpoint.smAndDown"
                        v-on="data.on"
                      >
                        <v-icon>mdi-arrow-collapse-right</v-icon>
                      </v-btn>
                    </template>
                    <span>Add</span>
                  </v-tooltip>
                </template>
              </v-data-table>
            </v-card>
          </v-col>
          <v-col xl="6" lg="6" cols="6"> 
            <v-card-actions>
              <div>No. of Items: {{ table2.length }} </div> <v-spacer></v-spacer>
              <div v-if="ref">Request Ref #: {{  ref }} </div> 
            </v-card-actions>
            <v-card max-height="350" min-height="350" style="overflow-y: auto">
              <v-data-table
                :headers="headers2"
                :items="table2"
                dense
                :items-per-page="table2.length"
                hide-default-footer
                ref="progress"
              >
                <!-- Progress Bar -->
                <v-progress-linear
                  color="red darken-2"
                  class="px-0 mx-0"
                  slot="progress"
                  indeterminate
                  rounded
                ></v-progress-linear>

                <template v-slot:[`item.supply_name`]="{ item }">
                  {{ item.supply_name }} {{ item.description }}</template
                >

                           <template v-slot:[`item.status`]="{ item }">
                  {{ item.status }}</template
                >

                <template v-slot:[`item.id`]="{ item }">
                   <v-tooltip bottom>
                    <template #activator="data">
                      <v-btn
                        icon
                        color="blue darken-2"
                        @click="validateAdd(item,'Update')"
                        small
                        :x-small="$vuetify.breakpoint.smAndDown"
                        v-on="data.on"
                      >
                        <v-icon>mdi-pencil</v-icon>
                      </v-btn>
                    </template>
                    <span>Edit</span>
                  </v-tooltip>
                  <v-tooltip bottom>
                    <template #activator="data">
                      <v-btn
                        icon
                        color="red darken-2"
                        @click="validateAdd(item,'Delete')"
                        small
                        :x-small="$vuetify.breakpoint.smAndDown"
                        v-on="data.on"
                      >
                        <v-icon>mdi-delete</v-icon>
                      </v-btn>
                    </template>
                    <span>Delete</span>
                  </v-tooltip>
                </template>
              </v-data-table>
            </v-card>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="success" @click="storeRequest"> Post Request</v-btn>
            </v-card-actions>
          </v-col>
        </v-row>
              
            </v-container>
          </v-card-text> 
        
        </v-card>
    </v-form>
      </v-dialog>

 
      <v-dialog v-model="dialog" max-width="450px">
        <v-toolbar
          dense
          dark
          class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
        >
          Enter Quantity
        </v-toolbar>
        <v-card tile style="background-color: #f5f5f5">
          <v-card-text class="py-2">
            <v-container class="pa-xl-3 pa-lg-3 pa-md-2 pa-sm-0 pa-0">
              <v-row>
                <v-col class="py-3" cols="12" xl="12" lg="12" sm="12" md="12">
                  <span
                    >Item Selected:
                    <strong
                      >{{ selected.supply_name }} {{ selected.description }}
                    </strong></span
                  >
                </v-col>
              </v-row>
              <v-row>
                <v-col class="py-0" cols="12" xl="12" lg="12" sm="12" md="12">
                  <v-text-field
                    :rules="formRulesQuantity"
                    v-model="quantity"
                    outlined
                    dense
                    autocomplete="off"
                    @focus="clearQ"
                    @blur="resetQ"
                    @keydown="quantityKeydown($event)"
                    counter
                    maxlength="3"
                  >
                    <template slot="label">
                      <div style="font-size: 14px">Quantity *</div>
                    </template>
                  </v-text-field>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>

          <!-- Dialog Form Buttons -->
          <v-card-actions class="px-xl-9 px-lg-9 px-md-8 px-sm-6 px-6 py-4">
            <v-spacer></v-spacer>
            <v-btn
              color="error"
              depressed
              dark
              @click="dialog = false"
              style="text-transform: none"
              :small="$vuetify.breakpoint.smAndDown"
            >
              Cancel
            </v-btn>
            <v-btn
              color="primary"
              depressed
              dark
              style="text-transform: none"
              :small="$vuetify.breakpoint.smAndDown"
              @click="commitAdd(selected)"
            >
              {{ type }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog> 
  </div>
</template>
<style>
.v-pagination button {
  background-color: #212121 !important;
  color: #ffffff !important;
}
.v-pagination i.v-icon.v-icon {
  color: #ffffff !important;
}
.v-pagination__navigation:disabled {
  background-color: #000000 !important;
}
</style> 
<script>
import axios from "axios"; // Library for sending api request
export default {
  middleware: "auth",
  data: () => ({
    headers: [
      {
        text: "REQUEST DATE",
        value: "request_date",
        class: "black--text",
      },
      {
        text: "REF",
        value: "ref",
        filterable: false,
        class: "black--text",
      }, {
        text: "REQUESTED BY",
        value: "user",
        filterable: false,
        class: "black--text",
      },  {
        text: "STATUS",
        value: "status",
        filterable: false,
        class: "black--text",
      }, 
      {
        text: "ACTION",
        value: "id",
        align: "right",
        filterable: false,
        class: "black--text",
      },
    ],
    headers1: [
      {
        text: "SUPPLY NAME",
        value: "supply_name",
        class: "black--text",
      },
      {
        text: "UNIT",
        value: "unit",
        filterable: false,
        class: "black--text",
      },
      {
        text: "ACTION",
        value: "id",
        align: "right",
        filterable: false,
        class: "black--text",
      },
    ],
    headers2: [ 
      {
        text: "SUPPLY NAME",
        value: "supply_name",
        class: "black--text",
      },

      {
        text: "UNIT",
        value: "unit",
        filterable: false,
        class: "black--text",
      },
      {
        text: "QUANTITY",
        value: "quantity",
        filterable: false,
        class: "black--text",
      },
      {
        text: "STATUS",
        value: "status",
        filterable: false,
        class: "black--text",
      },
      {
        text: "ACTION",
        value: "id",
        align: "right",
        filterable: false,
        class: "black--text",
      },
    ],
    formRulesQuantity: [
      (v) => !!v || "This is required",
      (v) => /^[1-9][0-9]*$/.test(v) || "Quantity must be valid",
    ],
    progressbar: false,
    snackbar: {
      active: false,
      message: "",
    },
    table: [],
    table1: [],
    table2: [],
    quantity: 0,
    dialog: false,
    dialog_list: false,
    selected: [],
    ref: '',
    type: '',
    page: 1,
    pageCount: 0,
    itemsPerPage: 5,
  }),
  created() {
    this.get();
  },
  watch: {
  
    page(val) {
      this.page = val;
      this.get();
    },
   
  },

  methods: {
    quantityKeydown(e) {
      if (/[\s~`!@#$%^&()_={}[\]\\"*|:;,.<>+'\/?-]/.test(e.key)) {
        e.preventDefault();
      }
    },
    // Clear Value of Quantity text-field
    clearQ() {
      if (this.quantity == 1) {
        this.quantity = null;
      }
    },
    // Reset Value of Quantity text-field
    resetQ() {
      if (this.quantity == null) {
        this.quantity = 1;
      }
    },
    async getList() {
      await axios.get("/api/requestsupp/supplies/list").then((result) => {
        this.table1 = result.data;
      });
    },
    async get() {
      await axios.get("/api/requestsupp/get"
      , {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,  
          },
        }
      ).then((result) => {
     
       this.table = result.data;
      });
    },


    validateAdd(row,type) {
      this.selected = row;
      this.type = type;
      this.dialog = true; 
    },
    commitAdd(row) { 
      if(this.type == 'Update'){
           this.Edit(row);
      } else if(this.type == 'Delete'){
           this.Delete(row);
      } else{ 

        var check_existing = -1;
        //table
        for (var i in this.table2) {
          if (row.id == this.table2[i].id) {  
            check_existing = this.table2.indexOf(this.table2[i]);
          }
        }
 
        if (check_existing > -1) {
            this.table2[check_existing].quantity =  parseInt(this.table2[check_existing].quantity)  + parseInt(this.quantity)
        } else {
            this.table2.push({
            id: row.id,
            supply_name: row.supply_name + " " + row.description,
            unit: row.unit,
            quantity: this.quantity,
            ref: '',
            status: 0,
           }); 
           
        } 
      }  
      this.dialog = false;
    },
    Delete(row){
    this.table2[this.table2.indexOf(row)].quantity = this.table2[this.table2.indexOf(row)].quantity  - this.quantity
       if(this.table2[this.table2.indexOf(row)].quantity <= 0){
        this.table2.splice(this.table2.indexOf(row), 1); 
       } 
    },
    Edit(row){    
     this.table2[this.table2.indexOf(row)].quantity = this.quantity 
    },

    async storeRequest(){
      //this is used for update request
      if(this.ref){ 
        for (var key in this.table2) {
            this.table2[key].ref = this.ref;
        }
      }   
         
      // save 
        await axios.post("/api/requestsupp/supplies/save", this.table2).then((result) => {
          //if the value is true then save to database 
          this.snackbar = {
            active: true,
            iconText: "check",
            iconColor: "success",
            message: "Successfully saved.",
          };  
          this.clearRequest();
          this.get() 
        });
    },
    addRequest(){ 
      if(this.headers2.length == 5 ){ 
        this.headers2.splice(this.headers2.indexOf(this.headers2[3]), 1);
      }
      this.dialog_list = true
      this.getList()   
 
    }, 
    async viewRequest(ref){ 
      this.getList();
      await axios.get("/api/requestsupp/request/list",{params:{ ref: ref.ref }}).then((result) => {
        this.table2 = result.data;
        this.dialog_list = true
        this.ref = ref.ref
      }); 
    },
    closeRequest(){
      this.dialog_list = false
      this.clearRequest()
    },
    clearRequest(){
      this.table2 = []
          this.ref = ''
      
    },

    async  completeRequest(ref){
       await axios.post("/api/requestsupp/request/complete", ref).then((result) => {
          //if the value is true then save to database 
          this.snackbar = {
            active: true,
            iconText: "check",
            iconColor: "success",
            message: "Request has been successfully completed.",
          };   
          this.get() 
        });
    }



  },
};
</script>

