<template>
  <v-container class="py-xl-3 py-lg-3 py-md-3 py-sm-2 py-2">
    <v-container class="pa-xl-4 pa-lg-4 pa-md-3 pa-sm-1 pa-0">
      <v-card-actions class="px-0 justify-center">
        <v-tooltip bottom>
          <template #activator="data">
            <v-btn
              color="primary"
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
              color="primary"
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
      <v-row no-gutters justify="center">
        <!-- Date Picker -->
        <v-col cols="6" xl="2" lg="3" md="6" sm="6" class="my-auto">
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
              ></v-date-picker>
            </v-menu>
          </v-card-actions>
        </v-col>

        <v-col cols="6" xl="2" lg="3" md="6" sm="6" class="my-auto">
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
              ></v-date-picker>
            </v-menu>
          </v-card-actions>
        </v-col>
      </v-row>
    </v-container>
  </v-container>
</template>

<script>
import axios from "axios"; // Library for sending api request
export default {
  data: () => ({
    dateFrom: null,
    dateUntil: null,
    date1: false,
    date2: false,
  }),
  methods: {
    async get(type) {
      switch (type) {
        case "pdf":
          await axios({
            url: "/api/reports/inventorysummary/get",
            method: "GET",
            responseType: "blob",
            params: { type: type, from: this.dateFrom, to: this.dateUntil },
          }).then((response) => {
            let blob = new Blob([response.data], { type: "application/pdf" });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = "Inventory Summary Report.pdf";
            link.click();
          });
          break;
        case "excel":
          await axios
            .get("/api/reports/inventorysummary/get", {
              method: "GET",
              responseType: "arraybuffer",
              params: { type: type },
            })
            .then((response) => {
              let blob = new Blob([response.data], {
                type: "application/excel",
              });
              let link = document.createElement("a");
              link.href = window.URL.createObjectURL(blob);
              link.download = "Inventory Summary Report.xlsx";
              link.click();
            });

          break;
        default:
          break;
      }
    },
  },
};
</script>