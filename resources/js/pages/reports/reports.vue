<template>
  <div style="min-width: 280px">
    <!-- Snackbar -->
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
        <h4
          class="font-weight-bold heading my-auto"
          :class="{ h5: $vuetify.breakpoint.smAndDown }"
        >
          Reports
        </h4>
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
            >Home</v-btn
          >
          /
          <v-btn
            :small="$vuetify.breakpoint.smAndDown"
            text
            disabled
            class="px-0"
            style="text-transform: none"
            >Reports</v-btn
          >
        </v-card-actions>
      </v-layout>
    </v-container>

    <!-- Main Card -->
    <v-card elevation="6" class="mt-2" style="border-radius: 10px">
      <v-tabs
        slider-size="4"
        v-model="tab"
        color="red darken-2"
        :height="height"
        show-arrows
        center-active
        centered
      >
        <v-tabs-slider style="display: none"></v-tabs-slider>
        <v-tab
          :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
          style="text-transform: none"
        >
          Masterlist Supplies Report
        </v-tab>
        <v-tab
          :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
          style="text-transform: none"
        >
          Incoming Supplies Report
        </v-tab>
        <v-tab
          :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
          style="text-transform: none"
        >
          Outgoing Supplies Report
        </v-tab>
        <v-tab
          :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
          style="text-transform: none"
        >
          Main Inventory Report
        </v-tab>
        <v-tab
          :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
          style="text-transform: none"
        >
          Inventory Summary Report
        </v-tab>
        <v-tab
          :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
          style="text-transform: none"
        >
          Sales Report
        </v-tab>
        <v-tab
          :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
          style="text-transform: none"
        >
          Transaction Report
        </v-tab>
        <v-tab
          :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
          style="text-transform: none"
        >
          Purchase Orders Report
        </v-tab>
      </v-tabs>

      <v-tabs-items v-model="tab">
        <v-tab-item>
          <!-- Masterlist Supplies Report -->
          <masterlists1/>
        </v-tab-item>

        <v-tab-item>
          <!-- Incoming Supplies Report -->
          <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
            <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
              <v-card-actions class="px-0 justify-center">
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                       @click="getPDF_Incoming_supplies('pdf')"
                     v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-pdf</v-icon></v-btn
                    >
                  </template>
                  <span>Export to PDF</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                    @click="getEXCEL_Incoming_supplies('excel')"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-excel</v-icon></v-btn
                    >
                  </template>
                  <span>Export to Excel</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-printer</v-icon></v-btn
                    >
                  </template>
                  <span>Print</span>
                </v-tooltip></v-card-actions
              >
              <!-- Category Field -->
              <v-row no-gutters justify="center">
                <v-col cols="12" xl="2" lg="3" md="3" sm="12" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-select
                      :items="suppcatlist"
                      item-text="supply_cat_name"
                    v-model="incoming_category"
                       item-value="id"
                      class="my-0"
                      clearable
                      dense
                      label="Category"
                    >
                    </v-select>
                  </v-card-actions>
                </v-col>

                <!-- Date Picker -->
                <v-col cols="6" xl="2" lg="3" md="3" sm="6" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-menu
                      v-model="date1"
                      :close-on-content-click="false"
                      :nudge-right="35"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                            v-model="incoming_from"
                       label="Date From"
                          prepend-icon="mdi-calendar-range"
                          readonly
                          v-on="on"
                          class="py-0"
                          dense
                          clearable
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="incoming_from"
                        @input="date1 = false"
                        scrollable
                        no-title
                        color="red darken-2"
                        dark
                      ></v-date-picker>
                    </v-menu>
                  </v-card-actions>
                </v-col>

                <v-col cols="6" xl="2" lg="3" md="3" sm="6" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-menu
                      v-model="date2"
                      :close-on-content-click="false"
                      :nudge-right="35"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="incoming_to"
                          label="Date Until"
                          prepend-icon="mdi-calendar-range"
                          readonly
                          v-on="on"
                          class="py-0"
                          dense
                          clearable
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="incoming_to"
                        @input="date2 = false"
                        scrollable
                        no-title
                        color="red darken-2"
                        dark
                      ></v-date-picker>
                    </v-menu>
                  </v-card-actions>
                </v-col>
              </v-row>
            </v-container>
          </v-container>
        </v-tab-item>

        <v-tab-item>
          <!-- Outgoing Supplies Report -->
          <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
            <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
              <v-card-actions class="px-0 justify-center">
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-pdf</v-icon></v-btn
                    >
                  </template>
                  <span>Export to PDF</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-excel</v-icon></v-btn
                    >
                  </template>
                  <span>Export to Excel</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-printer</v-icon></v-btn
                    >
                  </template>
                  <span>Print</span>
                </v-tooltip></v-card-actions
              >
              <!-- Branch Field -->
              <v-row no-gutters justify="center">
                <v-col cols="6" xl="2" lg="3" md="3" sm="12" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-select
                      :items="branchlist"
                      item-text="branch_name"
                      item-value="id"
                      class="my-0"
                      clearable
                      dense
                      label="Branch"
                    >
                    </v-select>
                  </v-card-actions>
                </v-col>

                <!-- Category Field -->
                <v-col cols="6" xl="2" lg="3" md="3" sm="12" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-select
                      :items="suppcatlist"
                      item-text="supply_cat_name"
                      item-value="id"
                      class="my-0"
                      clearable
                      dense
                      label="Category"
                    >
                    </v-select>
                  </v-card-actions>
                </v-col>

                <!-- Date Picker -->
                <v-col cols="6" xl="2" lg="3" md="3" sm="6" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-menu
                      v-model="date3"
                      :close-on-content-click="false"
                      :nudge-right="35"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateFromOutgoing"
                          label="Date From"
                          prepend-icon="mdi-calendar-range"
                          readonly
                          v-on="on"
                          class="py-0"
                          dense
                          clearable
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="dateFromOutgoing"
                        @input="date3 = false"
                        scrollable
                        no-title
                        color="red darken-2"
                        dark
                      ></v-date-picker>
                    </v-menu>
                  </v-card-actions>
                </v-col>

                <v-col cols="6" xl="2" lg="3" md="3" sm="6" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-menu
                      v-model="date4"
                      :close-on-content-click="false"
                      :nudge-right="35"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateUntilOutgoing"
                          label="Date Until"
                          prepend-icon="mdi-calendar-range"
                          readonly
                          v-on="on"
                          class="py-0"
                          dense
                          clearable
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="dateUntilOutgoing"
                        @input="date4 = false"
                        scrollable
                        no-title
                        color="red darken-2"
                        dark
                      ></v-date-picker>
                    </v-menu>
                  </v-card-actions>
                </v-col>
              </v-row>
            </v-container>
          </v-container>
        </v-tab-item>

        <v-tab-item>
          <!-- Main Inventory Report -->
          <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
            <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
              <v-card-actions class="px-0 justify-center">
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-pdf</v-icon></v-btn
                    >
                  </template>
                  <span>Export to PDF</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-excel</v-icon></v-btn
                    >
                  </template>
                  <span>Export to Excel</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-printer</v-icon></v-btn
                    >
                  </template>
                  <span>Print</span>
                </v-tooltip></v-card-actions
              >
              <!-- Category Field -->
              <v-row no-gutters justify="center">
                <v-col cols="6" xl="2" lg="3" md="4" sm="6" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-select
                      :items="suppcatlist"
                      item-text="supply_cat_name"
                      item-value="id"
                      class="my-0"
                      clearable
                      dense
                      label="Category"
                    >
                    </v-select>
                  </v-card-actions>
                </v-col>
              </v-row>
            </v-container>
          </v-container>
        </v-tab-item>

        <v-tab-item>
          <!-- Inventory Summary Report -->
          <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
            <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
              <v-card-actions class="px-0 justify-center">
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-pdf</v-icon></v-btn
                    >
                  </template>
                  <span>Export to PDF</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-excel</v-icon></v-btn
                    >
                  </template>
                  <span>Export to Excel</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-printer</v-icon></v-btn
                    >
                  </template>
                  <span>Print</span>
                </v-tooltip></v-card-actions
              >
            </v-container>
          </v-container>
        </v-tab-item>

        <v-tab-item>
          <!-- Sales Report -->
          <sales1/>
        </v-tab-item>

        <v-tab-item>
          <!-- Transaction Report -->
          <transaction1/>
        </v-tab-item>

        <v-tab-item>
          <!-- Purchase Order Report -->
          <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
            <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
              <v-card-actions class="px-0 justify-center">
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      @click="getPO('pdf')"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-pdf</v-icon></v-btn
                    >
                  </template>
                  <span>Export to PDF</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      @click="getPO('excel')"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-file-excel</v-icon></v-btn
                    >
                  </template>
                  <span>Export to Excel</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      color="primary"
                      class="mx-1"
                      v-on="data.on"
                      :small="$vuetify.breakpoint.smAndDown"
                      ><v-icon>mdi-printer</v-icon></v-btn
                    >
                  </template>
                  <span>Print</span>
                </v-tooltip></v-card-actions
              >

              <v-row no-gutters justify="center">
                <!-- Date Picker -->
                <v-col cols="6" xl="2" lg="3" md="4" sm="6" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-menu
                      v-model="date9"
                      :close-on-content-click="false"
                      :nudge-right="35"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateFromPO"
                          label="Date From"
                          prepend-icon="mdi-calendar-range"
                          readonly
                          v-on="on"
                          class="py-0"
                          dense
                          clearable
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="dateFromPO"
                        @input="date9 = false"
                        scrollable
                        no-title
                        color="red darken-2"
                        dark
                      ></v-date-picker>
                    </v-menu>
                  </v-card-actions>
                </v-col>

                <v-col cols="6" xl="2" lg="3" md="4" sm="6" class="my-auto">
                  <v-card-actions class="pb-0 pt-4">
                    <v-menu
                      v-model="date10"
                      :close-on-content-click="false"
                      :nudge-right="35"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateUntilPO"
                          label="Date Until"
                          prepend-icon="mdi-calendar-range"
                          readonly
                          v-on="on"
                          class="py-0"
                          dense
                          clearable
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="dateUntilPO"
                        @input="date10 = false"
                        scrollable
                        no-title
                        color="red darken-2"
                        dark
                      ></v-date-picker>
                    </v-menu>
                  </v-card-actions>
                </v-col>
              </v-row>
            </v-container>
          </v-container>
        </v-tab-item>
      </v-tabs-items>
    </v-card>
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
import masterlists1 from './report_types/masterlist.vue'
import sales1 from './report_types/sales.vue'
import transaction1 from './report_types/transaction.vue'
import { mapGetters } from "vuex";
import axios from "axios"; // Library for sending api request
export default {
  middleware: "auth",
    components: {
    masterlists1,sales1,transaction1
  },

  data: () => ({
    progressbar1: false,
    progressbar2: false,
    search1: "",
    search2: "",
    tab: null,
    category: "",
    category1: "",
    category2: "",
    snackbar: {
      active: false,
      message: "",
    },
    suppcatlist: [],
    branchlist: [],
    prodcatlist: [],
    table1: [],
    table2: [],
    branch1: "",
    branch2: "",
    dateFromIncoming: null,
    dateUntilIncoming: null,
    dateFromOutgoing: null,
    dateUntilOutgoing: null,
    dateFromSP: null,
    dateUntilSP: null,
    dateFromTP: null,
    dateUntilTP: null,
    dateFromPO: null,
    dateUntilPO: null,
    date1: false,
    date2: false,
    date3: false,
    date4: false,
    date5: false,
    date6: false,
    date7: false,
    date8: false,
    date9: false,
    date10: false,
    page1: 1,
    page2: 1,
    pageCount: 0,
    itemsPerPage1: 5,
    itemsPerPage2: 5,

  
    // Table Headers TP
    headers2: [
      { text: "#", value: "count", align: "start", filterable: false },
      {
        text: "Branch",
        value: "",
        filterable: false,
      },
      { text: "Date & Time", value: "" },
      {
        text: "Reference No.",
        value: "",
        align: "right",
        filterable: false,
      },
      {
        text: "Total Product",
        value: "",
        align: "right",
        filterable: false,
      },
      {
        text: "Total Amount",
        value: "",
        align: "right",
        filterable: false,
      },
      {
        text: "Actions",
        value: "id",
        align: "center",
        sortable: false,
        filterable: false,
      },
    ],

    //from angela
    //incoming
        incoming_category: "",
        incoming_from: null,
        incoming_to: null,
      //outgoing
        outgoing_branch: "", 
        outgoing_category: "", 
        outgoing_from: null,
        outgoing_to: null,
      //main
        main_category: '', 
 

  }),

  created() {
    if (this.user.permissionslist.includes("Access Reports")) {
      this.prodCat();
      this.suppCat();
      this.branchName();
    } else {
      this.$router.push({ name: "invalid-page" }).catch((errr) => {});
    }
  },

  methods: {
   

    //from angela. pwede mo custom depende sa iyo, ung mga naming etc.. 
  async getPDF_Masterlist(type) {
      switch (type) {
        case "pdf":
          await axios({
            url: "/api/reports/masterlist/get",
            method: "GET",
            responseType: "blob",
           params: { category: this.masterlist_category, type: type },
          }).then((response) => {  
            console.log(response.data)
            let blob = new Blob([response.data], { type: "application/pdf" });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = "data.pdf";
            link.click();
          });
          break;
        case "excel":
          await axios
            .get("/api/reports/masterlist/get", {
              method: "GET",
              responseType: "arraybuffer",
             params: { category: this.masterlist_category, type: type },
          })
            .then((response) => {
              let blob = new Blob([response.data], {
                type: "application/excel",
              });
              let link = document.createElement("a");
              link.href = window.URL.createObjectURL(blob);
              link.download = "masterlist.xlsx";
              link.click();
            });

          break;
        default:
          break;
      }
    }, 
  async getPDF_Incoming_supplies(type) {
      switch (type) {
        case "pdf":
          await axios({
            url: "/api/reports/incoming/supplies/get",
            method: "GET",
            responseType: "blob",
           params: {  type: type, category: this.incoming_category, from: this.incoming_from, to: this.incoming_to },
          }).then((response) => {
            console.log(response.data)
            let blob = new Blob([response.data], { type: "application/pdf" });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = "data.pdf";
            link.click();
          });
          break;
        case "excel":
          await axios
            .get("/api/reports/incoming/supplies/get", {
              method: "GET",
              responseType: "arraybuffer",
             params: {  type: type, category: this.incoming_category, from: this.incoming_from, to: this.incoming_to },
          })
            .then((response) => {
              let blob = new Blob([response.data], {
                type: "application/excel",
              });
              let link = document.createElement("a");
              link.href = window.URL.createObjectURL(blob);
              link.download = "masterlist.xlsx";
              link.click();
            });

          break;
        default:
          break;
      }
    }, 
  async getPDF_Outgoing(type) {
      switch (type) {
        case "pdf":
          await axios({
            url: "/api/reports/outgoing/supplies/get",
            method: "GET",
            responseType: "blob",
            params: { type: type, branch: this.outgoing_branch, category: this.outgoing_category, from: this.outgoing_from, to: this.outgoing_to },
          }).then((response) => {
            console.log(response.data)
            let blob = new Blob([response.data], { type: "application/pdf" });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = "data.pdf";
            link.click();
          });
          break;
        case "excel":
          await axios
            .get("/api/reports/outgoing/supplies/get", {
              method: "GET",
              responseType: "arraybuffer",
             params: { type: type, branch: this.outgoing_branch, category: this.outgoing_category, from: this.outgoing_from, to: this.outgoing_to },
            })
            .then((response) => {
              let blob = new Blob([response.data], {
                type: "application/excel",
              });
              let link = document.createElement("a");
              link.href = window.URL.createObjectURL(blob);
              link.download = "mastelist.xlsx";
              link.click();
            });

          break;
        default:
          break;
      }
    }, 
  async getPDF_Main(type) {
      switch (type) {
        case "pdf":
          await axios({
            url: "/api/reports/main/get",
            method: "GET",
            responseType: "blob",
            params: { category: this.main_category, type: type },
          }).then((response) => {
            console.log(response.data)
            let blob = new Blob([response.data], { type: "application/pdf" });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = "data.pdf";
            link.click();
          });
          break;
        case "excel":
          await axios
            .get("/api/reports/main/get", {
              method: "GET",
              responseType: "arraybuffer",
            params: { category: this.main_category, type: type },
            })
            .then((response) => {
              let blob = new Blob([response.data], {
                type: "application/excel",
              });
              let link = document.createElement("a");
              link.href = window.URL.createObjectURL(blob);
              link.download = "masterlist.xlsx";
              link.click();
            });

          break;
        default:
          break;
      }
    }, 
  async getPDF_Inventory_summary(type) {
      switch (type) {
        case "pdf":
          await axios({
            url: "/api/reports/inventory/summary/get",
            method: "GET",
            responseType: "blob",
            params: {  type: type },
          }).then((response) => {
            let blob = new Blob([response.data], { type: "application/pdf" });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = "data.pdf";
            link.click();
          });
          break;
        case "excel":
          await axios
            .get("/api/reports/inventory/summary/get", {
              method: "GET",
              responseType: "arraybuffer",
              params: {  type: type },
            })
            .then((response) => {
              let blob = new Blob([response.data], {
                type: "application/excel",
              });
              let link = document.createElement("a");
              link.href = window.URL.createObjectURL(blob);
              link.download = "masterlist.xlsx";
              link.click();
            });

          break;
        default:
          break;
      }
    },


















    itemperpage2() {
      this.page2 = 1;
      this.getTransactionReport();
    },

 
    async getSalesReport() {
      this.progressbar = true; // Show the progress bar
      // Get data from tables
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;
      await axios
        .get("/api/sales_report", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
            branch: this.branch,
            category: this.category,
            dateFrom: this.dateFrom,
            dateUntil: this.dateUntil,
          },
        })
        .then((result) => {
          // If the value is true then get the data
          this.table1 = result.data;
          this.progressbar = false; // Hide the progress bar
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    async getTransactionReport() {
      this.progressbar = true; // Show the progress bar
      // Get data from tables
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;
      await axios
        .get("/api/transaction_report", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
            branch: this.branch,
            category: this.category,
            dateFrom: this.dateFrom,
            dateUntil: this.dateUntil,
          },
        })
        .then((result) => {
          // If the value is true then get the data
          this.table2 = result.data;
          this.progressbar = false; // Hide the progress bar
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    async getPO(type) {
      switch (type) {
        case "pdf":
          await axios({
            url: "/api/po",
            method: "GET",
            responseType: "blob", //nicocoment ito para makita mo ung laman
            //pero pag ppdf mo na need mo uncomment yaan
            params: { from: this.dateFromPO, to: this.dateUntilPO, type: type }, //wag mo aalisin ung type:type, jan ni checheck kung pdf or excel
          }).then((response) => {
            let blob = new Blob([response.data], { type: "application/pdf" });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = "Purchase Order Report.pdf";
            link.click();
          });
          break;
        case "excel":
          await axios
            .get("/api/po", {
              method: "GET",
              responseType: "arraybuffer",
              params: {
                from: this.dateFromPO,
                to: this.dateUntilPO,
                type: type,
              },
            })
            .then((response) => {
              let blob = new Blob([response.data], {
                type: "application/excel",
              });
              let link = document.createElement("a");
              link.href = window.URL.createObjectURL(blob);
              link.download = "Purchase Order Report.xlsx";
              link.click();
            });

          break;
        default:
          break;
      }
    },

    async prodCat() {
      await axios.get("/api/outprod/prodCat").then((prod_cat) => {
        this.prodcatlist = prod_cat.data;
      });
    },

    async suppCat() {
      await axios.get("/api/msupp/suppCat").then((supp_cat) => {
        this.suppcatlist = supp_cat.data;
      });
    },

    async branchName() {
      await axios.get("/api/osupp/branchName").then((bran_name) => {
        this.branchlist = bran_name.data;
      });
    },
  },

  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
    height() {
      switch (this.$vuetify.breakpoint.name) {
        case "xs":
          return 35;
        default:
          return 42;
      }
    },
  },
};
</script>