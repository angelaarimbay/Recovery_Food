<template>
  <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
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

    <v-row no-gutters justify="center" align="center">
      <v-col cols="6" class="px-1" style="max-width: 150px">
        <!-- Supplier -->
        <v-card-actions class="pb-1 pt-4 px-0">
          <v-select
            hide-details
            v-model="supplier"
            :items="suppnamelist"
            item-text="supplier_name"
            item-value="id"
            dense
            placeholder="Supplier"
            @change="get"
            background-color="grey darken-3"
            flat
            solo
            style="font-size: 12px"
            dark
          >
          </v-select>
        </v-card-actions>
      </v-col>

      <!-- Date Picker -->
      <v-col cols="6" class="px-1" style="max-width: 150px">
        <v-menu
          v-model="date1"
          :close-on-content-click="false"
          :nudge-right="35"
          transition="scale-transition"
          offset-y
          min-width="290px"
        >
          <template v-slot:activator="{ on }">
            <v-card-actions class="pb-1 pt-4 px-0">
              <v-text-field
                hide-details
                v-model="dateFromPO"
                placeholder="Date From"
                :prepend-inner-icon="showIcon ? 'mdi-calendar-range' : ''"
                readonly
                v-on="on"
                dense
                dark
                background-color="grey darken-3"
                flat
                solo
                style="font-size: 12px"
              ></v-text-field>
            </v-card-actions>
          </template>
          <v-date-picker
            v-model="dateFromPO"
            @input="date1 = false"
            scrollable
            no-title
            color="red darken-2"
            dark
          ></v-date-picker>
        </v-menu>
      </v-col>

      <!-- Date Picker -->
      <v-col cols="6" class="px-1" style="max-width: 150px">
        <v-menu
          v-model="date2"
          :close-on-content-click="false"
          :nudge-right="35"
          transition="scale-transition"
          offset-y
          min-width="290px"
        >
          <template v-slot:activator="{ on }">
            <v-card-actions class="pb-1 pt-4 px-0">
              <v-text-field
                hide-details
                v-model="dateUntilPO"
                placeholder="Date Until"
                :prepend-inner-icon="showIcon ? 'mdi-calendar-range' : ''"
                readonly
                v-on="on"
                dense
                background-color="grey darken-3"
                dark
                flat
                solo
                style="font-size: 12px"
              ></v-text-field>
            </v-card-actions>
          </template>
          <v-date-picker
            v-model="dateUntilPO"
            @input="date2 = false"
            scrollable
            no-title
            color="red darken-2"
            dark
          ></v-date-picker>
        </v-menu>
      </v-col>
    </v-row>
    <iframe id="print8" class="d-none" :src="print" frameborder="0"></iframe>
  </v-container>
</template>

<!-- Script -->
<script>
import axios from "axios"; // Library for sending api request
export default {
  //Computed
  computed: {
    showIcon() {
      if (this.$vuetify.breakpoint.smAndUp) {
        return true;
      } else {
        return false;
      }
    },
  },

  //Data
  data: () => ({
    dateFromPO: null,
    dateUntilPO: null,
    print: "",
    supplier: "",
    date1: false,
    date2: false,
    snackbar: {
      active: false,
      message: "",
    },
    overlay: false,
    suppnamelist: [],
  }),

  //Onload
  created() {
    this.dateFromPO = this.getFormatDate(
      new Date(new Date().getFullYear(), new Date().getMonth(), 1),
      "YYYY-MM-DD"
    );
    this.dateUntilPO = this.getFormatDate(
      new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0),
      "YYYY-MM-DD"
    );
    this.suppName();
  },

  //Methods
  methods: {
    getFormatDate(e, format) {
      const date = moment(e);
      return date.format(format);
    },

    //For retrieving supplier names
    async suppName() {
      await axios.get("/api/porder/suppName").then((supp_name) => {
        this.suppnamelist.push({ supplier_name: "All", id: "All" });
        for (var key in supp_name.data) {
          this.suppnamelist.push({
            supplier_name: supp_name.data[key]["supplier_name"],
            id: supp_name.data[key]["id"],
          });
        }
      });
    },

    //For exporting/printing
    async get(type) {
      if (this.dateFromPO == null || this.dateUntilPO == null) {
        this.snackbar = {
          active: true,
          iconText: "alert",
          iconColor: "error",
          message: "Error! Please select a date first.",
        };
      } else {
        this.overlay = true;
        switch (type) {
          case "pdf":
            await axios({
              url: "/api/reports/purchaseorder/get",
              method: "GET",
              responseType: "blob",
              params: {
                type: type,
                from: this.dateFromPO,
                to: this.dateUntilPO,
                supplier: this.supplier,
              },
            }).then((response) => {
              if (response.data.size > 0) {
                // console.log(response.data);
                // return;
                let blob = new Blob([response.data], {
                  type: "application/pdf",
                });
                let link = document.createElement("a");
                link.href = window.URL.createObjectURL(blob);
                link.download = "Purchase Order Report.pdf";
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
              url: "/api/reports/purchaseorder/get",
              method: "GET",
              responseType: "blob",
              params: {
                type: "pdf",
                from: this.dateFromPO,
                to: this.dateUntilPO,
                supplier: this.supplier,
              },
            }).then((response) => {
              if (response.data.size > 0) {
                axios
                  .get("/api/reports/purchaseorder/get", {
                    method: "GET",
                    responseType: "arraybuffer",
                    params: {
                      type: type,
                      from: this.dateFromPO,
                      to: this.dateUntilPO,
                      supplier: this.supplier,
                    },
                  })
                  .then((res) => {
                    let blob = new Blob([res.data], {
                      type: "application/excel",
                    });
                    let link = document.createElement("a");
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "Purchase Order Report.xlsx";
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
              url: "/api/reports/purchaseorder/get",
              method: "GET",
              responseType: "blob",
              params: {
                type: "pdf",
                from: this.dateFromPO,
                to: this.dateUntilPO,
                supplier: this.supplier,
              },
            }).then((response) => {
              // console.log(response.data);
              // return;
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
                  document.getElementById("print8").contentWindow.print();
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

<style>
.container {
  max-width: 1500px !important;
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