<template>
  <div
    style="min-width: 280px"
    v-if="!user.permissionslist.includes('Access POS')"
  >
    <v-container class="py-2">
      <v-layout row wrap>
        <span
          class="
            text-h6 text-xl-h5 text-lg-h5 text-md-h6 text-sm-h6
            font-weight-bold
            my-auto
          "
        >
          Dashboard
        </span>
        <v-spacer></v-spacer>

        <!-- Cards Settings -->
        <v-tooltip bottom>
          <template #activator="data">
            <v-btn
              :small="$vuetify.breakpoint.xsOnly"
              large
              icon
              dark
              text
              color="red darken-2"
              class="mx-1"
              v-on="data.on"
              @click="sheet = !sheet"
            >
              <v-icon>mdi-settings</v-icon>
            </v-btn>
          </template>
          <span>Manage Cards</span>
        </v-tooltip>

        <v-bottom-sheet v-model="sheet" inset width="500px">
          <v-sheet class="text-center" style="border-radius: 10px 10px 0px 0px">
            <v-btn
              color="#FF5252"
              depressed
              dark
              style="text-transform: none"
              small
              class="mt-5"
              @click="sheet = !sheet"
            >
              Close
            </v-btn>

            <!-- Cards -->
            <v-row no-gutters>
              <v-col cols="12" xl="6" lg="6" md="6" sm="6">
                <v-row
                  align="center"
                  class="mx-7 my-xl-2 my-lg-2 my-md-1 my-sm-1 my-0"
                >
                  <v-checkbox
                    v-model="checkbox1"
                    hide-details
                    color="red darken-3"
                    class="shrink mt-0 pt-0"
                  ></v-checkbox>
                  <v-card-title
                    class="h6 my-auto px-0 font-weight-bold"
                    style="color: #616161"
                    >Supplies</v-card-title
                  >
                </v-row>
              </v-col>

              <v-col cols="12" xl="6" lg="6" md="6" sm="6">
                <v-row
                  align="center"
                  class="mx-7 my-xl-2 my-lg-2 my-md-1 my-sm-1 my-0"
                >
                  <v-checkbox
                    v-model="checkbox2"
                    hide-details
                    color="red darken-3"
                    class="shrink mt-0 pt-0"
                  ></v-checkbox>
                  <v-card-title
                    class="h6 my-auto px-0 font-weight-bold"
                    style="color: #616161"
                    >Products</v-card-title
                  >
                </v-row>
              </v-col>

              <v-col cols="12" xl="6" lg="6" md="6" sm="6">
                <v-row
                  align="center"
                  class="mx-7 my-xl-2 my-lg-2 my-md-1 my-sm-1 my-0"
                >
                  <v-checkbox
                    v-model="checkbox3"
                    hide-details
                    color="red darken-3"
                    class="shrink mt-0 pt-0"
                  ></v-checkbox>
                  <v-card-title
                    class="h6 my-auto px-0 font-weight-bold"
                    style="color: #616161"
                    >Purchase Orders</v-card-title
                  >
                </v-row>
              </v-col>

              <v-col cols="12" xl="6" lg="6" md="6" sm="6">
                <v-row
                  align="center"
                  class="mx-7 my-xl-2 my-lg-2 my-md-1 my-sm-1 my-0"
                >
                  <v-checkbox
                    v-model="checkbox4"
                    hide-details
                    color="red darken-3"
                    class="shrink mt-0 pt-0"
                  ></v-checkbox>
                  <v-card-title
                    class="h6 my-auto px-0 font-weight-bold"
                    style="color: #616161"
                    >Users</v-card-title
                  >
                </v-row>
              </v-col>
            </v-row>
          </v-sheet>
        </v-bottom-sheet>
      </v-layout>
    </v-container>

    <!-- Cards -->
    <v-container class="pa-0">
      <v-row no-gutters>
        <v-col
          cols="6"
          xl="3"
          lg="3"
          md="4"
          sm="6"
          class="pa-1"
          :hidden="!hiddenCard1"
        >
          <v-card
            elevation="2"
            style="border-radius: 10px; border-left: 10px solid #827717"
            class="pa-0"
            height="100"
          >
            <v-card-title
              style="color: #827717"
              class="pt-2 caption"
              :class="{ 'justify-center': $vuetify.breakpoint.xsOnly }"
              >Total Supplies</v-card-title
            >
            <v-card-subtitle
              class="h3 pb-0 mb-0"
              style="color: #000000; font-weight: bold"
              :class="{ 'text-center': $vuetify.breakpoint.xsOnly }"
              >{{ supp }}
              <v-progress-circular
                size="25"
                indeterminate
                :hidden="hidden1"
                color="red darken-2"
              ></v-progress-circular
            ></v-card-subtitle>
            <v-card-actions
              ><v-btn
                text
                small
                class="mx-auto caption"
                style="text-transform: none; text-decoration: none"
                :to="{ name: 'masterlist-supplies' }"
                >View Info<v-icon small>mdi-arrow-right</v-icon></v-btn
              ></v-card-actions
            >
          </v-card>
        </v-col>

        <v-col
          cols="6"
          xl="3"
          lg="3"
          md="4"
          sm="6"
          class="pa-1"
          :hidden="!hiddenCard2"
        >
          <v-card
            elevation="2"
            style="border-radius: 10px; border-left: 10px solid #827717"
            class="pa-0"
            height="100"
          >
            <v-card-title
              style="color: #827717"
              class="pt-2 caption"
              :class="{ 'justify-center': $vuetify.breakpoint.xsOnly }"
              >Total Products</v-card-title
            >
            <v-card-subtitle
              class="h3 pb-0 mb-0"
              style="color: #000000; font-weight: bold"
              :class="{ 'text-center': $vuetify.breakpoint.xsOnly }"
              >{{ prod }}
              <v-progress-circular
                size="25"
                indeterminate
                :hidden="hidden2"
                color="red darken-2"
              ></v-progress-circular
            ></v-card-subtitle>
            <v-card-actions
              ><v-btn
                text
                small
                class="mx-auto caption"
                style="text-transform: none; text-decoration: none"
                :to="{ name: 'masterlist-products' }"
                >View Info<v-icon small>mdi-arrow-right</v-icon></v-btn
              ></v-card-actions
            >
          </v-card>
        </v-col>

        <v-col
          cols="6"
          xl="3"
          lg="3"
          md="4"
          sm="6"
          class="pa-1"
          :hidden="!hiddenCard3"
        >
          <v-card
            elevation="2"
            style="border-radius: 10px; border-left: 10px solid #827717"
            class="pa-0"
            height="100"
          >
            <v-card-title
              style="color: #827717"
              class="pt-2 caption"
              :class="{ 'justify-center': $vuetify.breakpoint.xsOnly }"
              >Total PO</v-card-title
            >
            <v-card-subtitle
              class="h3 pb-0 mb-0"
              style="color: #000000; font-weight: bold"
              :class="{ 'text-center': $vuetify.breakpoint.xsOnly }"
              >{{ po }}
              <v-progress-circular
                size="25"
                indeterminate
                :hidden="hidden3"
                color="red darken-2"
              ></v-progress-circular
            ></v-card-subtitle>
            <v-card-actions
              ><v-btn
                text
                small
                class="mx-auto caption"
                style="text-transform: none; text-decoration: none"
                :to="{ name: 'purchase-orders' }"
                >View Info<v-icon small>mdi-arrow-right</v-icon></v-btn
              ></v-card-actions
            >
          </v-card>
        </v-col>

        <v-col
          cols="6"
          xl="3"
          lg="3"
          md="4"
          sm="6"
          class="pa-1"
          :hidden="!hiddenCard4"
        >
          <v-card
            elevation="2"
            style="border-radius: 10px; border-left: 10px solid #827717"
            class="pa-0"
            height="100"
          >
            <v-card-title
              style="color: #827717"
              class="pt-2 caption"
              :class="{ 'justify-center': $vuetify.breakpoint.xsOnly }"
              >Total Users</v-card-title
            >
            <v-card-subtitle
              class="h3 pb-0 mb-0"
              style="color: #000000; font-weight: bold"
              :class="{ 'text-center': $vuetify.breakpoint.xsOnly }"
              >{{ useracc }}
              <v-progress-circular
                size="25"
                indeterminate
                :hidden="hidden4"
                color="red darken-2"
              ></v-progress-circular
            ></v-card-subtitle>
            <v-card-actions
              ><v-btn
                text
                small
                class="mx-auto caption"
                style="text-transform: none; text-decoration: none"
                :to="{ name: 'user-accounts' }"
                >View Info<v-icon small>mdi-arrow-right</v-icon></v-btn
              ></v-card-actions
            >
          </v-card>
        </v-col>
      </v-row>

      <!-- Divider -->
      <v-divider
        style="border: 2px solid #bdbdbd; border-radius: 5px"
      ></v-divider>

      <!-- Graphs -->
      <v-row no-gutters>
        <v-spacer></v-spacer>
        <v-col cols="12" xl="6" lg="6" md="6" sm="6">
          <v-row no-gutters class="mb-3">
            <v-select
              :items="branchlist"
              v-model="branch"
              item-text="branch_name"
              item-value="id"
              label="Branch"
              @change="getProductsGraph"
              hide-details
              style="width: 230px; font-size: 12px"
              class="pa-1"
              dense
              solo
              dark
            >
            </v-select>
            <v-select
              v-model="year"
              item-text=""
              item-value="id"
              :items="ylist"
              label="Year"
              @change="getProductsGraph"
              hide-details
              style="width: 100px; font-size: 12px; color: white"
              class="pa-1"
              dense
              solo
              dark
            >
            </v-select>
            <v-select
              v-model="month"
              item-text=""
              item-value="id"
              :items="mlist"
              label="Month"
              @change="getProductsGraph"
              hide-details
              style="width: 160px; font-size: 12px"
              class="pa-1"
              dense
              solo
              dark
            >
            </v-select
          ></v-row>
        </v-col>
      </v-row>
      <v-row no-gutters>
        <v-col cols="12" xl="6" lg="6" md="6" sm="12" class="pa-1">
          <v-card
            elevation="2"
            style="border-radius: 10px"
            class="pa-2"
            :loading="progressbar1"
            ref="progress"
          >
            <bar-chart :options="options" :chart-data="datacollection">
            </bar-chart>
            <v-progress-linear
              color="red darken-2"
              class="px-0 mx-0"
              slot="progress"
              indeterminate
              rounded
            ></v-progress-linear>
          </v-card>
        </v-col>
        <v-col cols="12" xl="6" lg="6" md="6" sm="12" class="pa-1">
          <v-card
            elevation="2"
            style="border-radius: 10px"
            class="pa-3"
            :loading="progressbar2"
            ref="progress"
          >
            <bar-chart1 :options="options1" :chart-data="datacollection1">
            </bar-chart1>
            <v-progress-linear
              color="red darken-2"
              class="px-0 mx-0"
              slot="progress"
              indeterminate
              rounded
            ></v-progress-linear>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<style>
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
import BarChart from "../charts/BarChart";
import BarChart1 from "../charts/BarChart";
import { mapGetters } from "vuex";
import axios from "axios"; // Library for sending api request
export default {
  middleware: "auth",
  metaInfo() {
    return { title: "Dashboard" };
  },
  components: {
    BarChart,
    BarChart1,
  },
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
    hiddenCard1() {
      if (this.checkbox1 == false) {
        return false;
      } else {
        return true;
      }
    },
    hiddenCard2() {
      if (this.checkbox2 == false) {
        return false;
      } else {
        return true;
      }
    },
    hiddenCard3() {
      if (this.checkbox3 == false) {
        return false;
      } else {
        return true;
      }
    },
    hiddenCard4() {
      if (this.checkbox4 == false) {
        return false;
      } else {
        return true;
      }
    },
  },
  data: () => ({
    sheet: false,
    checkbox1: true,
    checkbox2: true,
    checkbox3: true,
    checkbox4: true,
    branch: 1,
    year: new Date().getFullYear(),
    month: "All",
    supp: null,
    prod: null,
    po: null,
    mlist: [],
    ylist: [],
    useracc: null,
    hidden1: true,
    hidden2: true,
    hidden3: true,
    hidden4: true,
    progressbar1: false,
    progressbar2: false,
    branchlist: [],
    datacollection: {},
    options: {
      // onClick: function(e,i) {
      //     e = i[0];
      //     this.selecteditem = this.data.labels[e._index];
      //     that.selectCresta(e._index)
      // },
      plugins: {
        zoom: {
          zoom: {
            wheel: {
              enabled: true,
            },
            pinch: {
              enabled: true,
            },
            mode: "xy",
          },
        },
      },

      responsiveAnimationDuration: 0,
      tooltips: {
        enabled: true,
        mode: "single",
        callbacks: {
          label: function (data) {
            return [
              "₱ " +
                data.yLabel
                  .toFixed(2)
                  .toString()
                  .replace(/\B(?=(\d{3})+(?!\d))/g, ","),
            ];
          },
          title: function (data) {
            return "Sale: " + data[0].label;
          },
        },
      },
      scales: {
        yAxes: [
          {
            ticks: {
              beginAtZero: true,
              callback: function (value, index, values) {
                return (
                  "PHP " +
                  value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                );
              },
            },
          },
        ],
      },
    },

    datacollection1: {},
    options1: {
      // onClick: function(e,i) {
      //     e = i[0];
      //     this.selecteditem = this.data.labels[e._index];
      //     that.selectCresta(e._index)
      // },
      plugins: {
        zoom: {
          zoom: {
            wheel: {
              enabled: true,
            },
            pinch: {
              enabled: true,
            },
            mode: "xy",
          },
        },
      },

      responsiveAnimationDuration: 0,
      tooltips: {
        enabled: true,
        mode: "single",
        callbacks: {
          label: function (data) {
            return [
              data.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
            ];
          },
          title: function (data) {
            return "Purchase: " + data[0].label;
          },
        },
      },
      scales: {
        yAxes: [
          {
            ticks: {
              beginAtZero: true,
              callback: function (value, index, values) {
                return value;
              },
            },
          },
        ],
      },
    },
  }),

  methods: {
    list() {
      this.mlist = ["All"];
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

    async getSupp() {
      this.hidden1 = false;
      await axios
        .get("/api/dashboard/getSupp")
        .then((result) => {
          this.supp = result.data;
          this.hidden1 = true;
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    async getProd() {
      this.hidden2 = false;
      await axios
        .get("/api/dashboard/getProd")
        .then((result) => {
          this.prod = result.data;
          this.hidden2 = true;
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    async getPO() {
      this.hidden3 = false;
      await axios
        .get("/api/dashboard/getPO")
        .then((result) => {
          this.po = result.data;
          this.hidden3 = true;
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    async getUser() {
      this.hidden4 = false;
      await axios
        .get("/api/dashboard/getUser")
        .then((result) => {
          this.useracc = result.data;
          this.hidden4 = true;
        })
        .catch((result) => {
          // If false or error when saving
        });
    },

    async getSalesGraph() {
      this.progressbar1 = true;
      await axios
        .get("/api/dashboard/getSalesGraph", {
          params: {
            branch: this.branch,
            year: this.year,
            month: new Date(Date.parse(this.month + " 1, 2020")).getMonth() + 1,
          },
        })
        .then((result) => {
          this.datacollection = {
            labels: result.data.month,
            datasets: [
              {
                label: "Sale",
                backgroundColor: "#D32F2F",
                data: result.data.data,
              },
            ],
          };
          this.progressbar1 = false;
        })
        .catch((result) => {});
    },
    async getProductsGraph() {
      this.getSalesGraph();
      this.progressbar2 = true;
      await axios
        .get("/api/dashboard/getProductsGraph", {
          params: {
            branch: this.branch,
            year: this.year,
            month: new Date(Date.parse(this.month + " 1, 2020")).getMonth() + 1,
          },
        })
        .then((result) => {
          this.datacollection1 = {
            labels: result.data.name,
            datasets: [
              {
                label: "Purchase",
                backgroundColor: "#D32F2F",
                data: result.data.sold,
              },
            ],
          };
          this.progressbar2 = false;
        })
        .catch((result) => {});
    },

    async branchName() {
      await axios
        .get("/api/branches/inventory/branchName")
        .then((bran_name) => {
          this.branchlist = bran_name.data;
        });
    },
  },

  created() {
    if (this.user.permissionslist.includes("Access Dashboard")) {
      this.getSupp();
      this.getProd();
      this.list();
      this.getPO();
      this.getUser();
      this.getSalesGraph();
      this.getProductsGraph();
      this.branchName();
    } else {
      if (this.user.permissionslist.includes("Access POS")) {
        this.$router.push({ name: "pos" }).catch((errr) => {});
      } else {
        if (this.user.roles[0].name == "Stockman") {
          this.$router
            .push({ name: "masterlist-supplies" })
            .catch((errr) => {});
        }
        if (this.user.roles[0].name == "Production Assistant") {
          this.$router
            .push({ name: "masterlist-products" })
            .catch((errr) => {});
        }
        if (this.user.roles[0].name == "Supervisor") {
          this.$router.push({ name: "supplies-inventory" }).catch((errr) => {});
        }
      }
    }
  },
};
</script>