<template>
  <div style="min-width: 280px">
    <v-container>
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
            >Inventory Summary</v-btn
          >
        </v-card-actions>
      </v-layout>
    </v-container>

    <!-- Main Card -->
    <v-card elevation="6" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-4 py-4">
        <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
          <v-row no-gutters align="center" class="mb-3">
            <v-spacer></v-spacer>
            <v-tooltip bottom>
              <template #activator="data">
                <v-btn
                  class="ml-auto mr-2"
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
              <v-row no-gutters align="center" justify="center" class="pt-2">
                <!-- Date Picker -->
                <v-col cols="5" class="pa-4">
                  <v-select
                    v-model="year"
                    item-text=""
                    item-value="id"
                    :items="ylist"
                    dense
                    label="Year"
                    @change="get"
                    hide-details
                  >
                  </v-select>
                </v-col>

                <!-- Date Picker -->
                <v-col cols="7" class="pa-4">
                  <v-select
                    v-model="month"
                    item-text=""
                    item-value="id"
                    :items="mlist"
                    dense
                    label="Month"
                    @change="get"
                    hide-details
                  >
                  </v-select>
                </v-col>
              </v-row>
            </v-card>
          </v-dialog>

          <!-- Table -->
          <v-data-table
            :headers="headers"
            :items="table"
            :loading="progressbar"
            hide-default-footer
            ref="progress"
            class="mt-2 table-striped"
          >
            <!-- Progress Bar -->
            <v-progress-linear
              color="red darken-2"
              class="px-0 mx-0"
              slot="progress"
              indeterminate
              rounded
            ></v-progress-linear>

            <template slot="body.append">
              <tr class="hidden-xs-only">
                <th class="text-uppercase">Grand Totals</th>
                <td style="text-align: right; font-size: 15px">
                  {{ sumField("begining_orig") }}
                </td>
                <td style="text-align: right; font-size: 15px">
                  {{ sumField("incoming_orig") }}
                </td>
                <td style="text-align: right; font-size: 15px">
                  {{ sumField("total_orig") }}
                </td>
                <td style="text-align: right; font-size: 15px">
                  {{ sumField("outgoing_orig") }}
                </td>
                <td style="text-align: right; font-size: 15px">
                  {{ sumField("stocks_orig") }}
                </td>
                <td style="text-align: right; font-size: 15px">
                  {{ sumField("ending_orig") }}
                </td>
                <td style="text-align: right; font-size: 15px">
                  {{ sumField("variance_orig") }}
                </td>
                <td style="text-align: right; font-size: 15px">
                  {{ sumField("fluctuation_orig") }}
                </td>
              </tr>
            </template>
          </v-data-table>
        </v-container>
      </v-container>
    </v-card>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import axios from "axios"; // Library for sending api request
export default {
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
    snackbar: {
      active: false,
      message: "",
    },
    year: new Date().getFullYear(),
    month: new Date().toLocaleString("default", { month: "long" }),
    mlist: [],
    ylist: [],
    table: [],
    filterDialog: false,
    headers: [
      {
        text: "SUPPLIES CATEGORY",
        value: "category",
        align: "start",
        filterable: false,
        class: "black--text",
      },
      {
        text: "BEGINING INVENTORY",
        value: "begining",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "PURCHASES",
        value: "incoming",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "TOTAL STOCKS",
        value: "total",
        align: "right",
        filterable: false,
        class: "black--text",
      },

      {
        text: "OUTGOING SUPPLIES",
        value: "outgoing",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "STOCKS ON HAND",
        value: "stocks",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "ENDING INVENTORY",
        value: "ending",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "VARIANCE",
        value: "variance",
        align: "right",
        filterable: false,
        class: "black--text",
      },
      {
        text: "FLUCTUATION",
        value: "fluctuation",
        align: "right",
        filterable: false,
        class: "black--text",
      },
    ],
  }),

  //On Load
  created() {
    if (this.user.permissionslist.includes("Access Inventory")) {
      this.list();
      this.get();
    } else {
      this.$router.push({ name: "invalid-page" }).catch((errr) => {});
    }
  },

  methods: {
    sumField(key) {
      var num = 0;
      num = this.table.reduce((a, b) => a + (b[key] || 0), 0);
      return numeral(num).format("0,0.00");
    },
    list() {
      for (var key in moment.months()) {
        this.mlist.push(moment.months()[key]);
      }

      var currentYear = new Date().getFullYear(),
        years = [];
      var startYear = new Date().getFullYear() - 3;
      while (startYear <= currentYear) {
        years.push(startYear++);
      }
      this.ylist = years;
    },

    async get() {
      this.progressbar = true;
      await axios
        .get("/api/invsumm/get", {
          params: {
            year: this.year,
            month: new Date(Date.parse(this.month + " 1, 2020")).getMonth() + 1,
          },
        })
        .then((result) => {
          this.table = result.data;
          this.progressbar = false;
        });
    },
  },
};
</script>