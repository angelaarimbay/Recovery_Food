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
        <!-- Export to PDF -->
        <v-tooltip bottom>
          <template #activator="data">
            <v-btn
              dark
              color="red accent-4"
              class="mx-1"
              @click="get('pdf')"
              v-on="data.on"
              :small="$vuetify.breakpoint.smAndDown"
              ><v-icon>mdi-file-pdf</v-icon></v-btn
            >
          </template>
          <span>Export to PDF</span>
        </v-tooltip>
        <!-- Export to Excel -->
        <v-tooltip bottom>
          <template #activator="data">
            <v-btn
              dark
              color="green darken-4"
              class="mx-1"
              @click="get('excel')"
              v-on="data.on"
              :small="$vuetify.breakpoint.smAndDown"
              ><v-icon>mdi-file-excel</v-icon></v-btn
            >
          </template>
          <span>Export to Excel</span>
        </v-tooltip>
        <!-- Print -->
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
      <v-row no-gutters justify="center">
        <!-- Year -->
        <v-col cols="6" class="px-1" style="max-width: 150px">
          <v-card-actions class="pb-1 pt-4 px-0">
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
              dark
              flat
              solo
              style="font-size: 12px"
            >
            </v-select>
          </v-card-actions>
        </v-col>

        <!-- Month -->
        <v-col cols="6" class="px-1" style="max-width: 150px">
          <v-card-actions class="pb-1 pt-4 px-0">
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
              dark
              flat
              solo
              style="font-size: 12px"
            >
            </v-select>
          </v-card-actions>
        </v-col>
      </v-row>
    </v-container>
    <iframe id="print4" class="d-none" :src="print" frameborder="0"></iframe>
  </v-container>
</template>

<!-- Style -->
<style>
@media (min-width: 1200px) {
  .container {
    max-width: 1500px !important;
  }
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
import axios from "axios"; // Library for sending api request
export default {
  //Data
  data: () => ({
    dateFrom: null,
    print: "",
    dateUntil: null,
    date1: false,
    date2: false,
    snackbar: {
      active: false,
      message: "",
    },
    year: new Date().getFullYear(),
    month: new Date().toLocaleString("default", { month: "long" }),
    mlist: [],
    ylist: [],
    overlay: false,
  }),

  //Onload
  created() {
    this.list();
  },

  //Methods
  methods: {
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

    //For exporting/printing
    async get(type) {
      if (this.year == null || this.month == null) {
        this.snackbar = {
          active: true,
          iconText: "alert",
          iconColor: "error",
          message: "Error! Please select a year and/or month first.",
        };
      } else {
        this.overlay = true;
        switch (type) {
          case "pdf":
            await axios({
              url: "/api/reports/inventorysummary/get",
              method: "GET",
              responseType: "blob",
              params: {
                type: type,
                year: this.year,
                month:
                  new Date(Date.parse(this.month + " 1, 2020")).getMonth() + 1,
              },
            }).then((response) => {
              if (response.data.size > 0) {
                let blob = new Blob([response.data], {
                  type: "application/pdf",
                });
                let link = document.createElement("a");
                link.href = window.URL.createObjectURL(blob);
                link.download = "Inventory Summary Report.pdf";
                link.click();
                this.snackbar = {
                  active: true,
                  iconText: "check",
                  iconColor: "success",
                  message: "Successfully exported.",
                };
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
              url: "/api/reports/inventorysummary/get",
              method: "GET",
              responseType: "blob",
              params: {
                type: "pdf",
                year: this.year,
                month:
                  new Date(Date.parse(this.month + " 1, 2020")).getMonth() + 1,
              },
            }).then((response) => {
              if (response.data.size > 0) {
                axios
                  .get("/api/reports/inventorysummary/get", {
                    method: "GET",
                    responseType: "arraybuffer",
                    params: {
                      type: type,
                      year: this.year,
                      month:
                        new Date(
                          Date.parse(this.month + " 1, 2020")
                        ).getMonth() + 1,
                    },
                  })
                  .then((res) => {
                    let blob = new Blob([res.data], {
                      type: "application/excel",
                    });
                    let link = document.createElement("a");
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "Inventory Summary Report.xlsx";
                    link.click();
                    this.snackbar = {
                      active: true,
                      iconText: "check",
                      iconColor: "success",
                      message: "Successfully exported.",
                    };
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
              url: "/api/reports/inventorysummary/get",
              method: "GET",
              responseType: "blob",
              params: {
                type: "pdf",
                year: this.year,
                month:
                  new Date(Date.parse(this.month + " 1, 2020")).getMonth() + 1,
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
                  document.getElementById("print4").contentWindow.print();
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
  },
};
</script>