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

    <v-row no-gutters>
      <v-col cols="12" xl="6" lg="6" md="6" sm="12" class="pa-1">
        <v-card style="border-radius: 10px" class="pa-2">
          <v-card
            dark
            flat
            height="50"
            color="red darken-4"
            style="border-radius: 10px"
            class="d-flex align-center justify-center"
          >
            <span>Products List</span>
          </v-card>

          <v-row no-gutters class="mt-2">
            <!-- Items Per Page -->
            <v-col cols="4" xl="2" lg="2" md="3" sm="4" class="my-auto">
              <v-card-actions>
                <v-select
                  style="max-width: 82px"
                  dense
                  v-model="itemsPerPage"
                  label="Items"
                  @change="itemperpage"
                  :items="[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15]"
                >
                </v-select>
              </v-card-actions>
            </v-col>

            <v-spacer></v-spacer>

            <!-- Search Field -->
            <v-col cols="8" xl="5" lg="5" md="7" sm="8" class="my-auto">
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
                      @click="get"
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

          <!-- Products List Table -->
          <v-data-table
            :headers="headers1"
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
            <template v-slot:[`item.count`]="{ item }">
              {{ item.row }}</template
            >
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
        </v-card>
      </v-col>

      <v-col cols="12" xl="6" lg="6" md="6" sm="12" class="pa-1">
        <v-card style="border-radius: 10px" class="pa-2">
          <v-card
            dark
            flat
            height="50"
            color="red darken-4"
            style="border-radius: 10px"
            class="d-flex align-center justify-center"
          >
            <span>Order Details</span>
          </v-card>

          <v-row no-gutters class="mt-2">
            <!-- Items Per Page -->
            <v-card-actions>
              <span
                style="color: #616161"
                :class="{ 'text-caption': $vuetify.breakpoint.xsOnly }"
                >Sales Count:</span
              >
            </v-card-actions>

            <v-spacer></v-spacer>

            <!-- Mode Field -->
            <v-col cols="6" xl="4" lg="4" md="6" sm="7" class="my-auto">
              <v-card-actions>
                <v-select
                  outlined
                  dense
                  :items="['Walk In', 'Take Out', 'Delivery']"
                  hide-details
                  class="mb-0 mb-xl-4 mb-lg-4 mb-md-4 mb-sm-2"
                >
                  <template slot="label">
                    <div style="font-size: 14px">Mode</div>
                  </template>
                </v-select>
              </v-card-actions>
            </v-col>
          </v-row>

          <!-- Products List Table -->
          <v-data-table
            :headers="headers2"
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
            <template v-slot:[`item.count`]="{ item }">
              {{ item.row }}</template
            >
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
        </v-card>
      </v-col>
    </v-row>

    <v-row no-gutters>
      <v-spacer></v-spacer>

      <v-col cols="12" xl="6" lg="6" md="6" sm="12" class="pa-1">
        <v-card
          height="50"
          class="d-flex align-center pa-3"
          style="border-radius: 10px"
        >
          <strong style="color: #616161">Total</strong>
          <v-spacer></v-spacer>
          <strong>0.00</strong>
        </v-card>
      </v-col>
    </v-row>

    <v-row no-gutters>
      <v-spacer></v-spacer>

      <v-col cols="12" xl="6" lg="6" md="6" sm="12" class="pa-1">
        <v-card style="border-radius: 10px" class="pa-3">
          <v-row align="center" justify="center">
            <v-col cols="6" xl="4" lg="4" md="6" sm="6" class="pb-0">
              <v-text-field outlined clearable dense hide-details>
                <template slot="label">
                  <div style="font-size: 14px">Payment</div>
                </template>
              </v-text-field>
            </v-col>

            <v-col cols="6" xl="4" lg="4" md="6" sm="6" class="pb-0">
              <v-text-field outlined clearable dense hide-details>
                <template slot="label">
                  <div style="font-size: 14px">Discount</div>
                </template>
              </v-text-field>
            </v-col>

            <v-col cols="12" xl="4" lg="4" md="12" sm="12" class="pb-0">
              <v-text-field outlined dense disabled hide-details>
                <template slot="label">
                  <div style="font-size: 14px">Change</div>
                </template>
              </v-text-field>
            </v-col>
          </v-row>

          <v-row class="mt-2">
            <v-col>
              <v-btn
                dark
                block
                color="green darken-3"
                style="text-transform: none"
              >
                Done
              </v-btn>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import axios from "axios"; // Library for sending api request
export default {
  middleware: "auth",
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
  },
  data: () => ({
    progressbar: false,
    snackbar: {
      active: false,
      message: "",
    },
    search: "",
    button: false,
    dialog: false,
    table: [],
    prodcatlist: [],
    prodsubcatlist: [],

    // Form Rules
    formRules: [(v) => !!v || "This is required"],
    formRulesNumberRange: (v) => {
      if (!isNaN(parseFloat(v)) && v >= 1 && v <= 100) return true;
      return "Number has to be between 1% and 100%";
    },
    formRulesNumber: [
      (v) => Number.isInteger(Number(v)) || "The value must be an integer",
    ],

    form: {
      id: null,
      quantity: null,
    },

    // Table Headers
    headers1: [
      { text: "#", value: "count", align: "start", filterable: false },
      {
        text: "Category",
        value: "category",
        filterable: false,
      },
      { text: "Sub Category", value: "sub_category", filterable: false },
      {
        text: "Product Name",
        value: "product_name",
        align: "right",
      },
      {
        text: "Quantity",
        value: "quantity",
        align: "right",
        filterable: false,
      },
      {
        text: "Price",
        value: "price",
        align: "right",
        filterable: false,
      },
    ],
    page: 1,
    pageCount: 0,
    itemsPerPage: 5,

    // Table Headers
    headers2: [
      { text: "#", value: "count", align: "start", filterable: false },
      {
        text: "Product Name",
        value: "product_name",
        filterable: false,
      },
      { text: "Price", value: "price", align: "right", filterable: false },
      {
        text: "Quantity",
        value: "quantity",
        align: "right",
        filterable: false,
      },
      {
        text: "Sub-Total",
        value: "sub_total",
        align: "right",
        filterable: false,
      },
    ],
    page: 1,
    pageCount: 0,
    itemsPerPage: 5,
  }),

  methods: {
    itemperpage() {
      this.page = 1;
      this.get();
    },

    async get() {},
  },

  created() {
    if (this.user.permissionslist.includes("Access POS")) {
    } else {
      this.$router.push({ name: "invalid-page" }).catch((errr) => {});
    }
  },
};
</script>