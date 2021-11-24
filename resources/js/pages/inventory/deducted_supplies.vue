<template>
  <!-- Div -->
  <div style="min-width: 310px">
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
    <v-card elevation="1" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-4 py-4">
        <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
          <v-row no-gutters>
            <v-spacer></v-spacer>
            <!-- Refresh -->
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
            <!-- Filter -->
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
                      :items="[
                        1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15,
                      ]"
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
                      placeholder="Supply Name"
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
                          @click="get"
                          class="ml-1"
                        >
                          <v-icon>mdi-magnify</v-icon></v-btn
                        >
                      </template>
                      <span>Search</span>
                    </v-tooltip>
                  </v-card-actions>
                </v-col>

                <!-- Category Field -->
                <v-col cols="4"
                  ><span class="text-caption text-xl-subtitle-2"
                    >Category</span
                  ></v-col
                >
                <v-col cols="8">
                  <v-card-actions class="px-0">
                    <v-select
                      hide-details
                      v-model="category"
                      :items="suppcatlist"
                      item-text="supply_cat_name"
                      item-value="id"
                      clearable
                      dense
                      placeholder="Category"
                      @change="get"
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
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-card-actions class="px-0">
                        <v-text-field
                          hide-details
                          v-model="dateFrom"
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
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-card-actions class="px-0">
                        <v-text-field
                          hide-details
                          v-model="dateUntil"
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
          <div class="pbutton text-center pt-7">
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

<!-- Style -->
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
  margin: 2px;
  height: 30px;
}
.pbutton .v-pagination i.v-icon.v-icon {
  color: #ffffff !important;
}
.pbutton .v-pagination__navigation:disabled {
  background-color: #000000 !important;
  height: 30px;
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

<!-- Script -->
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
  //Computed
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
  },

  //Data
  data: () => ({
    progressbar: false,
    search: "",
    button: false,
    dialog: false,
    category: "",
    table: [],
    suppcatlist: [],
    suppnamelist: [],
    filterDialog: false,

    //Table Headers
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

  //Onload
  created() {
    if (
      this.user.permissionslist.includes("Access Branch Inventory")
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

  //Methods
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

    //For retrieving deducted supplies
    async get() {
      this.progressbar = true; //Show the progress bar
      //Get data from tables
      this.itemsPerPage = parseInt(this.itemsPerPage) ?? 0;

      await axios
        .get("/api/deductedsupp/get", {
          params: {
            page: this.page,
            itemsPerPage: this.itemsPerPage,
            search: this.search,
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

    //For retrieving supply categories
    async suppCat() {
      await axios.get("/api/osupp/suppCat").then((supp_cat) => {
        this.suppcatlist = supp_cat.data;
      });
    },
  },

  //Watch
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