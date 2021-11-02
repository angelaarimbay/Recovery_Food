<template>
  <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
    <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
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

      <v-dialog v-model="dialog1">
        <v-toolbar
          dense
          dark
          class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
        >
          Preview Receipt
          <v-spacer></v-spacer>
          <v-tooltip bottom>
            <template #activator="data">
              <v-icon
                class="mr-xl-4 mr-lg-4 mr-md-4 mr-sm-3 mr-1"
                v-on="data.on"
                text
                @click="dialog1 = false"
                >mdi-close
              </v-icon>
            </template>
            <span>Close</span>
          </v-tooltip>
        </v-toolbar>
        <iframe :src="pdfview" width="100%" height="500"></iframe>
      </v-dialog>

      <v-card-actions
        class="px-0 justify-center"
        v-if="!this.user.permissionslist.includes('Access POS')"
      >
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
                  @click="getSalesReport"
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

      <v-row
        no-gutters
        v-if="!this.user.permissionslist.includes('Access POS')"
      >
        <!-- Branch Field -->
        <v-col cols="12" xl="2" lg="2" md="3" sm="12" class="my-auto">
          <v-card-actions class="py-0">
            <v-select
              :items="branchlist"
              item-text="branch_name"
              item-value="id"
              class="my-0"
              clearable
              v-model="branch"
              dense
              @change="getSalesReport"
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
                  v-model="dateFromSP"
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
                v-model="dateFromSP"
                @input="date1 = false"
                scrollable
                no-title
                color="red darken-2"
                dark
                @change="getSalesReport"
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
                  v-model="dateUntilSP"
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
                v-model="dateUntilSP"
                @input="date2 = false"
                scrollable
                no-title
                color="red darken-2"
                dark
                @change="getSalesReport"
              ></v-date-picker>
            </v-menu>
          </v-card-actions>
        </v-col>
      </v-row>
    </v-container>

    <!-- Table -->
    <v-data-table
      :headers="myheaders"
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
          @click="getSPInfo(item)"
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
        :total-visible="7"
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
                  Sales Amount:
                  {{ sales_var }}
                </strong>
                <br />

                <v-card-actions>
                  Branch: {{ table2[0]["branch"]["branch_name"] }}<br />
                  Date:
                  {{ getFormatDate(table2[0]["created_at"], "YYYY-MM-DD")
                  }}<br />
                  <!-- <v-spacer></v-spacer>
                  Mode: {{ table2[0]["mode"] }} <br />
                  Cashier: {{ table2[0]["cashier"]["name"] }} -->
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
              <template v-slot:[`item.product_full`]="{ item }"
                >{{ item.product_name.product_name }}
                {{ item.product_name.description }}</template
              >
              <template v-slot:[`item.product_name.price`]="{ item }">
                {{
                  getFormatCurrency(item.product_name.price, "0,0.00")
                }}</template
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
              @click="getReceipt(table2[0]['reference_no'])"
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
    <iframe id="print6" class="d-none" :src="print" frameborder="0"></iframe>
  </v-container>
</template>
<style>
iframe:focus {
  outline: none;
}

iframe[seamless] {
  display: block;
}
</style>
<script>
import { mapGetters } from "vuex";
import axios from "axios"; // Library for sending api request
export default {
  data: () => ({
    progressbar: false,
    snackbar: {
      active: false,
      message: "",
    },
    print: "",
    branch: "",
    search: "",
    reference_no: "",
    prodcatlist: [],
    table: [],
    dialog1: false,
    pdfview: "",
    table2: [],
    branchlist: [],
    sales_var: "",
    viewdialog: false,
    date1: false,
    date2: false,
    dateFromSP: null,
    dateUntilSP: null,
    page: 1,
    pageCount: 0,
    itemsPerPage: 5,
    // Table Headers SP
    headers: [
      {
        text: "#",
        value: "count",
        sortable: true,
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
        class: "black--text",
      },
      {
        text: "SALES AMOUNT",
        value: "sub_total_discounted",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "ACTION(S)",
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
        value: "product_full",
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
    this.getSalesReport();
    this.branchName();

    for (var key in this.user.permissionslist) {
      if (this.user.permissionslist[key] == "Access POS") {
        this.headers.splice(this.headers.indexOf(this.headers[1]), 1);
      }
    }
  },

  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
    myheaders() {
      return this.headers.filter((s) => this.headers.includes(s));
    },
  },
  methods: {
    async getReceipt(reference_no) {
      await axios({
        url: "/api/pos/receipt",
        method: "GET",
        responseType: "blob",
        params: { reference_no: reference_no },
      }).then((response) => {
        let blob = new Blob([response.data], { type: "application/pdf" });

        this.pdfview = window.URL.createObjectURL(blob);
        this.viewdialog = false;
        this.dialog1 = true;
      });
    },

    async getSalesReport() {
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
          dateFromSP: this.dateFromSP,
          dateUntilSP: this.dateUntilSP,
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
    getFormatCurrency(e, format) {
      const numbr = numeral(e);
      return numbr.format(format);
    },

    async getSPInfo(item) {
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
      if (
        this.branch == "" ||
        this.dateFromSP == null ||
        this.dateUntilSP == null
      ) {
        this.snackbar = {
          active: true,
          iconText: "alert",
          iconColor: "error",
          message: "Error! Please complete the fields first.",
        };
      } else {
        switch (type) {
          case "pdf":
            await axios({
              url: "/api/reports/sales/get",
              method: "GET",
              responseType: "blob",
              params: {
                branch: this.branch,
                from: this.dateFromSP,
                to: this.dateUntilSP,
                type: type,
              },
            }).then((response) => {
              // console.log(response.data);
              // return;
              let blob = new Blob([response.data], { type: "application/pdf" });
              let link = document.createElement("a");
              link.href = window.URL.createObjectURL(blob);
              link.download = "Sales Report.pdf";
              link.click();
            });
            break;
          case "print":
            await axios({
              url: "/api/reports/sales/get",
              method: "GET",
              responseType: "blob",
              params: {
                branch: this.branch,
                from: this.dateFromSP,
                to: this.dateUntilSP,
                type: "pdf",
              },
            }).then((response) => {
              // console.log(response.data);
              // return;
              let blob = new Blob([response.data], { type: "application/pdf" });
              this.print = window.URL.createObjectURL(blob);
              this.snackbar = {
                active: true,
                iconText: "information",
                iconColor: "primary",
                message: "Printing... Please wait.",
              };
              setTimeout(function () {
                document.getElementById("print6").contentWindow.print();
              }, 3000);
            });
            break;

          case "excel":
            await axios
              .get("/api/reports/sales/get", {
                method: "GET",
                responseType: "arraybuffer",
                params: {
                  branch: this.branch,
                  from: this.dateFromSP,
                  to: this.dateUntilSP,
                  type: type,
                },
              })
              .then((response) => {
                // console.log(respone.data);
                // return;
                let blob = new Blob([response.data], {
                  type: "application/excel",
                });
                let link = document.createElement("a");
                link.href = window.URL.createObjectURL(blob);
                link.download = "Sales Report.xlsx";
                link.click();
              });
            break;
          default:
            break;
        }
      }
    },

    itemperpage() {
      this.page = 1;
      this.getSalesReport();
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
      this.getSalesReport();
    },
    id: {
      handler: function (v) {},
    },
  },
};
</script>