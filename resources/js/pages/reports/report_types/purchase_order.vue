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

      <v-card-actions class="px-0 justify-center">
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
        <!-- Date Picker -->
        <v-col cols="6" xl="2" lg="3" md="4" sm="6" class="my-auto">
          <v-card-actions class="pb-0 pt-4">
            <v-menu
              v-model="date1"
              :close-on-content-click="false"
              :nudge-right="35"
              transition="scale-transition"
              offset-y
              min-width="290px"
            >
              <template v-slot:activator="{ on }">
                <v-text-field
                  v-model="dateFromPO"
                  label="Date From"
                  prepend-icon="mdi-calendar-range"
                  readonly
                  v-on="on"
                  class="py-0"
                  dense
                ></v-text-field>
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
          </v-card-actions>
        </v-col>

        <v-col cols="6" xl="2" lg="3" md="4" sm="6" class="my-auto">
          <v-card-actions class="pb-0 pt-4">
            <v-menu
              v-model="date2"
              :close-on-content-click="false"
              :nudge-right="35"
              transition="scale-transition"
              offset-y
              min-width="290px"
            >
              <template v-slot:activator="{ on }">
                <v-text-field
                  v-model="dateUntilPO"
                  label="Date Until"
                  prepend-icon="mdi-calendar-range"
                  readonly
                  v-on="on"
                  class="py-0"
                  dense
                ></v-text-field>
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
          </v-card-actions>
        </v-col>
      </v-row>
    </v-container>
    <iframe id="print8" class="d-none" :src="print" frameborder="0"></iframe>
  </v-container>
</template>

<script>
import axios from "axios"; // Library for sending api request
export default {
  data: () => ({
    dateFromPO: null,
    dateUntilPO: null,
    print: "",
    date1: false,
    date2: false,
    snackbar: {
      active: false,
      message: "",
    },
  }),

  methods: {
    async get(type) {
      if (this.dateFromPO == null || this.dateUntilPO == null) {
        this.snackbar = {
          active: true,
          iconText: "alert",
          iconColor: "error",
          message: "Error! Please select a date first.",
        };
      } else {
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
              },
            }).then((response) => {
              // console.log(response.data);
              // return;
              let blob = new Blob([response.data], { type: "application/pdf" });
              let link = document.createElement("a");
              link.href = window.URL.createObjectURL(blob);
              link.download = "Purchase Order Report.pdf";
              link.click();
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
              },
            }).then((response) => {
              let blob = new Blob([response.data], { type: "application/pdf" });
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
            });

            break;
          case "excel":
            await axios
              .get("/api/reports/purchaseorder/get", {
                method: "GET",
                responseType: "arraybuffer",
                params: {
                  type: type,
                  from: this.dateFromPO,
                  to: this.dateUntilPO,
                },
              })
              .then((response) => {
                let blob = new Blob([response.data], {
                  type: "application/excel",
                });
                let link = document.createElement("a");
                link.href = window.URL.createObjectURL(blob);
                link.download = "Purchase Order Report.xlsx";
                link.click();
              });
            break;
          default:
            break;
        }
      }
    },
  },
};
</script>