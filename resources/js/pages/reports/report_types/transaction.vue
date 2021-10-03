<template>
  <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
    <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
      <v-card-actions class="px-0 justify-center">
        <v-tooltip bottom>
          <template #activator="data">
            <v-btn
              color="primary"
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
              color="primary"
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
              color="primary"
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
        <!-- Items Per Page -->
        <v-col cols="4" xl="2" lg="2" md="3" sm="4" class="my-auto">
          <v-card-actions>
            <v-select
              style="max-width: 82px"
              dense
              v-model="itemsPerPage"
              label="Items per page"
              @change="itemperpage"
              :items="[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15]"
            >
            </v-select>
          </v-card-actions>
        </v-col>

        <v-spacer></v-spacer>

        <!-- Search Field -->
        <v-col
          cols="8"
          xl="4"
          lg="4"
          md="6"
          sm="8"
          style="max-width: 230px"
          class="my-auto"
        >
          <v-card-actions>
            <v-text-field
              v-model="search"
              label="Reference No."
              single-line
              dense
              clearable
            ></v-text-field>
            <v-tooltip bottom>
              <template #activator="data">
                <v-btn
                  :small="$vuetify.breakpoint.smAndDown"
                  :large="$vuetify.breakpoint.mdAndUp"
                  color="red darken-2"
                  icon
                  v-on="data.on"
                  @click="getTransactionReport"
                  class="mb-3"
                >
                  <v-icon>mdi-magnify</v-icon></v-btn
                >
              </template>
              <span>Search</span>
            </v-tooltip>
          </v-card-actions>
        </v-col>
      </v-row>

      <v-row no-gutters>
        <!-- Branch Field -->
        <v-col cols="6" xl="2" lg="2" md="3" sm="6" class="my-auto">
          <v-card-actions class="py-0">
            <v-select
              :items="branchlist"
              item-text="branch_name"
              item-value="id"
              class="my-0"
              clearable
              v-model="branch"
              dense
              @change="getTransactionReport"
              label="Branch"
            >
            </v-select>
          </v-card-actions>
        </v-col>

        <v-spacer></v-spacer>

        <!-- Date Picker -->
        <v-col cols="6" xl="2" lg="3" md="3" sm="6" class="my-auto">
          <v-card-actions class="py-0">
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
                <v-text-field
                  v-model="dateFromTP"
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
                v-model="dateFromTP"
                @input="date1 = false"
                scrollable
                no-title
                color="red darken-2"
                dark
                @change="getTransactionReport"
              ></v-date-picker>
            </v-menu>
          </v-card-actions>
        </v-col>

        <v-col cols="6" xl="2" lg="3" md="3" sm="6" class="my-auto">
          <v-card-actions class="py-0">
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
                <v-text-field
                  v-model="dateUntilTP"
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
                v-model="dateUntilTP"
                @input="date2 = false"
                scrollable
                no-title
                color="red darken-2"
                dark
                @change="getTransactionReport"
              ></v-date-picker>
            </v-menu>
          </v-card-actions>
        </v-col>
      </v-row>
    </v-container>

    <!-- Table -->
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
    <div class="text-center pt-2">
      <v-pagination
        v-model="page"
        :total-visible="5"
        :length="table.last_page"
        color="red darken-2"
      ></v-pagination>
    </div>

    <!-- Add User To Role Dialog -->
    <v-dialog v-model="viewdialog" max-width="900px">
      <v-card id="dialog" class="bgcolor">
        <v-toolbar
          dense
          dark
          class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
        >
          Sales Report Info
          <v-spacer></v-spacer>
          <v-tooltip bottom>
            <template #activator="data">
              <v-icon
                class="mr-xl-4 mr-lg-4 mr-md-4 mr-sm-3 mr-1"
                v-on="data.on"
                text
                @click="closeViewDialog"
                >mdi-close
              </v-icon>
            </template>
            <span>Close</span>
          </v-tooltip>
        </v-toolbar>

        <v-card tile>
          <v-card-text class="py-2">
            <v-card-text>
              <div v-if="table2.length > 0">
                <strong> Reference No: {{ table2[0]["reference_no"] }}</strong>
                <v-spacer></v-spacer>
                <strong>
                  Bill Total:
                  {{ sales_var }}
                </strong>
                <br />

                <v-card-actions>
                  Branch: {{ table2[0]["branch"]["branch_name"] }}<br />
                  Date/Time:
                  {{ getFormatDate(table2[0]["created_at"], "YYYY-MM-DD")
                  }}<br />
                  <v-spacer></v-spacer>
                  Mode: {{ table2[0]["mode"] }} <br />
                  Cashier: {{ table2[0]["cashier"]["name"] }}
                </v-card-actions>

                <v-card-actions>
                    Payment: {{ table2[0]["payment"] }} <br/>
                    Discount: {{ table2[0]["discount"] }} <br/>
                    Change: {{ table2[0]["change"] }} <br/>
                </v-card-actions>
              </div>
            </v-card-text>

            <!-- Table -->
            <v-data-table
              dense
              class="px-4"
              :items-per-page="5"
              :loading="progressbar"
              :headers="headers2"
              :items="table2"
              hide-default-footer
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

          <v-card-actions class="px-xl-9 px-lg-9 px-md-8 px-sm-6 px-6 py-4">
            <v-spacer></v-spacer>
            <v-btn
              color="error"
              style="text-transform: none"
              :small="$vuetify.breakpoint.smAndDown"
              depressed
              dark
              @click="closeViewDialog"
            >
              Close
            </v-btn>
            <v-btn
              color="#00794b"
              style="text-transform: none"
              :small="$vuetify.breakpoint.smAndDown"
              depressed
              dark
            >
              Print
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import axios from "axios"; // Library for sending api request
export default {
  data: () => ({
    progressbar: false,
    category: "",
    branch: "",
    search: "",
    reference_no: "",
    prodcatlist: [],
    table: [],
    table2: [],
    branchlist: [],
    sales_var: "",
    viewdialog: false,
    date1: false,
    date2: false,
    dateFromTP: null,
    dateUntilTP: null,
    page: 1,
    pageCount: 0,
    itemsPerPage: 5,
    // Table Headers TP
    headers: [
      { text: "#", value: "count", align: "start", filterable: false },
      {
        text: "Branch",
        value: "branch_name",
        filterable: false,
      },
      { text: "Date & Time", value: "created_at", align: "right" },
      {
        text: "Reference No.",
        value: "reference_no",
        align: "right",
        filterable: false,
      },
      {
        text: "Total Product(s)",
        value: "quantity",
        align: "right",
        filterable: false,
      },
      {
        text: "Total Amount",
        value: "sub_total_discounted",
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

    // View Dialog Headers
    headers2: [
      {
        text: "Product(s)",
        value: "product_name.product_name",
        filterable: false,
      },
            {
        text: "Unit Price",
        value: "product_name.format_unit_price",
        align: "right",
        filterable: false,
      },
      {
        text: "Qty",
        value: "quantity",
        align: "right",
        filterable: false,
      },
      {
        text: "Total Price",
        value: "total_amount",
        align: "right",
        filterable: false,
      },
    ],
  }),

  created() {
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
          console.log(response.data)
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

    async get(type) {
      switch (type) {
        case "pdf":
          await axios({
            url: "/api/sales_report",
            method: "GET",
            responseType: "blob",
            params: { category: this.category, type: type },
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
            .get("/api/sales_report", {
              method: "GET",
              responseType: "arraybuffer",
              params: {
                category: this.category,
                type: type,
              },
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