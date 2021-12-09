<template>
  <!-- Div -->
  <div style="min-width: 310px; max-width: 1500px">
    <v-container>
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
    <v-card elevation="1" class="mt-2" style="border-radius: 10px">
      <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-4 py-4">
        <v-card-actions class="px-0">
          <v-row align="center" no-gutters>
            <v-spacer></v-spacer>
            <v-card color="red darken-3" flat style="border-radius: 20px">
              <!-- Refresh -->
              <v-tooltip bottom>
                <template #activator="data">
                  <v-btn
                    class="mr-2"
                    color="white"
                    depressed
                    :small="$vuetify.breakpoint.smAndDown"
                    dark
                    @click="refresh"
                    v-on="data.on"
                    icon
                    ><v-icon size="20">mdi-refresh</v-icon></v-btn
                  >
                </template>
                <span>Refresh</span>
              </v-tooltip>
              <!-- Filter -->
              <v-tooltip bottom>
                <template #activator="data">
                  <v-btn
                    color="white"
                    depressed
                    :small="$vuetify.breakpoint.smAndDown"
                    dark
                    @click="filterDialog = true"
                    v-on="data.on"
                    icon
                    ><v-icon size="20">mdi-filter-variant</v-icon></v-btn
                  >
                </template>
                <span>Filter</span>
              </v-tooltip>
            </v-card>
          </v-row>
        </v-card-actions>

        <!-- Filter Dialog -->
        <v-dialog v-model="filterDialog" max-width="400px">
          <v-card dark tile class="pa-2">
            <v-toolbar dense flat class="transparent">
              Search Filter
              <v-spacer></v-spacer>
              <v-icon text @click="filterDialog = false">mdi-close </v-icon>
            </v-toolbar>
            <v-divider class="my-0"></v-divider>
            <v-row no-gutters align="center" justify="center" class="pa-2">
              <!-- Date Picker -->
              <v-col cols="4"
                ><span class="text-caption text-xl-subtitle-2"
                  >Year</span
                ></v-col
              >
              <v-col cols="8">
                <v-card-actions class="px-0">
                  <v-select
                    v-model="year"
                    item-text=""
                    item-value="id"
                    :items="ylist"
                    dense
                    placeholder="Year"
                    @change="get"
                    hide-details
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
                  >Month</span
                ></v-col
              >
              <v-col cols="8">
                <v-card-actions class="px-0">
                  <v-select
                    v-model="month"
                    item-text=""
                    item-value="id"
                    :items="mlist"
                    dense
                    placeholder="Month"
                    @change="get"
                    hide-details
                    background-color="grey darken-3"
                    flat
                    solo
                    style="font-size: 12px"
                  >
                  </v-select>
                </v-card-actions>
              </v-col>
            </v-row>
          </v-card>
        </v-dialog>

        <!-- Table -->
        <v-data-table
          id="table1"
          :headers="headers"
          :items="table"
          :loading="progressbar"
          hide-default-footer
          ref="progress"
          class="mt-2 table-striped border"
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
              <th class="text-uppercase">GRAND TOTALS</th>
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
    </v-card>
  </div>
</template>

<!-- Style -->
<style>
.container {
  max-width: 1500px !important;
}

#table1 .v-data-table-header th {
  white-space: nowrap;
}
#table1 .v-data-table-header th {
  font-size: 12px !important;
  text-align: center !important;
}
#table1 td {
  font-size: 12px !important;
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
export default {
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
        width: "15%",
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

  //Methods
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

    //For retrieving inventory summary
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

    //For refresh
    refresh() {
      this.get();
    },
  },
};
</script>