<template>
  <div style="min-width: 280px">
    <v-container>
      <v-layout row wrap>
        <span
          class="
            text-h6 text-xl-h5 text-lg-h5 text-md-h6 text-sm-h6
            font-weight-bold
            my-auto
          "
        >
          Inventory
        </span>
        <v-spacer></v-spacer>

        <!-- Breadcrumbs -->
        <v-card-actions class="px-0 py-0">
          <v-btn
            :small="$vuetify.breakpoint.smAndDown"
            plain
            color="primary"
            v-ripple="false"
            to="/supplies_inventory"
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
          >
            Deducted Supplies
          </v-btn>
        </v-card-actions>
      </v-layout>
    </v-container>

    <!-- Main Card -->
    <v-card elevation="6" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-4 py-4">
        <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
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
                  @click="get"
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
          <v-dialog v-model="filterDialog" max-width="380px">
            <v-toolbar
              dense
              dark
              class="pl-xl-6 pl-lg-6 pl-md-6 pl-sm-5 pl-3 red darken-2"
            >
              Filter
              <v-spacer></v-spacer>
              <v-icon
                class="mr-xl-4 mr-lg-4 mr-md-4 mr-sm-3 mr-1"
                text
                @click="filterDialog = false"
                >mdi-close
              </v-icon>
            </v-toolbar>
            <v-card tile class="px-3 py-0 px-xl-6 px-lg-6">
              <v-row no-gutters align="center" class="pt-2">
                <!-- Items Per Page -->
                <v-col cols="4" class="pa-2">
                  <v-select
                    dense
                    v-model="itemsPerPage"
                    label="Items per page"
                    @change="itemperpage"
                    :items="[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15]"
                    hide-details
                  >
                  </v-select>
                </v-col>

                <!-- Search Field -->
                <v-col cols="8">
                  <v-card-actions>
                    <v-text-field
                      v-model="search"
                      label="Supply Name"
                      single-line
                      dense
                      clearable
                      hide-details
                    ></v-text-field>
                    <v-tooltip bottom>
                      <template #activator="data">
                        <v-btn
                          large
                          :small="$vuetify.breakpoint.smAndDown"
                          color="red darken-2"
                          icon
                          v-on="data.on"
                          @click="get"
                          class="mt-2"
                        >
                          <v-icon>mdi-magnify</v-icon></v-btn
                        >
                      </template>
                      <span>Search</span>
                    </v-tooltip>
                  </v-card-actions>
                </v-col>

                <!-- Branch Field -->
                <v-col
                  cols="12"
                  class="pa-2"
                  v-if="
                    !user.permissionslist.includes(
                      'Access Reports - Outgoing Supplies'
                    )
                  "
                >
                  <v-select
                    v-model="branch"
                    :items="branchlist"
                    item-text="branch_name"
                    item-value="id"
                    class="my-0"
                    clearable
                    dense
                    label="Branch"
                    @change="get"
                  >
                  </v-select>
                </v-col>

                <!-- Category Field -->
                <v-col cols="12" class="pa-2">
                  <v-select
                    v-model="category"
                    :items="suppcatlist"
                    item-text="supply_cat_name"
                    item-value="id"
                    class="my-0"
                    clearable
                    dense
                    label="Category"
                    @change="get"
                  >
                  </v-select>
                </v-col>

                <!-- Date Picker -->
                <v-col cols="12" class="pa-2">
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
                        v-model="dateFrom"
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
                      v-model="dateFrom"
                      @input="date1 = false"
                      scrollable
                      no-title
                      color="red darken-2"
                      dark
                      @change="get"
                    ></v-date-picker>
                  </v-menu>
                </v-col>

                <!-- Date Picker -->
                <v-col cols="12" class="pa-2">
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
                        v-model="dateUntil"
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
                      v-model="dateUntil"
                      @input="date2 = false"
                      scrollable
                      no-title
                      color="red darken-2"
                      dark
                      @change="get"
                    ></v-date-picker>
                  </v-menu>
                </v-col>
              </v-row>
            </v-card>
          </v-dialog>

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
            <template v-slot:[`item.with_vat_price`]="{ item }"
              >{{ getFormatCurrency(item.with_vat_price, "0,0.00") }}
            </template>
            <template v-slot:[`item.supply_name.net_price`]="{ item }"
              >{{ getFormatCurrency(item.supply_name.net_price, "0,0.00") }}
            </template>
            <template v-slot:[`item.amount`]="{ item }"
              >{{ getFormatCurrency(item.amount, "0,0.00") }}
            </template>
            <template v-slot:[`item.supply_full`]="{ item }"
              >{{ item.supply_name.supply_name }}
              {{ item.supply_name.description }}</template
            >
            <template v-slot:[`item.outgoing_date`]="{ item }">
              {{ getFormatDate(item.outgoing_date, "YYYY-MM-DD") }}</template
            >
            <template v-slot:[`item.count`]="{ item }">
              {{ item.row }}</template
            >
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
        </v-container>
      </v-container>
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
import { mapGetters } from "vuex";
import axios from "axios"; // Library for sending api request
import template from "../template.vue";
export default {
  components: { template },
  middleware: "auth",
  metaInfo() {
    return { title: "Inventory" };
  },
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
  },
  data: () => ({
    progressbar: false,
    search: "",
    button: false,
    dialog: false,
    category: "",
    branch: "",
    table: [],
    suppcatlist: [],
    suppnamelist: [],
    branchlist: [],
    filterDialog: false,

    // Table Headers
    headers: [
      {
        text: "#",
        value: "count",
        align: "start",
        filterable: false,
        class: "black--text",
      },
      {
        text: "CATEGORY",
        value: "category.supply_cat_name",
        filterable: false,
        class: "black--text",
      },
      {
        text: "SUPPLY NAME",
        value: "supply_full",
        class: "black--text",
      },
      {
        text: "UNIT",
        value: "supply_name.unit",
        filterable: false,
        class: "black--text",
      },
      {
        text: "NET PRICE",
        value: "supply_name.net_price",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "WITH VAT",
        value: "with_vat_price",
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
        text: "TOTAL AMT",
        value: "amount",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "DATE",
        value: "outgoing_date",
        filterable: false,
        class: "black--text",
      },
    ],
    page: 1,
    pageCount: 0,
    itemsPerPage: 5,
    dateFrom: null,
    dateUntil: null,
    date1: false,
    date2: false,
    date3: false,
  }),

  // Onload
  created() {
    if (
      this.user.permissionslist.includes("Access Reports - Outgoing Supplies")
    ) {
      this.dateFrom = this.getFormatDate(
        new Date(new Date().getFullYear(), new Date().getMonth(), 1),
        "YYYY-MM-DD"
      );
      this.dateUntil = this.getFormatDate(
        new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0),
        "YYYY-MM-DD"
      );
      this.get();
      this.suppCat();
    } else {
      this.$router.push({ name: "invalid-page" }).catch((errr) => {});
    }
  },

  methods: {
    itemperpage() {
      this.page = 1;
      this.get();
    },

    getFormatDate(e, format) {
      const date = moment(e);
      return date.format(format);
    },

    getFormatCurrency(e, format) {
      const numbr = numeral(e);
      return numbr.format(format);
    },

    async get() {
      this.progressbar = true; // Show the progress bar
      // Get data from tables
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;

      await axios
        .get("/api/deductedsupp/get", {
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
          this.table = result.data;
          this.progressbar = false; // Hide the progress bar
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    async suppCat() {
      await axios.get("/api/osupp/suppCat").then((supp_cat) => {
        this.suppcatlist = supp_cat.data;
      });
    },
  },

  watch: {
    page(val) {
      this.page = val;
      this.get();
    },
    id: {
      handler: function (v) {},
    },
  },
};
</script>