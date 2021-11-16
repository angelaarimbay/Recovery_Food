<template>
  <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
    <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
      <!-- Progress Circular -->
      <v-overlay :value="overlay">
        <v-progress-circular size="55" color="red darken-2" indeterminate>
        </v-progress-circular>
      </v-overlay>
      <!-- Snackbar -->
      <v-snackbar
        :vertical="$vuetify.breakpoint.xsOnly"
        min-width="auto"
        v-model="snackbar.active"
        timeout="2500"
        class="text-center pb-0"
        :left="$vuetify.breakpoint.smAndUp"
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

      <v-card-actions class="px-0 justify-center">
        <v-tooltip bottom>
          <template #activator="data">
            <v-btn
              dark
              color="red accent-4"
              class="mx-1"
              v-on="data.on"
              @click="get('pdf')"
              :small="$vuetify.breakpoint.smAndDown"
              ><v-icon>mdi-file-pdf</v-icon></v-btn
            >
          </template>
          <span>Export to PDF</span>
        </v-tooltip>
        <v-tooltip bottom>
          <template #activator="data">
            <v-btn
              dark
              color="green darken-4"
              class="mx-1"
              v-on="data.on"
              @click="get('excel')"
              :small="$vuetify.breakpoint.smAndDown"
              ><v-icon>mdi-file-excel</v-icon></v-btn
            >
          </template>
          <span>Export to Excel</span>
        </v-tooltip>
        <v-tooltip bottom>
          <template #activator="data">
            <v-btn
              dark
              color="blue-grey darken-1"
              class="mx-1"
              @click="get('print')"
              v-on="data.on"
              :small="$vuetify.breakpoint.smAndDown"
              ><v-icon>mdi-printer</v-icon></v-btn
            >
          </template>
          <span>Print</span>
        </v-tooltip></v-card-actions
      >
      <v-row no-gutters>
        <v-spacer></v-spacer>
        <v-tooltip bottom>
          <template #activator="data">
            <v-btn
              class="mr-2 mb-3"
              color="success"
              style="text-transform: none"
              depressed
              :small="$vuetify.breakpoint.smAndDown"
              dark
              @click="getTransactionReport"
              v-on="data.on"
              icon
              ><v-icon>mdi-refresh</v-icon></v-btn
            >
          </template>
          <span>Refresh</span>
        </v-tooltip>
        <v-tooltip bottom>
          <template #activator="data">
            <v-btn
              color="grey darken-4"
              style="text-transform: none"
              depressed
              :small="$vuetify.breakpoint.smAndDown"
              dark
              @click="filterDialog = true"
              v-on="data.on"
              icon
              ><v-icon>mdi-filter-variant</v-icon></v-btn
            >
          </template>
          <span>Filter</span>
        </v-tooltip>
      </v-row>

      <!-- Filter Dialog -->
      <v-dialog v-model="filterDialog" max-width="400px">
        <v-card dark tile class="pa-2">
          <v-toolbar dense flat class="transparent">
            Search Filter
            <v-spacer></v-spacer>
            <v-icon text @click="filterDialog = false">mdi-close </v-icon>
          </v-toolbar>
          <v-divider class="my-0"></v-divider>
          <v-row no-gutters align="center" class="pa-2">
            <!-- Items Per Page -->
            <v-col cols="4"
              ><span class="text-caption text-xl-subtitle-2"
                >Items / Page</span
              ></v-col
            >
            <v-col cols="8">
              <v-card-actions class="px-0">
                <v-select
                  dense
                  v-model="itemsPerPage"
                  @change="itemperpage"
                  :items="[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15]"
                  hide-details
                  background-color="grey darken-3"
                  flat
                  solo
                  style="font-size: 12px"
                >
                </v-select>
              </v-card-actions>
            </v-col>

            <!-- Search Field -->
            <v-col cols="4"
              ><span class="text-caption text-xl-subtitle-2"
                >Search</span
              ></v-col
            >
            <v-col cols="8">
              <v-card-actions class="px-0">
                <v-text-field
                  v-model="search"
                  placeholder="Reference No."
                  single-line
                  dense
                  clearable
                  hide-details
                  background-color="grey darken-3"
                  flat
                  solo
                  style="font-size: 12px"
                ></v-text-field>
                <v-tooltip bottom>
                  <template #activator="data">
                    <v-btn
                      small
                      :x-small="$vuetify.breakpoint.smAndDown"
                      color="red darken-2"
                      icon
                      v-on="data.on"
                      @click="getTransactionReport"
                      class="ml-1"
                    >
                      <v-icon>mdi-magnify</v-icon></v-btn
                    >
                  </template>
                  <span>Search</span>
                </v-tooltip>
              </v-card-actions>
            </v-col>

            <!-- Branch Field -->
            <v-col cols="4"
              ><span class="text-caption text-xl-subtitle-2"
                >Branch</span
              ></v-col
            >
            <v-col cols="8">
              <v-card-actions class="px-0">
                <v-select
                  hide-details
                  :items="branchlist"
                  item-text="branch_name"
                  item-value="id"
                  clearable
                  v-model="branch"
                  dense
                  @change="getTransactionReport"
                  placeholder="Branch"
                  background-color="grey darken-3"
                  flat
                  solo
                  style="font-size: 12px"
                >
                </v-select>
              </v-card-actions>
            </v-col>

            <!-- Date Picker -->
            <v-col cols="4"
              ><span class="text-caption text-xl-subtitle-2"
                >Date From</span
              ></v-col
            >
            <v-col cols="8">
              <v-menu
                v-model="date1"
                :close-on-content-click="false"
                :nudge-right="35"
                lazy
                transition="scale-transition"
                offset-y
                full-width
                min-width="290px"
              >
                <template v-slot:activator="{ on }">
                  <v-card-actions class="px-0">
                    <v-text-field
                      hide-details
                      v-model="dateFromTP"
                      placeholder="Date From"
                      prepend-inner-icon="mdi-calendar-range"
                      readonly
                      v-on="on"
                      dense
                      clearable
                      background-color="grey darken-3"
                      flat
                      solo
                      style="font-size: 12px"
                    ></v-text-field>
                  </v-card-actions>
                </template>
                <v-date-picker
                  v-model="dateFromTP"
                  @input="date1 = false"
                  scrollable
                  no-title
                  color="red darken-2"
                  dark
                  @change="getTransactionReport"
                ></v-date-picker>
              </v-menu>
            </v-col>

            <!-- Date Picker -->
            <v-col cols="4"
              ><span class="text-caption text-xl-subtitle-2"
                >Date Until</span
              ></v-col
            >
            <v-col cols="8">
              <v-menu
                v-model="date2"
                :close-on-content-click="false"
                :nudge-right="35"
                lazy
                transition="scale-transition"
                offset-y
                full-width
                min-width="290px"
              >
                <template v-slot:activator="{ on }">
                  <v-card-actions class="px-0">
                    <v-text-field
                      hide-details
                      v-model="dateUntilTP"
                      placeholder="Date Until"
                      prepend-inner-icon="mdi-calendar-range"
                      readonly
                      v-on="on"
                      dense
                      clearable
                      background-color="grey darken-3"
                      flat
                      solo
                      style="font-size: 12px"
                    ></v-text-field>
                  </v-card-actions>
                </template>
                <v-date-picker
                  v-model="dateUntilTP"
                  @input="date2 = false"
                  scrollable
                  no-title
                  color="red darken-2"
                  dark
                  @change="getTransactionReport"
                ></v-date-picker>
              </v-menu>
            </v-col>
          </v-row>
        </v-card>
      </v-dialog>
    </v-container>

    <!-- Table -->
    <v-data-table
      id="table1"
      :headers="headers"
      :items="table.data"
      :loading="progressbar"
      :page.sync="page"
      ref="progress"
      :items-per-page="itemsPerPage"
      hide-default-footer
      @page-count="pageCount = $event"
      class="table-striped border"
    >
      <!-- Progress Bar -->
      <v-progress-linear
        color="red darken-2"
        class="px-0 mx-0"
        slot="progress"
        indeterminate
        rounded
      ></v-progress-linear>
      <template v-slot:[`item.outgoing_date`]="{ item }">
        {{ getFormatDate(item.outgoing_date, "YYYY-MM-DD") }}</template
      >
      <template v-slot:[`item.count`]="{ item }"> {{ item.row }}</template>

      <template v-slot:[`item.id`]="{ item }">
        <v-btn
          icon
          color="red darken-2"
          @click="getTPInfo(item)"
          :x-small="$vuetify.breakpoint.smAndDown"
        >
          <v-icon>mdi-eye</v-icon>
        </v-btn>
      </template>
    </v-data-table>

    <!-- Paginate -->
    <div class="pbutton text-center pt-2">
      <v-pagination
        v-model="page"
        :total-visible="7"
        :length="table.last_page"
        color="red darken-2"
      ></v-pagination>
    </div>

    <!-- View Transaction Report Info Form -->
    <v-dialog v-model="viewdialog" max-width="900px">
      <v-card tile class="pa-3">
        <v-toolbar dark dense flat rounded class="red darken-3">
          Transaction Report Info
          <v-spacer></v-spacer>
          <v-icon text @click="closeViewDialog">mdi-close </v-icon>
        </v-toolbar>
        <v-card-text class="px-0">
          <v-card-text>
            <div v-if="table2.length > 0">
              <v-row no-gutters>
                <v-col cols="12" xl="6" lg="6" md="6" sm="12" class="pb-2">
                  Reference No: <strong>{{ table2[0]["reference_no"] }}</strong>
                  <br />
                  Bill Total:
                  <strong>{{ sales_var }} </strong>
                </v-col>
                <v-spacer></v-spacer>
                <v-col
                  cols="12"
                  xl="6"
                  lg="6"
                  md="6"
                  sm="12"
                  class="pb-2"
                  :class="{ 'text-right': $vuetify.breakpoint.smAndUp }"
                >
                  Branch:
                  <strong>{{ table2[0]["branch"]["branch_name"] }}</strong>
                  <br />
                  Date:
                  <strong>{{
                    getFormatDate(table2[0]["created_at"], "YYYY-MM-DD")
                  }}</strong></v-col
                >
              </v-row>

              <v-row no-gutters>
                <v-col class="pb-2" cols="12" xl="6" lg="6" md="6" sm="12">
                  Payment: <strong>{{ table2[0]["payment"] }}</strong
                  ><br />
                  Discount: <strong>{{ table2[0]["discount"] }}%</strong><br />
                  Change: <strong>{{ table2[0]["change"] }}</strong>
                </v-col>
                <v-spacer></v-spacer>
                <v-col
                  cols="12"
                  xl="6"
                  lg="6"
                  md="6"
                  sm="12"
                  class="pb-2"
                  :class="{ 'text-right': $vuetify.breakpoint.smAndUp }"
                >
                  Mode: <strong>{{ table2[0]["mode"] }}</strong
                  ><br />
                  Cashier: <strong>{{ table2[0]["cashier"]["name"] }}</strong>
                </v-col>
              </v-row>
            </div>
          </v-card-text>

          <!-- Table -->
          <v-data-table
            id="table1"
            dense
            class="px-4 table-striped border"
            :items-per-page="5"
            :loading="progressbar"
            :headers="headers2"
            :items="table2"
            hide-default-footer
          >
            <template v-slot:[`item.product_name.price`]="{ item }"
              >{{ getFormatCurrency(item.product_name.price, "0,0.00") }}
            </template>

            <template v-slot:[`item.product_name.product_name`]="{ item }"
              >{{ item.product_name.product_name }}
              {{ item.product_name.description }}</template
            >
            <template v-slot:[`item.created_at`]="{ item }">
              {{ getFormatDate(item.created_at, "YYYY-MM-DD") }}</template
            >
            <v-progress-linear
              v-show="progressbar"
              slot="progress"
              color="red darken-2"
              indeterminate
            ></v-progress-linear>
          </v-data-table>
        </v-card-text>
        <v-divider class="my-0"></v-divider>
        <!-- Dialog Form Buttons -->
        <v-card-actions class="px-0 pb-0">
          <v-spacer></v-spacer>
          <v-btn
            color="error"
            :small="$vuetify.breakpoint.smAndDown"
            depressed
            dark
            @click="closeViewDialog"
            text
          >
            Close
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <iframe id="print7" class="d-none" :src="print" frameborder="0"></iframe>
  </v-container>
