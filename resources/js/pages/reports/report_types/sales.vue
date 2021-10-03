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
              label="Product Name"
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
              @change="getSalesReport"
              label="Branch"
            >
            </v-select>
          </v-card-actions>
        </v-col>

        <!-- Category Field -->
        <v-col cols="6" xl="2" lg="3" md="3" sm="6" class="my-auto">
          <v-card-actions class="py-0">
            <v-select
              :items="prodcatlist"
              item-text="product_cat_name"
              item-value="id"
              class="my-0"
              v-model="category"
              @change="getSalesReport"
              clearable
              dense
              label="Category"
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
    prodcatlist: [],
    table: [],
    branchlist: [],
    date1: false,
    date2: false,
    dateFromSP: null,
    dateUntilSP: null,
    page: 1,
    pageCount: 0,
    itemsPerPage: 5,
    // Table Headers SP
    headers: [
      { text: "#", value: "count", align: "start", filterable: false },
      {
        text: "Branch",
        value: "branch.branch_name",
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
        text: "Sales Amount",
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
  }),

  created() {
    this.suppCat();
    this.getSalesReport();
    this.branchName();
    this.prodCat();
  },
  methods: {
    async getSalesReport() {
      await axios({
        url: "/api/sales_report/list",
        method: "GET",
        params: { category: this.category },
      }).then((response) => {
        console.log(response.data);
        this.table = response.data;
      });
    },

    async branchName() {
      await axios.get("/api/osupp/branchName").then((bran_name) => {
        this.branchlist = bran_name.data;
      });
    },

    async prodCat() {
      await axios.get("/api/outprod/prodCat").then((prod_cat) => {
        this.prodcatlist = prod_cat.data;
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
      this.getSalesReport();
    },
    async suppCat() {
      await axios.get("/api/msupp/suppCat").then((supp_cat) => {
        this.suppcatlist = supp_cat.data;
      });
    },
  },
};
</script>