</template>

<style>
#table1 .v-data-table-header th {
  white-space: nowrap;
}
#table1 .v-data-table-header th {
  font-size: 12px !important;
}
#table1 td {
  font-size: 12px !important;
}

.pbutton .v-pagination button {
  background-color: #212121 !important;
  color: #ffffff !important;
}
.pbutton .v-pagination i.v-icon.v-icon {
  color: #ffffff !important;
}
.pbutton .v-pagination__navigation:disabled {
  background-color: #000000 !important;
}

.v-list-item__content {
  color: white !important;
}
.v-menu__content.theme--light .v-list {
  background: #212121 !important;
}
.theme--light.v-list-item:hover:before {
  opacity: 0.2 !important;
}
</style>

<script>
import axios from "axios"; // Library for sending api request
export default {
  data: () => ({
    progressbar: false,
    snackbar: {
      active: false,
      message: "",
    },
    branch: "",
    print: "",
    search: "",
    reference_no: "",
    prodcatlist: [],
    table: [],
    table2: [],
    branchlist: [],
    sales_var: "",
    filterDialog: false,
    viewdialog: false,
    date1: false,
    date2: false,
    overlay: false,
    dateFromTP: null,
    dateUntilTP: null,
    page: 1,
    pageCount: 0,
    itemsPerPage: 5,
    // Table Headers TP
    headers: [
      {
        text: "#",
        value: "count",
        align: "start",
        filterable: false,
        class: "black--text",
      },
      {
        text: "BRANCH",
        value: "branch_name",
        filterable: false,
        class: "black--text",
      },
      {
        text: "DATE",
        value: "created_at",
        filterable: false,
        class: "black--text",
      },
      {
        text: "REFERENCE NO.",
        value: "reference_no",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "TOTAL PRODUCT(S)",
        value: "quantity",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "TOTAL AMT",
        value: "sub_total_discounted",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "ACTION",
        value: "id",
        align: "center",
        sortable: false,
        filterable: false,
        class: "black--text",
      },
    ],

    // View Dialog Headers
    headers2: [
      {
        text: "PRODUCT(S)",
        value: "product_name.product_name",
        filterable: false,
        class: "black--text",
      },
      {
        text: "UNIT PRICE",
        value: "product_name.price",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "QTY",
        value: "quantity",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "TOTAL PRICE",
        value: "total_amount",
        align: "right",
        filterable: false,
        class: "black--text",
      },
    ],
  }),

  created() {
    this.dateFromTP = this.getFormatDate(
      new Date(new Date().getFullYear(), new Date().getMonth(), 1),
      "YYYY-MM-DD"
    );
    this.dateUntilTP = this.getFormatDate(
      new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0),
      "YYYY-MM-DD"
    );
    this.getTransactionReport();
    this.branchName();
  },
  methods: {
    async getTransactionReport() {
      this.progressbar = true;
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;
      await axios({
        url: "/api/sales_report/list",
        method: "GET",
        params: {
          page: this.page,
          itemsPerPage: this.itemsPerPage,
          search: this.search,
          branch: this.branch,
          dateFromSP: this.dateFromTP,
          dateUntilSP: this.dateUntilTP,
        },
      }).then((response) => {
        this.table = response.data;
        this.progressbar = false;
      });
    },

    getFormatDate(e, format) {
      const date = moment(e);
      return date.format(format);
    },

    async getTPInfo(item) {
      this.viewdialog = true;
      this.progressbar = true;
      await axios("/api/sales_report/info", {
        params: { reference_no: item.reference_no },
      }).then((result) => {
        this.table2 = result.data;
        this.sales_var = numeral(
          this.table2.reduce((a, b) => a + b.sub_total_discounted, 0)
        ).format("0,0.00");
        this.progressbar = false;
      });
    },

    async branchName() {
      await axios.get("/api/osupp/branchName").then((bran_name) => {
        this.branchlist = bran_name.data;
      });
    },
    getFormatCurrency(e, format) {
      const numbr = numeral(e);
      return numbr.format(format);
    },
    async get(type) {
      if (
        this.branch == "" ||
        this.dateFromTP == null ||
        this.dateUntilTP == null
      ) {
        this.snackbar = {
          active: true,
          iconText: "alert",
          iconColor: "error",
          message: "Error! Please complete the fields first.",
        };
      } else {
        this.overlay = true;
        switch (type) {
          case "pdf":
            await axios({
              url: "/api/reports/transaction/get",
              method: "GET",
              responseType: "blob",
              params: {
                branch: this.branch,
                from: this.dateFromTP,
                to: this.dateUntilTP,
                type: type,
              },
            }).then((response) => {
              if (response.data.size > 0) {
                let blob = new Blob([response.data], {
                  type: "application/pdf",
                });
                let link = document.createElement("a");
                link.href = window.URL.createObjectURL(blob);
                link.download = "Transaction Report.pdf";
                link.click();
              } else {
                this.snackbar = {
                  active: true,
                  iconText: "alert-box",
                  iconColor: "warning",
                  message: "Nothing to export.",
                };
              }
            });
            break;
          case "excel":
            await axios({
              url: "/api/reports/transaction/get",
              method: "GET",
              responseType: "blob",
              params: {
                branch: this.branch,
                from: this.dateFromTP,
                to: this.dateUntilTP,
                type: "pdf",
              },
            }).then((response) => {
              if (response.data.size > 0) {
                axios
                  .get("/api/reports/transaction/get", {
                    method: "GET",
                    responseType: "arraybuffer",
                    params: {
                      branch: this.branch,
                      from: this.dateFromTP,
                      to: this.dateUntilTP,
                      type: type,
                    },
                  })
                  .then((res) => {
                    let blob = new Blob([res.data], {
                      type: "application/excel",
                    });
                    let link = document.createElement("a");
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "Transaction Report.xlsx";
                    link.click();
                  });
              } else {
                this.snackbar = {
                  active: true,
                  iconText: "alert-box",
                  iconColor: "warning",
                  message: "Nothing to export.",
                };
              }
            });
            break;
          case "print":
            await axios({
              url: "/api/reports/transaction/get",
              method: "GET",
              responseType: "blob",
              params: {
                branch: this.branch,
                from: this.dateFromTP,
                to: this.dateUntilTP,
                type: "pdf",
              },
            }).then((response) => {
              if (response.data.size > 0) {
                let blob = new Blob([response.data], {
                  type: "application/pdf",
                });
                this.print = window.URL.createObjectURL(blob);
                this.snackbar = {
                  active: true,
                  iconText: "information",
                  iconColor: "primary",
                  message: "Printing... Please wait.",
                };
                setTimeout(function () {
                  document.getElementById("print7").contentWindow.print();
                }, 3000);
              } else {
                this.snackbar = {
                  active: true,
                  iconText: "alert-box",
                  iconColor: "warning",
                  message: "Nothing to print.",
                };
              }
            });
            break;
          default:
            break;
        }
        this.overlay = false;
      }
    },

    itemperpage() {
      this.page = 1;
      this.getTransactionReport();
    },

    // Close View Dialog
    closeViewDialog() {
      this.viewdialog = false;
    },
  },
  watch: {
    viewdialog(val) {
      val || this.closeViewDialog();
    },
    page(val) {
      this.page = val;
      this.getTransactionReport();
    },
    id: {
      handler: function (v) {},
    },
  },
};
</script>